<?php
require_once ('utils/utils.php');
require_once ('utils/email.php');

class RequestSchoolConcept extends BaseModel {
  public $table = 'spi_request_school_concept';
  public $select_all = "tbl.*, scl.name school_name, scl.number school_number";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand()
      -> select($this->select_all)
      -> from($this -> table . ' tbl')
      -> join('spi_school scl', 'tbl.school_id = scl.id')
      -> where('1=1 ', array())
      -> order('scl.number');
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere('tbl.request_id = :request_id', array(':request_id' => $params['REQUEST_ID']));
    }
    return $command;
  }

  protected function doAfterSelect($result) {
    foreach($result['result'] as &$row) {
      $row['histories'] = $this->getHistoriesById($row['id']);

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

    }
    return $result;
  }

  private function getHistoriesById($concept_id) {
    $rows = Yii::app()->db->createCommand()
        ->select("aev.id, 
        CONCAT(usr.first_name, ' ', usr.last_name) user_name, 
        DATE_FORMAT(aev.event_date, '%d.%m.%Y') date, 
        adt.column_name,
        adt.old_value,
        adt.new_value")
        ->from('spi_audit_event aev')
        ->join('spi_audit_data adt', 'adt.event_id = aev.id')
        ->join('spi_user usr', 'aev.user_id = usr.id')
        ->where('aev.table_name =:table_name', array(':table_name' => $this->table))
        ->andWhere('aev.record_id = :id', array(':id' => $concept_id))
        ->andWhere("aev.event_type = 'UPD'")
        ->order("aev.event_date")
        ->queryAll();
    $items = array();
    $situation = array();
    $offers_youth_social_work = array();
    $comment = '';
    $key = 0;
    foreach($rows as $row) {
      switch($row['column_name']) {
        case 'situation':
          $situation['code'] = $row['column_name'];
          $situation['name'] = $this->getFieldNameByColumnName($row['column_name']);
          $situation['new']  = $row['new_value'];
          if(!isset($situation['old'])) $situation['old'] = $row['old_value'];
          break;
        case 'offers_youth_social_work':
          $offers_youth_social_work['code'] = $row['column_name'];
          $offers_youth_social_work['name'] = $this->getFieldNameByColumnName($row['column_name']);
          $offers_youth_social_work['new']  = $row['new_value'];
          if(!isset($offers_youth_social_work['old'])) $offers_youth_social_work['old'] = $row['old_value'];
          break;
        case 'comment':
          $comment = $row['new_value'];
          break;
        case 'status':
          $items[$key] = array(
            'date'        => $row['date'],
            'user_name'   => $row['user_name'],
            'status_code' => $row['new_value'],
            'status_name' => $this->getStatusByCode($row['new_value']),
          );
          switch ($row['new_value']) {
            case 'in_progress':
              if($situation) {
                $items[$key]['changes'][] = $situation;
              }
              if($offers_youth_social_work) {
                $items[$key]['changes'][] = $offers_youth_social_work;
              }
              $situation = $offers_youth_social_work = array();
              break;
            case 'rejected':
              $items[$key]['comment'] = $comment;
              $comment = '';
              break;
          }
          break;
      }
      $key++;
    }
    return array_reverse($items);
  }

  private function getFieldNameByColumnName($column_name) {
    switch ($column_name) {
      case 'situation';
        return 'Situation an der Schule';
        break;
      case 'offers_youth_social_work';
        return 'Angebote der Jugendsozialarbeit an der Schule';
        break;
    }
    return '';
  }

  private function getStatusByCode($code) {
    switch ($code) {
      case 'rejected':
        return 'Anmerkung der Programmagentur';
      case 'in_progress':
        return 'Bereit zu überprüfen';
      case 'accepted':
        return 'Genehmigt';
    }
    return '';
  }

  protected function doBeforeUpdate($post, $id) {
    if(safe($post, 'status') == 'accepted') {
      $post['comment'] = '';
    }

    if($row = Yii::app() -> db -> createCommand() -> select('*')
      -> from($this -> table)
      -> where('id = :id', array(':id' => $id))
      -> queryRow()) {
      $valid = true;
      switch ($this->user['type']) {
        case PA:
          if($row['offers_youth_social_work'] != safe($post, 'offers_youth_social_work') || $row['situation'] != safe($post, 'situation')) {
            $valid = false;
          }
          break;
        case ADMIN:
          break;
        default:
          if(safe($post, 'status')) {
            if(safe($post, 'status') != 'in_progress') {
              $valid = false;
            } else if (isset($post['situation']) && !$post['situation']) {
              $valid = false;
            } else if(isset($post['offers_youth_social_work']) && !$post['offers_youth_social_work']) {
              $valid = false;
            }
          }
      }
      if(!$valid) {
        return array(
          'code' => '409',
          'result' => false,
          'system_code' => 'ERR_UPDATE_FORBIDDEN',
        );
      }
    }

    return array (
      'result' => true,
      'params' => $post,
      'post' => $post
    );

  }
  
  protected function doAfterUpdate($result, $params, $post, $id) {
    if(safe($post, 'status') == 'rejected') {
      $request = Yii::app() -> db -> createCommand()
        -> select('rq.id request_id, (SELECT code FROM spi_project WHERE id = rq.project_id) code, (SELECT email FROM spi_user WHERE id = rq.finance_user_id) finance_user_email, (SELECT email FROM spi_user WHERE id = rq.concept_user_id) concept_user_email')
        -> from($this -> table . ' tbl')
        -> join('spi_request rq', 'tbl.request_id = rq.id')
        -> where('tbl.id=:id', array(':id' => $id))
        ->queryRow();
      
      $emailParams = array(
          'request_code' => $request['code'],
          'part' => 'konzept',
          'comment' => safe($post, 'comment'),
          'date' => date('H:i d.m.Y'),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.safe($request, 'request_id').'#school-concepts',
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
  
  public function getCommonStatus($requestID, $statusPriorities) {
    $values = Yii::app() -> db -> createCommand() -> select('status')
      -> from($this -> table)
      -> where('request_id = :request_id', array(':request_id' => $requestID))
      -> queryColumn();
    foreach(array_keys($statusPriorities) as $statusPriority) {
      if(in_array($statusPriority, $values)) {
        return $statusPriority;
      }
    }
    return 'unfinished';
  }

}