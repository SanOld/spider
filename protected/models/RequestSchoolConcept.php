<?php
require_once ('utils/utils.php');


class RequestSchoolConcept extends BaseModel {
  public $table = 'spi_request_school_concept';
  public $select_all = "tbl.*
                      , IF(rqt.status_id >=4, tbl.school_name, scl.name)     name
                      , IF(rqt.status_id >=4, tbl.school_number, scl.number) number
                      ";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_school scl',  'tbl.school_id = scl.id');
    $command -> join('spi_request rqt', 'tbl.request_id = rqt.id');
    $command -> where('1=1 ', array());
    return $command;
  }

}
