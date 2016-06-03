<?php
require_once ('utils/utils.php');


class EmailTemplate extends BaseModel {
  public $table = 'spi_email_template';
  public $post = array();
  public $select_all = ' tbl.*, CONCAT(user.first_name, " ", user.last_name ) user_name ';

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
      -> from($this -> table . ' tbl')
      -> leftJoin('spi_user user', 'tbl.user_id = user.id');

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
    $command = $this->setLikeWhere($command,array('tbl.name'),safe($params, 'KEYWORD'));

    return $command;
  }

  protected function calcResults($result) {

    foreach($result['result'] as &$row) {
      $row['last_change_unix'] = strtotime($row['last_change']).'000';
    }

    return $result;
  }
  protected function doBeforeInsert($post) {

    $post['user_id'] = $this->user['id'];

    return array(
      'result' => true,
      'params' => $post
    );
  }

  protected function doBeforeUpdate($post, $id) {

    $post['user_id'] = $this->user['id'];
    $post['last_change'] = date('c', time());

    return array(
      'result' => true,
      'params' => $post
    );

  }



}
