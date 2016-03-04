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
    print_r($data);exit;
    switch ($action) {
      case ACTION_SELECT:
        return $user['can_view'];
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        return $user['can_edit']; // TODO: performers can edit only your docs
    }
    return false;
  }

}