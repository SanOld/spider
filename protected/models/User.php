<?php
require_once ('utils/utils.php');
require_once ('utils/email.php');


class User extends BaseModel {
  public $table = 'spi_user';
  public $post = array();
  public $select_all = "CONCAT(tbl.first_name, ' ', tbl.last_name) name, IF(tbl.is_active = 1, 'Aktiv', 'Deaktivieren') status_name, IF(tbl.type = 't' AND tbl.is_finansist, CONCAT(ust.name, ' (F)'), ust.name) type_name, tbl.* ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_user_type ust', 'tbl.type_id = ust.id');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getCommandFilter() {
    return Yii::app ()->db->createCommand ()->select ("id, CONCAT(first_name, ' ', last_name) name, function, phone, title, email")->from ( $this->table  . ' tbl') -> order('name');
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command,
          array('tbl.first_name', 'tbl.last_name', 'tbl.login', 'tbl.email'),
          safe($params, 'KEYWORD'));
    if (safe($params, 'RELATION_NAME')) {
      $value = $params['RELATION_NAME'];
      $where = array();
      $search_param = array();
      foreach(explode(',', USER_TYPES) as $type) {
        $relation = $this->getRelationByType($type);
        if($relation && safe($relation, 'code')) {
          $command->leftJoin($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id');
          $where[] = "({$relation['prefix']}.name like :value AND ust.type = '".$type."')";
          $search_param[":value"] = '%' . $value . '%';
        }
      }
      if($where && $search_param) {
        $where = implode(' OR ', $where);
        $command -> andWhere($where, $search_param);
      }
    }
    if (safe($params, 'TYPE_ID')) {
      $command->andWhere("tbl.type_id = :type_id", array(':type_id' => $params['TYPE_ID']));
    }
    if (isset($params['IS_FINANSIST'])) {
      $command -> andWhere("tbl.is_finansist = :is_finansist", array(':is_finansist' => $params['IS_FINANSIST']));
    }
    if (isset($params['IS_ACTIVE'])) {
      $command -> andWhere("tbl.is_active = :is_active", array(':is_active' => $params['IS_ACTIVE']));
    }
    if(safe($params, 'ORDER') == 'relation_name') {
      $fields = array();
      foreach(explode(',', USER_TYPES) as $type) {
        $relation = $this->getRelationByType($type);
        if($relation && safe($relation, 'code')) {
          $command->leftJoin($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id AND tbl.type = "'.$type.'"');
          $fields[] = "IFNULL(".$relation['prefix'].".name, '')";
        }
      }
      if($fields) {
        $command->select($this->select_all.", CONCAT(".implode(',', $fields).") relation_name");
      }

    }
    if (safe($params, 'RELATION_ID')) {
      $command->andWhere("tbl.relation_id = :relation_id", array(':relation_id' => $params['RELATION_ID']));
    }
    if (safe($params, 'TYPE')) {
      $command->andWhere("tbl.type = :type", array(':type' => $params['TYPE']));
    }
    if (safe($params, 'AUTH_TOKEN')) {
      $command->andWhere("tbl.auth_token = :auth_token", array(':auth_token' => $params['AUTH_TOKEN']));
    }

    if($this->user['relation_id']) {
      $command = $this->setWhereByRole($command);
    }
    return $command;
  }

  protected function setWhereByRole($command) {
    switch($this->user['type']) {
      case SCHOOL:
        $command->andWhere('(tbl.relation_id = :relation_id AND tbl.type = :type) OR (tbl.type_id = 1) '.
          'OR (tbl.relation_id IN (SELECT performer_id FROM spi_project WHERE id IN('.
          'SELECT project_id FROM spi_project_school WHERE school_id = :relation_id)) AND tbl.type = "t") '.
          'OR (tbl.relation_id IN (SELECT district_id FROM spi_project WHERE id IN('.
          'SELECT project_id FROM spi_project_school WHERE school_id = :relation_id)) AND tbl.type = "d") ',
          array(':relation_id' => $this->user['relation_id'], ':type' => $this->user['type']));
        break;
      case DISTRICT:
      case TA:
        $command->andWhere('(tbl.relation_id = :relation_id AND tbl.type = :type) OR tbl.type_id = 1', array(':relation_id' => $this->user['relation_id'], ':type' => $this->user['type']));
        break;
    }
    return $command;
  }

  protected function calcResults($result) {
    if(!$this->isFilter) {
      foreach ($result['result'] as &$row) {
        $relation = $this->getRelationByType($row['type']);
        if ($relation && safe($relation, 'table')) {
          $row['relation_name'] = Yii::app()->db->createCommand()->select('name')->from($relation['table'])->where('id=:id', array(':id' => $row['relation_id']))->queryScalar();
        }
      }
    }
    return $result;
  }

  protected function doAfterSelect($results) {
    foreach($results['result'] as &$row) {
      unset($row['password']); 
    }
    return $results;
  }

  protected function doBeforeInsert($post) {
    $this->post = $post;
    $login = safe($post,'login');
    $email = safe($post,'email');

    if(safe($post, 'type_id')) {
      $post['type'] = Yii::app() -> db -> createCommand() -> select('type') -> from('spi_user_type')
        -> where('id=:id ', array(
          ':id' => $post['type_id']))
        -> queryScalar();
      $relation = $this->getRelationByType($post['type']);
      if(!safe($post, 'relation_id') && $relation && safe($relation, 'table')) {
        return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_MISSED_REQUIRED_PARAMETERS',
          'message' => 'Insert failed: Field relation required for this user type.'
        );
      }
    }

    if ($login && Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('login=:login', array(
        ':login' => $login 
    )) -> queryRow()) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_DUPLICATED'
      );
    }

    if ($email && Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('email = :email', array(
        ':email' => $email 
    )) -> queryRow()) {
      return array(
        'code' => '409',
        'result' => false,
        'silent' => true,
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

    if($row['is_finansist'] != $post['is_finansist'] && $row['type'] != 't') {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_UPDATE_FORBIDDEN',
        'message' => 'Update failed: The finansist can not be change.'
      );
    }


    if(safe($post, 'type_id') && $row['type_id'] != $post['type_id'] && !(in_array($row['type_id'], array(3,7)) && in_array($post['type_id'], array(3,7)))) {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_UPDATE_FORBIDDEN',
        'message' => 'Update failed: The type can not be change.'
      );
    }

    if(safe($post, 'relation_id') && $row['relation_id'] != $post['relation_id']) {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_UPDATE_FORBIDDEN',
        'message' => 'Update failed: The relation can not be change.'
      );
    }

    if($id == $this->user['id'] && !($this->user['can_edit'] && $this->user['type_id'] != 2) && $row['login'] != $post['login']) {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_UPDATE_FORBIDDEN',
        'message' => 'Update failed: The username can not be change.'
      );
    }

    if (Yii::app() -> db -> createCommand()
        -> select('*') 
        -> from($this -> table) 
        -> where('id != :id AND login=:login',
                  array(':id' => $id, ':login' => $post['login']))
         -> queryRow()) {
      return array(
          'code' => '409',
          'result' => false,
          'silent' => true,
          'system_code' => 'ERR_DUPLICATED'
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
        'silent' => true,
        'system_code' => 'ERR_DUPLICATED_EMAIL'
      );
    }

    if (isset($param['PASSWORD']) && $this->user['id'] == $row['id'] && md5($param['OLD_PASSWORD']) != $row['password']) {
      return array(
        'code' => '409',
        'result' => false,
        'silent' => true,
        'system_code' => 'ERR_CURRENT_PASSWORD'
      );
    }

    unset($post['old_password']);

    return array(
        'result' => true,
        'params' => $post 
    );
  }

  protected function doAfterUpdate($result, $params, $post, $id) {
    if(safe($post, 'password')) {
      $user = Yii::app() -> db -> createCommand()
        -> select('*')
        -> from($this->table)
        -> where('id=:id', array(':id' => $id))
        ->queryRow();
      Email::doUpdatePassword($user, $post['password']);
    }
    return $result;
  }

  protected function doAfterInsert($result, $params, $post) {
    if($result['result']) {
      Email::doWelcome($params);
    }
    return $result;
  }

  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        return $user['can_view'] || $user['id'] == $this->id;
      case ACTION_UPDATE:
        return $user['can_edit'] || $user['id'] == $this->id;
      case ACTION_INSERT:
        return $user['can_edit'] && !(in_array($user['type_id'], array(6,2)) && $data['type_id'] == 1); // except PA & Senat create Admin
      case ACTION_DELETE:
        return $user['can_edit'] && $user['type_id'] != 2; // except PA
    }
    return false;
  }


}
