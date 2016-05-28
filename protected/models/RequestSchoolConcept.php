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

}