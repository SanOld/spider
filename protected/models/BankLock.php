<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class BankLock extends BaseModel {
  public $table = 'spi_bank_details_lock';
  public $post = array();
  public $select_all = ' * ';

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
    parent::getParamCommand($command, $params);

    return $command;
  }


  protected function doBeforeInsert($post) {

    return array (
      'result' => true,
      'params' => $post,
      'post' => $post
    );
  }
  
  
  protected function doAfterInsert($result, $params, $post) {
    return $result;
  }

}
