<?php
require_once ('utils/utils.php');


class SchoolGoal extends BaseModel {
  public $table = 'spi_school_goal';
  public $post = array();
  public $select_all = ' tbl.*, type.name type_name, CONCAT(user.first_name, " ", user.last_name ) user_name ';

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
      -> from($this -> table . ' tbl')
      -> join('spi_school sch',   'tbl.school_id = sch.id');

    $where = ' 1=1 ';
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }

    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);

    if (isset($params['REQUEST_ID'])) {
      $command -> where('tbl.request_id = :request_id', array(':request_id' => $params['REQUEST_ID']));
    }
    return $command;
  }





}
