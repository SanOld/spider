<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class SchoolLock extends BaseModel {
  public $table = 'spi_school_lock';
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
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere("tbl.request_id = :request_id", array(':request_id' => $params['REQUEST_ID']));
    }
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
