<?php
require_once ('utils/utils.php');


class School extends BaseModel {
  public $table = 'spi_school';
  public $post = array();
  public $select_all = "tbl.*, dst.name district_name, sct.name type_name, CONCAT(`usr`.`first_name`, ' ', `usr`.`last_name`) contact_user_name";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command->join('spi_district dst',    'tbl.district_id = dst.id');
    $command->join('spi_school_type sct', 'tbl.type_id     = sct.id');
    $command->leftJoin('spi_user usr',    'tbl.contact_id  = usr.id');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command,
      array('tbl.name', 'tbl.address', "CONCAT(usr.first_name, ' ', usr.last_name)"),
      safe($params, 'KEYWORD'));
    if (isset($params['DISTRICT_ID'])) {
      $command -> andWhere("tbl.district_id = :district_id", array(':district_id' => $params['DISTRICT_ID']));
    }
    if (isset($params['TYPE_ID'])) {
      $command -> andWhere("tbl.type_id = :type_id", array(':type_id' => $params['TYPE_ID']));
    }
    return $command;
  }

  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        return true;
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        if($user['type'] == ADMIN && $user['type_id'] != 6) { // except Senat
          return true;
        }
        break;
    }
    return false;
  }

}
