<?php
require_once ('utils/utils.php');


class FinanceCostType extends BaseModel {
  public $table = 'spi_finance_cost_type';
  public $post = array();
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'REPORT_TYPE_ID')) {
      $command -> andWhere('tbl.report_type_id = :report_type_id', array(':report_type_id' => $params['REPORT_TYPE_ID']));
    }
    
    return $command;
  }
}
