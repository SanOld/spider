<?php
require_once ('utils/utils.php');


class RequestGoal extends BaseModel {
  public $table = 'spi_request_goal';
  public $post = array();
  public $select_all = " tbl.*, gl.name goal_name ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_goal gl', 'tbl.goal_id = gl.id');
    $command -> where(' 1=1 ', array());
    return $command;
  }
}
