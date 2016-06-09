<?php
require_once('utils/utils.php');


class District extends BaseModel {
  public $table = 'spi_district';
  public $post = array();
  public $select_all = " tbl.*, CONCAT(CONCAT_WS(' ', NULLIF(tbl.plz, ''), NULLIF(tbl.city, '')), IF(tbl.address IS NOT NULL AND length(tbl.address) > 0, CONCAT(IF(length(tbl.city) > 0 OR tbl.plz > 0, ', ', ''), tbl.address), '')) full_address, CONCAT(`usr`.`last_name`, ', ', `usr`.`first_name`) contact_user_name ";

  protected function getCommand() {
    $command = Yii::app()->db->createCommand()->select($this->select_all)->from($this->table . ' tbl');
    $command->leftJoin('spi_user usr', 'tbl.contact_id  = usr.id');
    $command->where(' 1=1 ', array());
    $command = $this->setWhereByRole($command);
    return $command;
  }

  protected function setWhereByRole($command) {
    switch($this->user['type']) {
      case SCHOOL:
        $command->join('spi_school sch', 'tbl.id = sch.district_id');
        $command->andWhere('sch.id = :school_id', array(':school_id' => $this->user['relation_id']));
        break;
      case DISTRICT:
        $command->andWhere('tbl.id = :district_id', array(':district_id' => $this->user['relation_id']));
        break;
      case TA:
        $command->join('spi_project prj', 'tbl.id = prj.district_id');
        $command->andWhere('prj.performer_id = :performer_id', array(':performer_id' => $this->user['relation_id']));
        break;
    }
    $command -> group('tbl.id');
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command, array('tbl.name', 'tbl.city', 'tbl.plz', 'tbl.address', "CONCAT(usr.first_name, ' ', usr.last_name)"), safe($params, 'KEYWORD'));
    
    if (safe($params, 'SCHOOL_TYPE_ID')) {
      $command->join('spi_school sch', 'sch.district_id=tbl.id');
      $command->andWhere("sch.type_id = :school_type_id", array(':school_type_id' => $params['SCHOOL_TYPE_ID']));
      $command -> group('tbl.id');
    }
    
    return $command;
  }

  protected function doBeforeInsert($post) {
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

    return array(
      'result' => true,
      'params' => $post
    );
  }

  protected function doBeforeUpdate($post, $id) {

    if(isset($post['contact_id']) && !$post['contact_id']) {
      unset($post['contact_id']);
    }

    if(!$this->user['can_edit']) {
      $row = Yii::app() -> db -> createCommand() -> select('*')
        -> from($this -> table)
        -> where('id = :id', array(':id' => $id))
        -> queryRow();
      $errorField = '';
      if($row['name'] != $post['name']) {
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

    return array(
      'result' => true,
      'params' => $post
    );

  }

  protected function doBeforeDelete($id) {
    $userId = Yii::app() -> db -> createCommand() -> select('id') -> from('spi_user')
      -> where('relation_id=:relation_id AND type="d"', array(':relation_id' => $id))
      -> queryScalar();
    if ($userId) {
      return array(
        'code' => '409',
        'result'=> false,
        'system_code'=> 'ERR_DEPENDENT_RECORD',
        'message' => 'Delete this district is not possible. You must first delete users with this district.'
      );
    }

    return array(
      'result' => true
    );
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
