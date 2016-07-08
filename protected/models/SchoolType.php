<?php
require_once ('utils/utils.php');


class SchoolType extends BaseModel {
  public $table = 'spi_school_type';
  public $post = array();
  public $select_all = " *, CONCAT('(', UPPER(code), ') ', name) full_name ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getCommandFilter() {
    $command = Yii::app()->db->createCommand()->select ('tbl.id, UPPER(tbl.code) code, tbl.name')
      ->from($this->table  . ' tbl');
    switch($this->user['type']) {
      case ADMIN:
        $command->Where('tbl.code != "z"');
    };
    $command = $this->setWhereByRole($command);
    $command->order('name');
    return $command;
  }

}
