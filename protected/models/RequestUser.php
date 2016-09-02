<?php
require_once ('utils/utils.php');


class RequestUser extends BaseModel {
  public $table = 'spi_request_user';
  public $select_all = "tbl.*, CONCAT(usr.first_name, ' ', usr.last_name) name, IF(usr.sex = 1, 'Herr', 'Frau' ) sex, rfg.name group_name, rml.name remuneration_name";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> leftJoin('spi_user usr', 'tbl.user_id=usr.id');
    $command -> leftJoin('spi_request_financial_group rfg', 'tbl.group_id=rfg.id');
    $command -> leftJoin('spi_remuneration_level rml', 'tbl.remuneration_level_id=rml.id');
    $command -> where('1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere('tbl.request_id = :request_id', array(':request_id' => $params['REQUEST_ID']));
    }
    return $command;
  }


   protected function doBeforeUpdate($post, $id) {
    if(safe($post, 'other')){
      $post['other'] = substr(safe($post, 'other'), 0, 50);
    }
    return array (
        'result' => true,
        'params' => $post,
        'post' => $post
    );
  }

  protected function doBeforeInsert($post) {
    if(safe($post, 'other')){
      $post['other'] = substr(safe($post, 'other'), 0, 50);
    }
    return array (
        'result' => true,
        'params' => $post,
        'post' => $post
    );
  }
}