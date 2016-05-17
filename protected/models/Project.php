<?php
require_once ('utils/utils.php');


class Project extends BaseModel {
  public $table = 'spi_project';
  public $post = array();
  public $select_all = "*";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

//  protected function getParamCommand($command, array $params, array $logic = array()) {
//    $params = array_change_key_case($params, CASE_UPPER);
//    $command = $this->setLikeWhere($command,
//          array('tbl.first_name', 'tbl.last_name', 'tbl.login', 'tbl.email'),
//          safe($params, 'KEYWORD'));
//    if (safe($params, 'RELATION_NAME')) {
//      $value = $params['RELATION_NAME'];
//      $where = array();
//      $search_param = array();
//      foreach(explode(',', USER_TYPES) as $type) {
//        $relation = $this->getRelationByType($type);
//        if($relation && safe($relation, 'code')) {
//          $command->leftJoin($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id');
//          $where[] = "({$relation['prefix']}.name like :value AND ust.type = '".$type."')";
//          $search_param[":value"] = '%' . $value . '%';
//        }
//      }
//      if($where && $search_param) {
//        $where = implode(' OR ', $where);
//        $command -> andWhere($where, $search_param);
//      }
//    }
//    if (safe($params, 'TYPE')) {
//      $command->andWhere("tbl.type = :type", array(':type' => $params['TYPE']));
//    }
//    if (safe($params, 'TYPE_ID')) {
//      $command->andWhere("tbl.type_id = :type_id", array(':type_id' => $params['TYPE_ID']));
//    }
//    if (isset($params['IS_FINANSIST'])) {
//      $command -> andWhere("tbl.is_finansist = :is_finansist", array(':is_finansist' => $params['IS_FINANSIST']));
//    }
//    if (isset($params['IS_ACTIVE'])) {
//      $command -> andWhere("tbl.is_active = :is_active", array(':is_active' => $params['IS_ACTIVE']));
//    }
//    if(safe($params, 'ORDER') == 'relation_name') {
//      $fields = array();
//      foreach(explode(',', USER_TYPES) as $type) {
//        $relation = $this->getRelationByType($type);
//        if($relation && safe($relation, 'code')) {
//          $command->leftJoin($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id AND tbl.type = "'.$type.'"');
//          $fields[] = "IFNULL(".$relation['prefix'].".name, '')";
//        }
//      }
//      if($fields) {
//        $command->select($this->select_all.", CONCAT(".implode(',', $fields).") relation_name");
//      }
//
//    }
//    if (safe($params, 'SCHOOL_ID')) {
//      $type = 's';
//      $relation = $this->getRelationByType($type);
//      if($relation && safe($relation, 'code')) {
//        $command->join($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id AND tbl.type = "'.$type.'"');
//        $command->andWhere("tbl.relation_id = :relation_id", array(':relation_id' => $params['SCHOOL_ID']));
//      }
//    }
//    if (safe($params, 'DISTRICT_ID')) {
//      $type = 'd';
//      $relation = $this->getRelationByType($type);
//      if($relation && safe($relation, 'code')) {
//        $command->join($relation['table'].' '.$relation['prefix'], $relation['prefix'].'.id=tbl.relation_id AND tbl.type = "'.$type.'"');
//        $command->andWhere("tbl.relation_id = :relation_id", array(':relation_id' => $params['DISTRICT_ID']));
//      }
//    }
//    return $command;
//  }

//  protected function calcResults($result) {
//    foreach($result['result'] as &$row) {
//      $relation = $this->getRelationByType($row['type']);
//      if($relation && safe($relation, 'table')) {
//        $row['relation_name'] = Yii::app() -> db -> createCommand() -> select('name')
//          -> from($relation['table']) -> where('id=:id', array(':id' => $row['relation_id'])) ->queryScalar();
//      }
//    }
//    return $result;
//  }

