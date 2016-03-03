<?php
require_once('utils/utils.php');


class District extends BaseModel {
  public $table = 'spi_district';
  public $post = array();
  public $select_all = " tbl.*, CONCAT(`usr`.`first_name`, ' ', `usr`.`last_name`) contact_user_name ";

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
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command, array('tbl.name', 'tbl.address', "CONCAT(usr.first_name, ' ', usr.last_name)"), safe($params, 'KEYWORD'));
    return $command;
  }

  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        return true;
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        if($user['type'] == ADMIN && $user['type_id'] != 6) { // except Senat
          return true;
        }
        break;
    }
    return false;
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

}
