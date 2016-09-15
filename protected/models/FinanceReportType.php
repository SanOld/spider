<?php
require_once ('utils/utils.php');


class FinanceReportType extends BaseModel {
  public $table = 'spi_finance_report_type';
  public $post = array();
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }
  
//  protected function getParamCommand($command, array $params, array $logic = array()) {
//    parent::getParamCommand($command, $params);
//    $params = array_change_key_case($params, CASE_UPPER);
//    if(safe($params, 'LAST_RATE_ID')) {
//      $command -> andWhere('tbl.id = :last_rate_id + 1', array(':last_rate_id' => $params['LAST_RATE_ID']));
//    }
//    if(safe($params, 'RATE_ID')) {
//      $command -> andWhere('tbl.id = :rate_id', array(':rate_id' => $params['RATE_ID']));
//    }
//    $command = $this->setWhereByRole($command);
//    
//    return $command;
//  }
}
