<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class User extends BaseModel {
  public $table = 'spi_user';
  public $post = array();
  public $select_all = ' * ';
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    
    $where = ' 1=1 ';
    $conditions = array();
    
//    if (!in_array(safe($this->user, 'type_code'), array('t','a'))) {
//      $where .= ' AND act.id=:actId ';
//      $conditions[':actId'] = $this -> user['account_id'];
//    }
//    
    
    if ($where) {
      $command -> where($where, $conditions);
    }
    
    return $command;
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

  protected function doAfterSelect($results) {
    
    $types = Yii::app() -> db -> createCommand() -> select('*') -> from('spi_user_type tbl')->queryAll ();
    $types_dict = array();
    foreach($types as $type) {
      $types_dict[$type['id']] = $type;
    }
    foreach($results['result'] as &$row) {
      $row['type_name'] = $types_dict[$row['type_id']]['name'];
      unset($row['password']); 
    }
    return $results;
  }

  protected function doBeforeInsert($post) {
    $this->post = $post;
//    unset($post['ref']);
    $login = safe($post,'login');
    $email = safe($post,'email');
//    $account = isset($post['account_id']) ? $post['account_id'] : '';
//    $is_account_owner = isset($post['is_account_owner']) ? $post['is_account_owner'] : '';
//    $is_admin = isset($post['is_admin']) ? $post['is_admin'] : '';
    if ($this -> user['type'] != ADMIN && $this -> user['type'] != PA) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_PERMISSION' 
      );
    }
    
   
    if ($login && Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('login=:login', array(
        ':login' => $login 
    )) -> queryRow()) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_DUPLICATED', 
          'message' => 'Insert failed: This Username already registered.'
      );
    }

    if ($email && Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('email = :email', array(
        ':email' => $email 
    )) -> queryRow()) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_DUPLICATED_EMAIL' 
      );
    }
    
    
    return array(
        'result' => true,
        'params' => $post 
    );
  }

  protected function doBeforeUpdate($post, $id) {
    $param = array_change_key_case($post,CASE_UPPER);
    $row = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('id=:id ', array(
        ':id' => $id
    )) -> queryRow();
        
    if (Yii::app() -> db -> createCommand()
        -> select('*') 
        -> from($this -> table) 
        -> where('id!=:id ' . 'AND login=:login',
                  array(
                  ':id' => $id,
                  ':login' => $row['login']))
         -> queryRow()) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_DUPLICATED', 
          'message' => 'This Username already registered'
      );
    }
    
    if (isset($param['EMAIL']) && $param['EMAIL'] && Yii::app() -> db -> createCommand() 
        -> select('*')
        -> from($this -> table) 
        -> where('email = :email AND id!=:id', 
                  array(
                  ':email' => $param['EMAIL'],
                  ':id' => $id))
         -> queryRow()) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_DUPLICATED_EMAIL'
      );
    }
    
    return array(
        'result' => true,
        'params' => $post 
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

  public function __construct() {
//    parent::__construct();
//    $this -> execute();
//    exit();
  }
}
