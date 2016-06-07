<?php
require_once ('utils/utils.php');


class RequestSchoolConcept extends BaseModel {
  public $table = 'spi_request_school_concept';
  public $select_all = "tbl.*, scl.name school_name, scl.number school_number";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_school scl', 'tbl.school_id = scl.id');
    $command -> where('1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere('tbl.request_id = :request_id', array(':request_id' => $params['REQUEST_ID']));
    }
    return $command;
  }

  protected function doAfterSelect($result) {
    foreach($result['result'] as &$row) {
      $row['histories'] = $this->getHistoriesById($row['id']);
    }
//    print_r($result);exit;
    return $result;
  }

  private function getHistoriesById($concept_id) {
    $rows = Yii::app()->db->createCommand()
        ->select("aev.id, 
        CONCAT(usr.first_name, ' ', usr.last_name) user_name, 
        DATE_FORMAT(aev.event_date, '%d.%m.%Y') date, 
        adt.column_name,
        adt.old_value,
        adt.new_value")
        ->from('spi_audit_event aev')
        ->join('spi_audit_data adt', 'adt.event_id = aev.id')
        ->join('spi_user usr', 'aev.user_id = usr.id')
        ->where('aev.table_name =:table_name', array(':table_name' => $this->table))
        ->andWhere('aev.record_id = :id', array(':id' => $concept_id))
        ->andWhere("aev.event_type = 'UPD'")
        ->order("aev.event_date DESC")
        ->queryAll();
    $result = array();
    foreach($rows as $row) {
      $id = $row['id'];
      if(!isset($result[$id])) $result[$id] = array();
      $result[$id]['date']      = $row['date'];
      $result[$id]['user_name'] = $row['user_name'];
      switch($row['column_name']) {
        case 'status':
          $result[$id]['status_code'] = $row['new_value'];
          $result[$id]['status_name'] = $this->getStatusByCode($row['new_value']);
          break;
        case 'comment':
          $result[$id]['comment'] = $row['new_value'];
          break;
        default:
          if(!isset($result[$id]['changes'])) $result[$id]['changes'] = array();
          $result[$id]['changes'][] = array(
            'code' => $row['column_name'],
            'name' => $this->getFieldNameByColumnName($row['column_name']),
            'old'  => $row['old_value'],
            'new'  => $row['new_value'],
          );
          break;
      }
    }
    return $result;
  }

  private function getFieldNameByColumnName($column_name) {
    switch ($column_name) {
      case 'situation';
        return 'Situation an der Schule';
        break;
      case 'offers_youth_social_work';
        return 'Angebote der Jugendsozialarbeit an der Schule';
        break;
    }
    return '';
  }

  private function getStatusByCode($code) {
    switch ($code) {
      case 'd':
        return 'Ablehnen';
      case 'r':
        return 'Bereit zu überprüfen';
      case 'a':
        return 'Genehmigt';
    }
    return '';
  }

  protected function doAfterUpdate($result, $params, $post, $id) {
    if($result['result'] && safe($post, 'status')) {
      $request_id = Yii::app()->db->createCommand()
        ->select('request_id')
        ->from($this -> table)
        ->where('id=:id', array(':id' => $id))
        ->queryScalar();
      if($status = $this->getCommonStatus($request_id)) {
        Yii::app()->db->createCommand()->update('spi_request', array('status_concept' => $status));
      }
    }
    return $result;
  }

  private function getCommonStatus($request_id) {
    return Yii::app()->db->createCommand()
      ->select('status')
      ->from($this -> table)
      ->where('request_id=:request_id', array(':request_id' => $request_id))
      ->order("FIELD(status, 'd', 'r', 'a')")
      ->queryScalar();
  }

}