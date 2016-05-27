<?php
require_once ('utils/utils.php');

class FinanceSource extends BaseModel {
  public $table = 'spi_finance_source';
  public $post = array();
  public $select_all = ' *, (SELECT name FROM spi_project_type spt WHERE spt.id = tbl.project_type_id) as type_name ';
  public $isFinance = true;
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    
    $where = ' 1=1 ';
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }
    
    return $command;
  }

}
