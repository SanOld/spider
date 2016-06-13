<?php
require_once ('utils/utils.php');


class RequestProfAssociation extends BaseModel {
  public $table = 'spi_request_prof_association';
  public $select_all = "tbl.*";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
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

}