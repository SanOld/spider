<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class Hint extends BaseModel {
  public $table = 'spi_hint';
  public $post = array();
  public $select_all = ' tbl.*, pag.name page_name, pgp.name position_name, pgp.code position_code ';
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
      -> from($this -> table . ' tbl')
      -> join('spi_page pag', 'tbl.page_id = pag.id')
      -> leftJoin('spi_page_position pgp', 'tbl.position_id = pgp.id');
    
    $where = ' 1=1 ';
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }
    
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    if (safe($params, 'PAGE_ID')) {
      $command->andWhere("tbl.page_id = :page_id", array(':page_id' => $params['PAGE_ID']));
    }
    if (safe($params, 'PAGE_CODE')) {
      $command->andWhere("pag.code = :page_code", array(':page_code' => $params['PAGE_CODE']));
    }
    if (safe($params, 'POSITION')) {
      $command->andWhere("pgp.name like :position", array(':position' => '%' . $params['POSITION'] . '%'));
    }
    return $command;
  }

  protected function doBeforeDelete($id) {
    $user = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table . ' tbl') -> where('id=:id', array(
        ':id' => $id 
    )) -> queryRow();
    if (!$user) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_NOT_EXISTS' 
      );
    }
    return array(
        'result' => true 
    );
  }

  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        if($user['type'] == ADMIN && $user['type_id'] != 6) { // except Senat
          return true;
        }
    }
    return false;
  }

}
