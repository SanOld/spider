<?php
require_once ('utils/utils.php');


class PaymentMethodType extends BaseModel {
  public $table = 'spi_payment_method_type';
  public $post = array();
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }
}
