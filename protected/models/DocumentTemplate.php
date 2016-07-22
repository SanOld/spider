<?php
require_once ('utils/utils.php');


class DocumentTemplate extends BaseModel {
  public $table = 'spi_document_template';
  public $post = array();
  public $select_all = ' tbl.*, type.name type_name, CONCAT(user.first_name, " ", user.last_name ) user_name ';

  public $requestData = array();
  public $performerData = array();


  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
      -> from($this -> table . ' tbl')
      -> join('spi_document_template_type type', 'tbl.type_id = type.id')
      -> leftJoin('spi_user user', 'tbl.user_id = user.id');

    $where = ' 1=1 ';
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }

    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command,array('tbl.name', 'type.name'),safe($params, 'KEYWORD'));
    if (isset($params['TYPE_ID'])) {
      $command -> andWhere("tbl.type_id = :type_id", array(':type_id' => $params['TYPE_ID']));
    }
    if (isset($params['IDS'])) {
      $command -> andWhere(array('in', 'tbl.id', $params['IDS']));
    }
    return $command;
  }

  protected function doBeforeInsert($post) {

    $post['user_id'] = $this->user['id'];
    
            
    $post['type_code'] = Yii::app() -> db -> createCommand() -> select('code') -> from('spi_document_template_type') -> where('id=:id ', array(
        ':id' => $post['type_id']
    )) ->queryScalar();

    return array(
      'result' => true,
      'params' => $post
    );
  }

  protected function doBeforeUpdate($post, $id) {

    $post['user_id'] = $this->user['id'];
    $post['last_change'] = date('c', time());
    
    if(safe($post,'type_id')) {
      $post['type_code'] = Yii::app() -> db -> createCommand() -> select('code') -> from('spi_document_template_type') -> where('id=:id ', array(
          ':id' => $post['type_id']
      )) -> queryScalar();
    }
    
    return array(
      'result' => true,
      'params' => $post
    );

  }



  protected function calcResults($result) {
    if(safe($_GET, 'prepare') == '1' && safe($_GET, 'request_id')) {
      $Request = CActiveRecord::model('Request');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('id' => safe($_GET, 'request_id')), true);
      $this->requestData = $requestInfo['result'][0];


      $requestTableData = Yii::app() -> db -> createCommand() -> select("*, DATE_FORMAT(start_date,'%d.%m.%Y') start_date_formated,  DATE_FORMAT(due_date,'%d.%m.%Y') due_date_formated") -> from('spi_request') -> where('id=:id ', array(':id' => safe($_GET, 'request_id'))) -> queryRow();
      $this->performerData = Yii::app() -> db -> createCommand() -> select('*') -> from('spi_performer') -> where('id=:id ', array(':id' => $requestData['performer_id'])) -> queryRow();

      foreach($result['result'] as &$row) {
        $row['text'] = $this->prepareText($row['text'] );
      }
    }
    return $result;
  }

  protected function prepareText($text) {

    $text = preg_replace_callback("/\{FOREACH=SCHOOL\}.+\{FOREACH_END\}/i", array($this, 'repeatSchool'), $text);

    $params = array(
        '{AUFLAGEN}'      => $this->requestData['senat_additional_info'],
        '{FOERDERSUMME}'  => $this->requestData['total_cost'],
        '{JAHR}'          => $this->requestData['year'],
        '{KENNZIFFER}'    => Yii::app()->db->createCommand()->select('code')->from('spi_project')->where('id=:id', array(':id' => $this->requestData['project_id']))->queryScalar(),
        '{TRAEGER}'        => $this->performerData['name'],
        '{TRAGERADRESSE}' => $this->performerData['address'],
        '{ZEITRAUM}'      => 'Beginn: '.$this->requestData['start_date_formated'].' Ende: '.$this->requestData['due_date_formated']
      );
    
    return $this->doReplace($text,$params);
  }

  private function repeatSchool($data){
    $text = array();
    foreach ($this->requestData['schools'] as $key => $school) {
      $params = array(
          '{FOREACH=SCHOOL}'  => '',
          '{FOREACH_END}'     => '',
          '{SCHOOLNAME}'      => $school['name'],
          '{SCHOOLNUMBER}'    => $school['number'],
        );
      
      $text[] = $this->doReplace($data[0],$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }

  private function doReplace($_text, $params){
    $text = $_text;
    if($text && $text != '') {
      $data = array();
      $placeholders = array();
      foreach($params as $key=>$val) {
        $data[] = $val;
        $placeholders[] = $key;
      }
      $text = str_replace($placeholders, $data, $text);
      return $text;
    }
    return '';
  }
}
