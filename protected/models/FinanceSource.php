<?php
require_once ('utils/utils.php');

class FinanceSource extends BaseModel {
  public $table = 'spi_finance_source';
  public $post = array();
  public $select_all = ' tbl.*, (SELECT name FROM spi_project_type spt WHERE spt.id = tbl.project_type_id) as type_name ';
//  public $isFinance = true;
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    
//    $where = ' 1=1 ';
//    $conditions = array();
//
//    if ($where) {
//      $command -> where($where, $conditions);
//    }
    
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    
    if (safe($params, 'PROJECT_TYPE_ID')) {
      $command->where("tbl.project_type_id = :project_type_id", array(':project_type_id' => $params['PROJECT_TYPE_ID']));
    }    
    return $command;
  }
  
}
