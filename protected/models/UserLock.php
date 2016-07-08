<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class UserLock extends BaseModel {
  public $table = 'spi_user_lock';
  public $post = array();
  public $request_id = 0;
  public $select_all = "CONCAT(tbl.last_name, ', ', tbl.first_name) name, IF(tbl.is_active = 1, 'Aktiv', 'Nicht aktiv') status_name, IF(tbl.type = 't' AND tbl.is_finansist, CONCAT(ust.name, ' (F)'), ust.name) type_name, tbl.* ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_user_type ust', 'tbl.type_id = ust.id'); 
    
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
    
    if (safe($params, 'RELATION_ID') && safe($params, 'TYPE') && safe($params, 'REQUEST_ID')) {
      $this->request_id = $params['REQUEST_ID'];
      $command->andWhere("tbl.relation_id = :relation_id AND tbl.type = :type AND tbl.request_id = :request_id", array(
        ':relation_id' => $params['RELATION_ID'],
        ':request_id' => $params['REQUEST_ID'],
        ':type'        => $params['TYPE']
      ));
    } elseif($this->user['relation_id']) {
//      $command = $this->setWhereByRole($command);
    }

    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere("tbl.request_id = :request_id", array(':request_id' => $params['REQUEST_ID']));
    }


//    $qq = $command->text;
    return $command;
  }


protected function doAfterDelete($result, $id) {

  if($result){
    $request_id = safe($_GET,'request_id');
    if($request_id){
      $this -> deleteLock('RequestLock', $request_id);
      $this -> deleteLock('SchoolLock', $request_id);
      $this -> deleteLock('BankLock', $request_id);
    }
  }
    return $result;
  }

  protected function deleteLock($modelName, $request_id){
   $model = CActiveRecord::model($modelName);
   $model->user = $this->user;
   $response = $model->select(array('request_id'=>$request_id), true);
    if($response['code'] = 200 && count($response['result']) != 0){
      foreach($response['result'] as $key=>$value ){
        $model->delete($response['result'][$key]['id'], true);
      }
    }
    return true;
  }

}
