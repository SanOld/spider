<?php
require_once ('utils/utils.php');


class School extends BaseModel {
  public $table = 'spi_school';
  public $post = array();
  public $select_all = "tbl.*, dst.name district_name, sct.name type_name, CONCAT(`usr`.`first_name`, ' ', `usr`.`last_name`) contact_user_name";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command->join('spi_district dst',    'tbl.district_id = dst.id');
    $command->join('spi_school_type sct', 'tbl.type_id     = sct.id');
    $command->leftJoin('spi_user usr',    'tbl.contact_id  = usr.id');
    $command -> where(' 1=1 ', array());
    $command = $this->setWhereByRole($command);
    return $command;
  }

  protected function setWhereByRole($command) {
    switch($this->user['type']) {
      case SCHOOL:
        $command->andWhere('tbl.id = :school_id '.
          'OR tbl.id IN (SELECT school_id FROM spi_project_school WHERE project_id IN('.
          'SELECT project_id FROM spi_project_school WHERE school_id = :school_id))',
          array(':school_id' => $this->user['relation_id']));
        break;
      case DISTRICT:
        $command->andWhere('tbl.district_id = :district_id', array(':district_id' => $this->user['relation_id']));
        break;
      case TA:
        $command->join('spi_project prj', 'tbl.district_id = prj.district_id');
        $command->andWhere('prj.performer_id = :performer_id', array(':performer_id' => $this->user['relation_id']));
        break;
    }
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command,
      array('tbl.name', 'tbl.number', 'tbl.address', "CONCAT(usr.first_name, ' ', usr.last_name)"),
      safe($params, 'KEYWORD'));
    if (isset($params['DISTRICT_ID'])) {
      $command -> andWhere("tbl.district_id = :district_id", array(':district_id' => $params['DISTRICT_ID']));
    }
    if (isset($params['TYPE_ID'])) {
      $command -> andWhere("tbl.type_id = :type_id", array(':type_id' => $params['TYPE_ID']));
    }
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
      -> where('name=:name AND district_id = :district_id AND number = :number', array(
        ':name'        => $post['name'],
        ':district_id' => $post['district_id'],
        ':number'      => $post['number'],
      ))
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
      -> where('id != :id AND name=:name AND district_id = :district_id AND number = :number',
        array(':id' => $id, ':name' => $post['name'], ':district_id' => $post['district_id'], ':number'      => $post['number']))
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
