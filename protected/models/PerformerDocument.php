<?php
require_once ('utils/utils.php');


class PerformerDocument extends BaseModel {
  public $table = 'spi_performer_document';
  public $post = array();
  public $href = '';
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    if (isset($params['PERFORMER_ID'])) {
      $command -> andWhere("tbl.performer_id = :performer_id", array(':performer_id' => $params['PERFORMER_ID']));
    }
    return $command;
  }

  public function addFile($performerId, $name, $href) {
    $this->insert(array(
      'performer_id' => $performerId,
      'name'         => $name,
      'href'         => $href,
    ));
  }

  protected function doBeforeDelete($id) {
    $row = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table . ' tbl') -> where('id=:id', array(
      ':id' => $id
    )) -> queryRow();
    if (!$row) {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_NOT_EXISTS'
      );
    }

    $this->href = Yii::app()->db->createCommand()->select('href')->from($this -> table)->where('id=:id', array(':id'=>$id))->queryScalar();
    return array (
      'result' => true
    );
  }

  protected function doAfterDelete($result, $id) {
    $this->removeFile($this->href);
    return $result;
  }

  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        return true;
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
//        return true;
//        print_r($user['type']);
//        print_r($user['type_id']);exit;
        if(($user['type'] == ADMIN && $user['type_id'] != 6) || $user['type'] == TA) {
          return true;
        }
    }
    return false;
  }

}
