<?php
require_once ('utils/utils.php');


class Performer extends BaseModel {
  public $table = 'spi_performer';
  public $post = array();
  public $select_all = " tbl.*, DATE_FORMAT(checked_date, '%d.%m.%Y') checked_date_formatted, CONCAT(usp.first_name, ' ', usp.last_name) representative_user";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
        -> from($this -> table . ' tbl')
        -> leftJoin('spi_user usp', 'tbl.representative_user_id = usp.id')
        -> leftJoin('spi_bank_details bnd', 'tbl.bank_details_id = bnd.id');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command,
        array('tbl.address', 'tbl.email', "CONCAT(usp.first_name, ' ', usp.last_name)"),
        safe($params, 'KEYWORD'));
    $command = $this->setLikeWhere($command,
        array('bnd.contact_person', 'bnd.iban', 'bnd.bank_name', 'bnd.outer_id'),
        safe($params, 'BANK_DETAILS'));
    if (isset($params['IS_CHECKED'])) {
      $command -> andWhere("tbl.is_checked = :is_checked", array(':is_checked' => $params['IS_CHECKED']));
    }
    return $command;
  }

  protected function doBeforeInsert($post) {
    $post = $this->checkFields($post);

    return array(
      'result' => true,
      'params' => $post
    );
  }

  protected function doBeforeUpdate($post, $id) {
    $post = $this->checkFields($post);

    if(isset($post['bank_details_id']) && !$post['bank_details_id']) {
      unset($post['bank_details_id']);
    }

    if(isset($post['representative_user_id']) && !$post['representative_user_id']) {
      unset($post['representative_user_id']);
    }

    if(isset($post['application_processing_user_id']) && !$post['application_processing_user_id']) {
      unset($post['application_processing_user_id']);
    }

    if(isset($post['budget_processing_user_id']) && !$post['budget_processing_user_id']) {
      unset($post['budget_processing_user_id']);
    }

    return array(
      'result' => true,
      'params' => $post
    );
  }

  protected function checkFields($post) {
    if(safe($post, 'is_checked')) {
      if(!in_array($this->user['type_id'], array(1,2))) { // Admin or PA
        unset($post['is_checked']);
      } else {
        $post['checked_by'] = $this->user['id'];
        $post['checked_date'] = date("Y-m-d", time());
      }
    } else {
      $post['checked_by'] = null;
      $post['checked_date'] = null;
    }
    if(safe($post, 'comment') && !in_array($this->user['type_id'], array(1,2))) { // Admin or PA
      unset($post['comment']);
    }
    return $post;
  }

  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        return true;
      case ACTION_UPDATE:
        if(in_array($user['type'], array(ADMIN, TA)) && $user['type_id'] != 6) { // except Senat
          return true;
        }
        break;
      case ACTION_INSERT:
        if($user['type'] == ADMIN && $user['type_id'] != 6) { // except Senat
          return true;
        }
        break;
      case ACTION_DELETE:
        if($user['type'] == ADMIN && !in_array($user['type_id'], array(2,6))) { // except PA and Senat
          return true;
        }
        break;
    }
    return false;
  }

}
