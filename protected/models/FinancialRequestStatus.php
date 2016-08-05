<?php
require_once ('utils/utils.php');


class FinancialRequestStatus extends BaseModel {
  public $table = 'spi_financial_request_status';
  public $post = array();
  public $select_all = "tbl.* ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

}
