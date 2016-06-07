<?php
require_once ('utils/utils.php');


class RequestSchoolGoal extends BaseModel {
  public $table = 'spi_request_school_goal';
  public $select_all = "tbl.*, scl.name school_name, scl.number school_number";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_school scl', 'tbl.school_id = scl.id');
    $command -> where('1=1 ', array());
    $command-> order ('scl.id');
    return $command;
  }


  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);

    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere('tbl.request_id = :request_id', array(':request_id' => $params['REQUEST_ID']));
    }
//        print_r ($command->text);
    return $command;
  }

  private function getStatusByCode($code) {
    switch ($code) {
      case 'd':
        return 'Ablehnen';
      case 'r':
        return 'Bereit zu überprüfen';
      case 'a':
        return 'Genehmigt';
    }
    return '';
  }


  protected function doAfterSelect($result) {
    $schools = array();
    foreach($result['result'] as &$row) {


      $schools[$row['school_id']]['school_name'] = $row['school_name'];
      $schools[$row['school_id']]['school_number'] = $row['school_number'];
      $schools[$row['school_id']]['status'] = '';
      unset ($row['school_name']);
      unset ($row['school_number']);

      $schools[$row['school_id']]['goals'][$row['goal_id']] = $row;
    }
    $result['result'] = $schools;

    return $result;
  }

  protected function doAfterUpdate($result, $params, $post, $id) {
    if($result['result'] && safe($post, 'status')) {
      $request_id = Yii::app()->db->createCommand()
        ->select('request_id')
        ->from($this -> table)
        ->where('id=:id', array(':id' => $id))
        ->queryScalar();
      Yii::app()->db->createCommand()->update('spi_request', array('status_goal' => $this->getCommonStatus($request_id)));
    }
    return $result;
  }

  private function getCommonStatus($request_id) {
    return Yii::app()->db->createCommand()
      ->select('status')
      ->from($this -> table)
      ->where('request_id=:request_id', array(':request_id' => $request_id))
      ->order("FIELD(status, 'd', 'r', 'a')")
      ->queryScalar();
  }

}