<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class UserType extends BaseModel {
  public $table = 'spi_user_type';
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

  protected function doAfterSelect($results) {
    foreach($results['result'] as &$row) {
      $row['relation_name'] = $this->getRelationNameByType($row['type']);
    }
    return $results;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $where = '';
    $params = array_change_key_case($params, CASE_UPPER);
    
    if (isset($params['SEARCH'])) {
      $fields = $this -> getAllTableFields();
      $search_param = array();
      $inttypes = array(
          'TINYINT',
          'SMALLINT',
          'MEDIUMINT',
          'INT',
          'BIGINT' 
      );
      $chartypes = array(
          'CHAR',
          'VARCHAR',
          'TEXT' 
      );
      if (!is_numeric($params['SEARCH'])) {
        $k = 0;
        foreach ( $fields as &$val ) {
          if (in_array(strtoupper($val['coltype']), $chartypes)) {
            if ($k == 0) {
              $k++;
              $where = 'tbl.' . $val['colname'] . " like :" . $val['colname'];
              $search_param[':' . $val['colname']] = '%' . $params['SEARCH'] . '%';
            } else {
              $where .= " OR tbl." . $val['colname'] . " like :" . $val['colname'];
              $search_param[':' . $val['colname']] = '%' . $params['SEARCH'] . '%';
            }
          }
        }
        unset($val);
      }
      $where = '(' . $where . ')';
      $command -> andWhere($where, $search_param);
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
  

  
//  protected function checkPermission($user, $action) {
//    switch ($action) {
//      case ACTION_SELECT : 
//        return true;
//        break;
//      case ACTION_INSERT :
//        ;
//      case ACTION_UPDATE :
//        ;
//      case ACTION_DELETE :
//        ;
//        if ($this -> user['is_super_admin']) {
//          return true;
//        } elseif ($this -> user['is_admin'] || $this -> user['is_account_owner']) {
//          return true;
//        }
//        return false;
//    }
//    return false;
//  }


}
