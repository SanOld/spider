<?php
require_once ('utils/utils.php');


class Project extends BaseModel {
  public $table = 'spi_project';
  public $post = array();
  public $params = array();
  public $select_all = "tbl.*, req.status_id,
          (SELECT short_name FROM spi_performer prf WHERE prf.id=tbl.performer_id) AS `performer_name`,
          (SELECT name FROM spi_district dst WHERE dst.id=tbl.district_id) AS `district_name`,
          (SELECT name FROM spi_school scl WHERE scl.id=sps.school_id) AS `school_name`";
  protected function getCommand() {

    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> leftJoin('spi_project_school sps', 'sps.project_id=tbl.id');
    $command -> leftJoin ('spi_request req', 'req.project_id = tbl.id');
    $command -> where(' 1=1 ', array());

    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);

    if(safe($params, 'LIST') == 'unused_project') {
      $this->select_all = "tbl.id id, tbl.performer_id performer_id, tbl.code code ";
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      $command -> leftJoin( 'spi_request rqt',  'tbl.id  = rqt.project_id' );
      $command -> where(' rqt.project_id  IS NULL ', array());
      $command -> orWhere(' rqt.year <> :year', array(':year' => $params['YEAR']));
      $command->andWhere(' tbl.id NOT IN (SELECT project_id FROM spi_request WHERE year=:year )', array(':year' => $params['YEAR']));
      $command->andWhere('tbl.code LIKE :code', array(':code' => '%'.$params['VALUE'].'%'));
      $command->andWhere(' tbl.is_old = 0');
    }

    if (safe($params, 'CODE')) {
      if($this->user['type'] == TA){        
        $command->andWhere("tbl.id = :id", array(':id' => $params['CODE']));
      }else{        
        $command = $this->setLikeWhere($command,'tbl.code',safe($params, 'CODE'));
      }
    }
    if (safe($params, 'SCHOOL_TYPE_ID')) {
      $command->andWhere("tbl.school_type_id = :school_type_id", array(':school_type_id' => $params['SCHOOL_TYPE_ID']));
    }
    if (safe($params, 'REQUEST_ID')) {
      $command->andWhere("req.id = :id", array(':id' => $params['REQUEST_ID']));
    }
    if (isset($params['DISTRICT_ID'])) {
      $command -> andWhere("tbl.district_id = :district_id", array(':district_id' => $params['DISTRICT_ID']));
    }
    if (isset($params['PERFORMER_ID'])) {
      $command -> andWhere("tbl.performer_id = :performer_id", array(':performer_id' => $params['PERFORMER_ID']));
    }
    if (isset($params['ID'])) {
      $command -> andWhere("tbl.id = :id", array(':id' => $params['ID']));
    }    
    if (safe($params, 'SCHOOL_ID')) {
        $command->andWhere("sps.school_id = :school_id", array(':school_id' => $params['SCHOOL_ID']));
    }
    if (safe($params, 'FINANCIAL_REQUEST')) {
      $command -> rightJoin( 'spi_financial_request freq',  'req.id  = freq.request_id');
    }
    if(safe($params, 'TYPE_ID')) {
      $command -> andWhere('tbl.type_id = :type_id', array(':type_id' => $params['TYPE_ID']));
    }
    if (safe($params, 'REAL_CODE')) {
      $command->andWhere("tbl.code LIKE :real_code", array(':real_code' => ''.$params['REAL_CODE'].'%'));
      $command->andWhere("tbl.is_old = 0");
      if(strlen($params['REAL_CODE']) == 1){
        $command->andWhere("tbl.type_id <> 3");
      }
    }
    $this->params = $params;
    $command = $this->setWhereByRole($command);
    $command -> group('tbl.id');
    return $command;
  }

  protected function setWhereByRole($command) {
    switch($this->user['type']) {
      case SCHOOL:
        $command->andWhere("sps.school_id = :school_id", array(':school_id' => $this->user['relation_id']));
        break;
      case DISTRICT:
        $command->andWhere("tbl.district_id = :district_id", array(':district_id' => $this->user['relation_id']));
        break;
      case TA:
        $command->andWhere("tbl.performer_id = :performer_id", array(':performer_id' => $this->user['relation_id']));
        break;
    }
    return $command;
  }

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
    foreach ($results['result'] as &$row){
      if(safe($row, 'is_old')){
        $row['status'] = 'decline';
      }else{
        $row['status'] = 'open';
      }
    };
    
    if(safe($_GET, 'list') == 'unused_project'){
      foreach($results['result'] as &$row) {
         $row[$row['id']] = array(
            'id' => $row['id']
          , 'code' => $row['code']
          , 'performer_id' => $row['performer_id']
          );

      }
    } else {
      foreach($results['result'] as &$row) {
  //    $relation = $this->getSchools($row['id']);    
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
  //      $row['performer_name'] = $performer['short_name'];

        $district = Yii::app() -> db -> createCommand()
          -> select('*') -> from('spi_district')
          -> where('id=:id', array(
          ':id' => $row['district_id']
        )) -> queryRow();
        $row['district'] = $district;
  //      $row['district_name'] = $district['name'];
      }
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

    if($this->user['type'] == ADMIN || ($this->user['type'] == PA && $post['isUpdate'])) {
      unset($post['isUpdate']);
      if(Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('code=:code ', array(
          ':code' => safe($post,'code')
      )) -> queryRow()) {
        return array(
            'code' => '409',
            'result' => false,
            'silent' => true,
            'system_code' => 'ERR_DUPLICATED'
        );
      }
      if($post['rate']){
        $post['rate'] = (float)str_replace(",", ".", $post['rate']);
      }
//
//      if(!safe($post,'schools')) {//есть проекты без школы и дистрикта
//        return array (
//                'code' => '400',
//                'result' => false,
//                'system_code' => 'ERR_MISSED_REQUIRED_PARAMETERS',
//                'required' => 'schools'
//              );
//      }
      unset($post['schools']);

      return array(
          'result' => true,
          'params' => $post
      );
    } else {
      return array(
          'code' => '403',
          'result' => false,
          'system_code' => 'ERR_PERMISSION',
          'message' => 'Only Admin can create the projects'
      );

    }
  }
  protected function doBeforeUpdate($post, $id) {
    $params = $post;
    if($params['is_old']){
      unset($post['is_old']);
      $post['is_old'] = 1;
      unset($post['schools']);
      unset($post['status_id']);
      return array (
              'result' => true,
              'params' => $post
            );
    };
    unset($params['schools']);
    unset($params['performer_id']);
    unset($params['district_id']);
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
    $row['district_id'] = $post['district_id'];
    $code = explode('/', $row['code']);

    $row['code'] = count($code)== 1 ? $code[0]. '/2 ' : $code[0].'/'.($code[1] + 1);
    Yii::app ()->db->createCommand ()->update ( $this->table, array('is_old' => 1), 'id = :id', array (
      ':id' => $id
    ));    
    $row['isUpdate'] = true;    
        
    $this->insert($row);
    
//    return array(
//        'result' => true,
//        'params' => $oldRow
//    );
  }
  protected function doAfterInsert($result, $params, $post) {
    if($result['result'] && safe($post,'schools')) {
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
