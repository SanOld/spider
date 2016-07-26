<?php
require_once ('utils/utils.php');


class FinancialRequestDocument extends BaseModel {
  public $table = 'spi_district';
  public $post = array();
  public $href = '';
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if (isset($params['PERFORMER_ID'])) {
      $command -> andWhere("tbl.performer_id = :performer_id", array(':performer_id' => $params['PERFORMER_ID']));
    }
    return $command;
  }

  public function addFile($name, $path) {
    $filename = $path.$name;
    $fileCsv = file($filename);
      foreach($fileCsv as $row){ 
      $row = expode(',', $row);
      $this->insert(array(
        'id'         => $row[0],
        'name'       => $row[1],
        'address'    => $row[2],
        'plz'        => $row[3],
        'city'       => $row[4],
        'phone'      => $row[5],
        'fax'        => $row[6],
        'email'      => $row[7],
        'homepage'   => $row[8],
        'contact_id' => $row[9],
      ));
    }
  }

  protected function doAfterDelete($result, $id) {
    $this->removeFile($this->href);
    return $result;
  }

  protected function doBeforeDelete($id) {
    $this->href = Yii::app()->db->createCommand()
      ->select('href')
      ->from($this -> table)
      ->where('id=:id', array(':id'=>$id))
      ->queryScalar();
    return parent::doBeforeDelete($id);
  }

  protected function checkPermission($user, $action, $data) {

//    if(!is_array($data)) {
//      $performedId = Yii::app()->db->createCommand()
//        ->select('performer_id')
//        ->from($this -> table)
//        ->where('id=:id', array(':id'=> $data))
//        ->queryScalar();
//    } else {
//      $performedId = safe($data, 'performer_id', 0);
//    }

    switch ($action) {
      case ACTION_SELECT:
        return $user['can_view'] && ($user['type'] != 't' || $user['is_finansist']);
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        return $user['can_edit'] && ($user['type'] != 't' || $user['is_finansist']);
    }
    return false;
  }

}
