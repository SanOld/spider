<?php
require_once ('utils/utils.php');

class BankDetails extends BaseModel {
  public $table = 'spi_bank_details';
  public $post = array();
  public $select_all = ' * ';
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


  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'ID')) {
      $command->andWhere("tbl.id = :id", array(':id' => $params['ID']));
    }
    return $command;
  }

}
