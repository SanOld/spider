<?php
require_once ('utils/utils.php');


class DocumentTemplate extends BaseModel {
  public $table = 'spi_document_template';
  public $post = array();
  public $select_all = ' tbl.*, type.name type_name, CONCAT(user.first_name, " ", user.last_name ) user_name ';


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
      foreach($result['result'] as &$row) {
        
        $requestData = Yii::app() -> db -> createCommand() -> select("*, DATE_FORMAT(start_date,'%d.%m.%Y') start_date_formated,  DATE_FORMAT(due_date,'%d.%m.%Y') due_date_formated") -> from('spi_request') -> where('id=:id ', array(':id' => safe($_GET, 'request_id'))) -> queryRow();
        $performerData = Yii::app() -> db -> createCommand() -> select('*') -> from('spi_performer') -> where('id=:id ', array(':id' => $requestData['performer_id'])) -> queryRow();

        $row['text'] = $this->prepareText($row['text'], $requestData, $performerData);
      }
    }
    return $result;
  }

  protected function prepareText($text, $requestData, $performerData) {
    
    $params = array(
        '{AUFLAGEN}'      => $requestData['senat_additional_info'],
        '{FOERDERSUMME}'  => $requestData['total_cost'],
        '{JAHR}'          => $requestData['year'],
        '{KENNZIFFER}'    => Yii::app()->db->createCommand()->select('code')->from('spi_project')->where('id=:id', array(':id' => $requestData['project_id']))->queryScalar(),
        '{TRAEGER}'        => $performerData['name'],
        '{TRAGERADRESSE}' => $performerData['address'],
        '{ZEITRAUM}'      => 'Beginn: '.$requestData['start_date_formated'].' Ende: '.$requestData['due_date_formated']
                             
      );
    
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
