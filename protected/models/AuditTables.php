<?php
require_once ('utils/utils.php');


class AuditTables extends BaseModel {
  public $table = 'spi_audit_setting';
  public $post = array();
  public $select_all = " id, name, table_name ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' name IS NOT NULL ', array());
    return $command;
  }

//  protected function getCommandFilter() {
//    $command = Yii::app()->db->createCommand()->select ('tbl.id, UPPER(tbl.code) code, tbl.name')
//      ->from($this->table  . ' tbl');
//    $command = $this->setWhereByRole($command);
//    $command->order('name');
//    return $command;
//  }

}
