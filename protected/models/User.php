<?php
require_once ('utils/utils.php');


class User extends BaseModel {
  public $table = 'spi_user';
  public $post = array();
  public $select_all = "CONCAT(tbl.first_name, ' ', tbl.last_name) name, IF(tbl.is_active = 1, 'Aktiv', 'Deaktivieren') status_name, ust.name type_name, tbl.* ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_user_type ust', 'tbl.type_id = ust.id');
    $command -> where(' 1=1 ', array());
    return $command;
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
    if (safe($params, 'TYPE')) {
      $command->andWhere("tbl.type = :type", array(':type' => $params['TYPE']));
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
    if (safe($params, 'SCHOOL_ID')) {
      $type = 's';
      $relation = $this->getRelationByType($type);
      if($relation && safe($relation, 'code')) {
        $command->join($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id AND tbl.type = "'.$type.'"');
        $command->andWhere("tbl.relation_id = :relation_id", array(':relation_id' => $params['SCHOOL_ID']));
      }
    }
    if (safe($params, 'DISTRICT_ID')) {
      $type = 'd';
      $relation = $this->getRelationByType($type);
      if($relation && safe($relation, 'code')) {
        $command->join($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id AND tbl.type = "'.$type.'"');
        $command->andWhere("tbl.relation_id = :relation_id", array(':relation_id' => $params['DISTRICT_ID']));
      }
    }
    return $command;
  }

  protected function calcResults($result) {
    foreach($result['result'] as &$row) {
      $relation = $this->getRelationByType($row['type']);
      if($relation && safe($relation, 'table')) {
        $row['relation_name'] = Yii::app() -> db -> createCommand() -> select('name')
          -> from($relation['table']) -> where('id=:id', array(':id' => $row['relation_id'])) ->queryScalar();
      }
    }
    return $result;
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
      if($post['type'] == 't') {
        $post['is_finansist'] = $post['type_id'] == 7 ? 1 : 0;
      }
      $relation = $this->getRelationByType($post['type']);
      if(!safe($post, 'relation_id') && $relation && safe($relation, 'table')) {
        return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_REQUIRED_FIELD',
          'message' => 'Insert failed: Field relation_id required for this user type.'
        );
      }
    }

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

    if(safe($post, 'type_id') == 7) {
      $post['is_finansist'] = 1;
    } elseif(safe($post, 'type_id') == 3) {
      $post['is_finansist'] = 0;
    }

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


}
