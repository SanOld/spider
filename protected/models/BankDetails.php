<?php
require_once ('utils/utils.php');

class BankDetails extends BaseModel {
  public $table = 'spi_bank_details';
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
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'ID')) {
      $command->andWhere("tbl.id = :id", array(':id' => $params['ID']));
    }
    return $command;
  }

  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        if($user['type'] == ADMIN || ($user['type'] == TA && $user['is_finansist'])) {
          return true;
        }
        break;
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        if($user['type'] == ADMIN && !in_array($user['type_id'], array(6)) || ($user['type'] == TA && $user['is_finansist'])) {
          return true;
        }
        break;
    }
    return false;
  }

}
