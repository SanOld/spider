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

  protected function doAfterSelect($result) {
    $activity_ids = array();
    foreach($result['result'] as &$row) {
      $row['virtual'] = 0;
      if(in_array($row['code'], array('open', 'in_progress', 'acceptable', 'accept'))) {
        $activity_ids[] = $row['id'];
      }
    }
    if($activity_ids) {
      array_unshift($result['result'], array('id' => implode(',', $activity_ids), 'code' => 'active_all', 'name' => '(Active all)', 'virtual' => 1));
    }
    return $result;
  }

}
