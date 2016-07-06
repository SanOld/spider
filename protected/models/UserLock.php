<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class UserLock extends BaseModel {
  public $table = 'spi_user_lock';
  public $post = array();
  public $select_all = "CONCAT(tbl.last_name, ', ', tbl.first_name) name, IF(tbl.is_active = 1, 'Aktiv', 'Nicht aktiv') status_name, IF(tbl.type = 't' AND tbl.is_finansist, CONCAT(ust.name, ' (F)'), ust.name) type_name, tbl.* ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_user_type ust', 'tbl.type_id = ust.id'); 
    
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
    
    if (safe($params, 'RELATION_ID') && safe($params, 'TYPE') && safe($params, 'REQUEST_ID')) {
      $command->andWhere("tbl.relation_id = :relation_id AND tbl.type = :type AND tbl.request_id = :request_id", array(
        ':relation_id' => $params['RELATION_ID'],
        ':request_id' => $params['REQUEST_ID'],
        ':type'        => $params['TYPE']
      ));
    } elseif($this->user['relation_id']) {
//      $command = $this->setWhereByRole($command);
    }
//    $qq = $command->text;
    return $command;
  }

  protected function setWhereByRole($command) {
//    switch($this->user['type']) {
//      case SCHOOL:
//        $command->andWhere('(tbl.relation_id = :relation_id AND tbl.type = :type) OR (tbl.type_id IN(1,2)) '.
//          'OR (tbl.relation_id IN (SELECT performer_id FROM spi_project WHERE id IN('.
//          'SELECT project_id FROM spi_project_school WHERE school_id = :relation_id)) AND tbl.type = "t") '.
//          'OR (tbl.relation_id IN(SELECT district_id FROM spi_school WHERE id = :relation_id) AND tbl.type = "d") '.
//          'OR (tbl.relation_id IN (SELECT district_id FROM spi_project WHERE id IN(SELECT project_id FROM spi_project_school WHERE school_id = :relation_id)) AND tbl.type = "d")',
//          array(':relation_id' => $this->user['relation_id'], ':type' => $this->user['type']));
//        break;
//      case DISTRICT:
//        $command->andWhere('(tbl.relation_id = :relation_id AND tbl.type = :type) '.
//          'OR tbl.type_id IN(1,2) '.
//          'OR (tbl.relation_id IN(SELECT id FROM spi_school WHERE district_id = :relation_id) AND tbl.type = "s")'.
//          'OR (tbl.relation_id IN(SELECT performer_id FROM spi_project WHERE district_id = :relation_id ) AND tbl.type = "t")',
//          array(':relation_id' => $this->user['relation_id'], ':type' => $this->user['type']));
//        break;
//      case TA:
//        $command->andWhere('(tbl.relation_id = :relation_id AND tbl.type = :type) OR tbl.type_id IN(1,2)'.
//          'OR (tbl.relation_id IN(SELECT district_id FROM spi_project WHERE performer_id = :relation_id ) AND tbl.type = "d")'.
//          'OR (tbl.relation_id IN(SELECT school_id FROM spi_project_school WHERE project_id IN(SELECT id FROM spi_project WHERE performer_id = :relation_id)) AND tbl.type = "s")',
//          array(':relation_id' => $this->user['relation_id'], ':type' => $this->user['type']));
//        break;
//    }
    return $command;
  }

}
