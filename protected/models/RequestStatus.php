<?php
require_once ('utils/utils.php');


class RequestStatus extends BaseModel {
  public $table = 'spi_request_status';
  public $post = array();
  public $select_all = "tbl.* ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    return $command;
  }

  protected function doBeforeDelete($id) {
    $row = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table . ' tbl') -> where('id=:id', array(
      ':id' => $id
    )) -> queryRow();
    if (!$row) {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_NOT_EXISTS'
      );
    }

    return array(
      'result' => true
    );
  }
}