  protected function doAfterSelect($results) {
    foreach($results['result'] as &$row) {
//      $relation = $this->getSchools($row['id']);
      $schools = Yii::app() -> db -> createCommand() 
        -> select('scl.*') -> from('spi_project_school prs')
        -> leftJoin('spi_school scl', 'prs.school_id=scl.id')
        -> where('project_id=:id', array(
        ':id' => $row['id'] 
      )) -> queryAll();
      $row['schools'] = $schools;
      
      $performer = Yii::app() -> db -> createCommand() 
        -> select('*') -> from('spi_performer')
        -> where('id=:id', array(
        ':id' => $row['performer_id'] 
      )) -> queryRow();
      $row['performer'] = $performer;
      $row['performer_name'] = $performer['short_name'];
      
      $district = Yii::app() -> db -> createCommand() 
        -> select('*') -> from('spi_district')
        -> where('id=:id', array(
        ':id' => $row['district_id'] 
      )) -> queryRow();
      $row['district'] = $district;
      $row['district_name'] = $district['name'];
    }
//    //get_next_id
//    Yii::app() -> db -> createCommand() 
//    ->select('MAX(id)')
//    ->from($this -> table)
//    ->limit('1');
//    $results['maxId'] = $command->queryScalar();
    return $results;
  }

  protected function doBeforeInsert($post) {
    if(Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('code=:code ', array(
        ':code' => safe($post,'code')
    )) -> queryRow()) {
      return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_DUPLICATED', 
          'message' => 'This project already exists'
      );
    }
    
    if(!safe($post,'schools')) {
      return array (
              'code' => '400',
              'result' => false,
              'system_code' => 'ERR_MISSED_REQUIRED_PARAMETERS',
              'required' => 'schools'
            );
    }
    unset($post['schools']);
    
    return array(
        'result' => true,
        'params' => $post 
    );
  }
  protected function doBeforeUpdate($post, $id) {
    $params = $post;
    unset($params['schools']);
    unset($params['performer_id']);
    $row = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('id=:id ', array(
        ':id' => $id
    )) -> queryRow();
    
    $canUpdate = true;
    foreach ($params as $key => $val) {
      if($val != $row[$key]) {
        $canUpdate = false;
        break;
      }
    }
    //TODO: если изменен список школ или исполнитель - создаем новый проект
    if(!$canUpdate) {
      return array (
              'code' => '400',
              'result' => false,
              'system_code' => 'ERR_UPDATE_FORBIDDEN',
            );
    }
    
    unset($row['id']);
    $row['schools'] = safe($post,'schools');
    $row['performer_id'] = $post['performer_id'];
    $code = explode('\\', $row['code']);
    
    $row['code'] = count($code)==1?$code[0].'\\2':$code[0].'\\'.($code[1]+1);
    Yii::app ()->db->createCommand ()->update ( $this->table, array('is_old' => 1), 'id=:id', array (
      ':id' => $id 
    ));
    
    $this->insert($row);
    
//    return array(
//        'result' => true,
//        'params' => $oldRow 
//    );
  }
  protected function doAfterInsert($result, $params, $post) {
    if($result['result']) {
      foreach($post['schools'] as $school_id) {
        Yii::app ()->db->createCommand()->insert('spi_project_school', array('project_id' => $result['id'], 'school_id' => $school_id));
      }
    }
    return $result;
  }

//  protected function doBeforeUpdate($post, $id) {
//    $param = array_change_key_case($post,CASE_UPPER);
//    $row = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('id=:id ', array(
//        ':id' => $id
//    )) -> queryRow();
//
//    if(safe($post, 'type_id') == 7) {
//      $post['is_finansist'] = 1;
//    } elseif(safe($post, 'type_id') == 3) {
//      $post['is_finansist'] = 0;
//    }
//
//    if (Yii::app() -> db -> createCommand()
//        -> select('*') 
//        -> from($this -> table) 
//        -> where('id!=:id ' . 'AND login=:login',
//                  array(
//                  ':id' => $id,
//                  ':login' => $row['login']))
//         -> queryRow()) {
//      return array(
//          'code' => '409',
//          'result' => false,
//          'system_code' => 'ERR_DUPLICATED', 
//          'message' => 'This Username already registered'
//      );
//    }
//    
//    if (isset($param['EMAIL']) && $param['EMAIL'] && Yii::app() -> db -> createCommand() 
//        -> select('*')
//        -> from($this -> table) 
//        -> where('email = :email AND id!=:id', 
//                  array(
//                  ':email' => $param['EMAIL'],
//                  ':id' => $id))
//         -> queryRow()) {
//      return array(
//          'code' => '409',
//          'result' => false,
//          'system_code' => 'ERR_DUPLICATED_EMAIL'
//      );
//    }
//    
//    return array(
//        'result' => true,
//        'params' => $post 
//    );
//  }


}
