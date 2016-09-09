<?php
require_once ('utils/utils.php');
require_once ('utils/email.php');

class RequestSchoolGoal extends BaseModel {
  public $table = 'spi_request_school_goal';
  public $select_all = "tbl.*, scl.name school_name, scl.number school_number";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command ->leftJoin('spi_school scl', 'tbl.school_id = scl.id');
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
    if(safe($params, 'IS_ACTIVE')) {
      $command -> andWhere('tbl.is_active = 1');
    }
//        print_r ($command->text);
    return $command;
  }

  protected function doAfterSelect($result) {


    $schools = array();
    foreach($result['result'] as &$row) {
      $status_id = Yii::app() -> db -> createCommand()
                                    -> select('status_id')
                                    -> from('spi_request tbl')
                                    ->where('tbl.id = :id', array(':id' => $row['request_id']))
                                    ->queryScalar();
      if($status_id == '5'){
        $school_result=Yii::app() -> db -> createCommand()
                                    -> select('tbl.name, tbl.number')
                                    -> from('spi_school_lock tbl')
                                    ->where('tbl.request_id = :id', array(':id' => $row['request_id']))
                                    ->andWhere('tbl.school_id = :school_id', array(':school_id' => $row['school_id']))
                                    ->queryRow();

        $row['school_name']=$school_result['name'];
        $row['school_number']=$school_result['number'];
      }

      


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

  protected function doAfterUpdate($result, $params, $post, $id) {
    if(safe($post, 'status') == 'rejected') {
      $request = Yii::app() -> db -> createCommand()
        -> select('rq.id request_id, (SELECT code FROM spi_project WHERE id = rq.project_id) code, (SELECT email FROM spi_user WHERE id = rq.finance_user_id) finance_user_email, (SELECT email FROM spi_user WHERE id = rq.concept_user_id) concept_user_email')
        -> from('spi_request rq')
        -> where('rq.id=:id', array(':id' => safe($params, 'request_id')))
        ->queryRow();
      
      $emailParams = array(
          'request_code' => $request['code'],
          'part' => 'entwicklungsziele',
          'comment' => safe($post, 'notice'),
          'date' => date('H:i d.m.Y'),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.safe($post, 'request_id').'#schools-goals',
      );
      $result['emails'] = array();
      if($request['finance_user_email']) {
        $result['emails'][] = Email::sendMessageByTemplate('antrag_reject', $emailParams, $request['finance_user_email']);
      } else {
        $result['emails'][] = 'finance_user_email is empty';
      }
      if($request['concept_user_email']) {
        $result['emails'][] = Email::sendMessageByTemplate('antrag_reject', $emailParams, $request['concept_user_email']);
      } else {
        $result['emails'][] = 'concept_user_email is empty';
      }
    }

    $Request = CActiveRecord::model('Request');
    $Request->user = $this->user;
    $request_id = Yii::app()->db->createCommand()->select(array('request_id'))->from($this->table)->where('id=:id', array(':id' => $id))->queryScalar();
    $Request->statusUpdate($request_id);

    return $result;
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
          if(!($goal['status'] == 'unfinished' && $goal['option'] == '1')){
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