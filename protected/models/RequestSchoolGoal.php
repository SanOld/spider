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


  protected function doBeforeInsert($post) {
    if($this->user['type'] == ADMIN || ($this->user['type'] == PA) || ($this->user['type'] == TA)) {

      //TO DO  Check required field
      $checked = true;

      if(!$checked){
        return array(
            'code' => '409',
            'result' => false,
            'system_code' => 'ERR_FORBIDDEN',
        );
      }

      return array(
          'result' => true,
          'params' => $post
      );
    } else {
      return array(
          'code' => '403',
          'result' => false,
          'system_code' => 'ERR_PERMISSION',
      );

    }
  }



  function calcStatus($request_id, $priority) {
    $resultStatus = 'unfinished';

        $result = Yii::app() -> db -> createCommand()
      -> select('id, status, option, school_id')
      -> from('spi_request_school_goal')
      -> where('request_id=:request_id', array(':request_id' => $request_id))
      -> queryAll();

    if($result){
      foreach($result as &$row) {
        $schools[$row['school_id']]['goals'][$row['id']] = $row;
        $schools[$row['school_id']]['status'] = '';
      }

      $tempSchoolStatus = '';
      foreach ($schools as &$school) {
        $tempGoalStatus = '';
        foreach(safe($school, 'goals', array()) as $goal) {
          if(!($goal['status'] === 'unfinished' && $goal['option'] === '1')){
            if($priority[$goal['status']] < safe($priority, $tempGoalStatus) || $tempGoalStatus == ''){
              $tempGoalStatus = $goal['status'];
            }
          }
        }
        $school['status'] = $tempGoalStatus;
        if($priority[$school['status']] < safe($priority, $tempSchoolStatus) || $tempSchoolStatus == ''){
          $tempSchoolStatus = $school['status'];
        }
      }
      $resultStatus = $tempSchoolStatus;
    }
    return $resultStatus;
  }
}