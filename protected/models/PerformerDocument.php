<?php
require_once ('utils/utils.php');


class PerformerDocument extends BaseModel {
  public $table = 'spi_performer_document';
  public $post = array();
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

  protected function doBeforeInsert($post) {
    print_r($post);
    print_r($_FILES);
    exit;
    // need check max 5 files, one file max 10 Mb


    return array(
      'result' => true,
      'params' => $post
    );
  }

}
