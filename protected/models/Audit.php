<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class Audit extends BaseModel {
  public $table = 'spi_audit_event';
  public $post = array();
  public $operations = array('INS' => 'Added', 'UPD' => 'Changed', 'DEL' => 'Deleted');
  public $select_all = ' tbl.*, usr.first_name, usr.last_name';
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command->leftJoin('spi_user usr', 'usr.id=tbl.user_id ');
    $where = ' 1=1 AND user_id IS NOT NULL';
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }
    
    return $command;
  }
  protected function doAfterSelect($result) {
    foreach($result['result'] as &$row) {
      $row['data'] = Yii::app() -> db -> createCommand() 
                                      -> select('*') 
                                      -> from('spi_audit_data aud')
                                      -> where('aud.event_id=:id', array(':id' => $row['id']))
                                      -> queryAll();
      $row['user_name'] = $row['first_name'].' '.$row['last_name'];
      $row['operation_name'] = $this->operations[$row['event_type']];
      $row['date_formated'] = date('d.m.y',strtotime($row['event_date']));
    }
    return $result;
  }


  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);

    if(safe($params, 'EVENT_TYPE')) {
      $command->andWhere('tbl.event_type = :et', array(':et' => safe($params, 'EVENT_TYPE')));
    }
    if(safe($params, 'EVENT_DATE')) {
      $command->andWhere('tbl.event_date = :ed', array(':ed' => safe($params, 'EVENT_DATE')));
    }
    if(safe($params, 'TABLE_NAME')) {
      $command->andWhere('tbl.table_name = :tn', array(':tn' => safe($params, 'TABLE_NAME')));
    }
    
    return $command;
  }
  
  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        return $user['can_view'];
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        return false;
    }
    return false;
  }

}
