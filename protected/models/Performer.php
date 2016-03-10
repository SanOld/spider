<?php
require_once ('utils/utils.php');


class Performer extends BaseModel {
  public $table = 'spi_performer';
  public $post = array();
  public $select_all = " tbl.*, DATE_FORMAT(checked_date, '%d.%m.%Y') checked_date_formatted, CONCAT(usp.first_name, ' ', usp.last_name) representative_user";
  protected function getCommand() {
    if($this->user['can_edit']) {
      $this->select_all .=  ", CONCAT(usc.first_name, ' ', usc.last_name) checked_name";
    }
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
        -> from($this -> table . ' tbl')
        -> leftJoin('spi_user usp', 'tbl.representative_user_id = usp.id')
        -> leftJoin('spi_bank_details bnd', 'tbl.bank_details_id = bnd.id');
    if($this->user['can_edit']) {
      $command->leftJoin('spi_user usc', 'tbl.checked_by = usc.id');
    }
    $command -> where(' 1=1 ', array());
    $command = $this->setWhereByRole($command);
    return $command;
  }

  protected function setWhereByRole($command) {
    switch($this->user['type']) {
      case SCHOOL:
        $command->join('spi_project prj', 'tbl.id = prj.performer_id');
        $command->join('spi_project_school pjs', 'prj.id = pjs.project_id');
        $command->andWhere('pjs.school_id = :school_id ', array(':school_id' => $this->user['relation_id']));
        break;
      case DISTRICT:
        $command->join('spi_project prj', 'tbl.id = prj.performer_id');
        $command->andWhere('prj.district_id = :district_id', array(':district_id' => $this->user['relation_id']));
        break;
      case TA:
        $command->andWhere('tbl.id = :performer_id', array(':performer_id' => $this->user['relation_id']));
        break;
    }
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
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

    if (Yii::app() -> db -> createCommand()
      -> select('id')
      -> from($this -> table)
      -> where('name=:name', array(':name' => $post['name']))
      -> queryScalar()) {
      return array(
        'code' => '409',
        'result' => false,
        'silent' => true,
        'system_code' => 'ERR_DUPLICATED'
      );
    }

    if (Yii::app() -> db -> createCommand()
      -> select('id')
      -> from($this -> table)
      -> where('short_name=:short_name', array(':short_name' => $post['short_name']))
      -> queryScalar()) {
      return array(
        'code' => '409',
        'result' => false,
        'silent' => true,
        'system_code' => 'ERR_DUPLICATED_SHORT_NAME'
      );
    }

    return array(
      'result' => true,
      'params' => $post
    );
  }


  protected function doBeforeUpdate($post, $id) {
    $post = $this->checkFields($post);

    if($id == safe($this->user, 'relation_id')) {
      $post['is_checked'] = 0;
      $post['checked_by'] = null;
    }

    if(!$this->user['can_edit']) {
      $row = Yii::app() -> db -> createCommand() -> select('*')
        -> from($this -> table)
        -> where('id = :id', array(':id' => $id))
        -> queryRow();
      $errorField = '';
      if($row['name'] != $post['name']) {
        $errorField = 'Kurzname';
      } else if($row['short_name'] != $post['short_name']) {
        $errorField = 'Name';
      }
      if($errorField) {
        return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_UPDATE_FORBIDDEN',
          'message' => 'Update failed: The '.$errorField.' can not be change.'
        );
      }

    }

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

    if (Yii::app() -> db -> createCommand()
      -> select('id')
      -> from($this -> table)
      -> where('id != :id AND name=:name',
        array(':id' => $id, ':name' => $post['name']))
      -> queryScalar()) {
      return array(
        'code' => '409',
        'result' => false,
        'silent' => true,
        'system_code' => 'ERR_DUPLICATED'
      );
    }

    if (Yii::app() -> db -> createCommand()
      -> select('id')
      -> from($this -> table)
      -> where('id != :id AND short_name=:short_name',
        array(':id' => $id, ':short_name' => $post['short_name']))
      -> queryScalar()) {
      return array(
        'code' => '409',
        'result' => false,
        'silent' => true,
        'system_code' => 'ERR_DUPLICATED_SHORT_NAME'
      );
    }

    return array(
      'result' => true,
      'params' => $post
    );
  }

  protected function doBeforeDelete($id) {
    $userId = Yii::app() -> db -> createCommand() -> select('id') -> from('spi_user')
      -> where('relation_id=:relation_id AND type="t"', array(':relation_id' => $id))
      -> queryScalar();
    if ($userId) {
      return array(
        'code' => '409',
        'result'=> false,
        'system_code'=> 'ERR_DEPENDENT_RECORD',
        'message' => 'Delete this performer is not possible. You must first delete users with this performer.'
      );
    }

    return array(
      'result' => true
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
        return $user['can_view'];
      case ACTION_UPDATE:
        return $user['can_edit'] || (safe($user, 'relation_id') && $user['relation_id'] == safe($_GET, 'id'));
      case ACTION_INSERT:
      case ACTION_DELETE:
        return $user['can_edit'];
    }
    return false;
  }

}
