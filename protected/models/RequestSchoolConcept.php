<?php
require_once ('utils/utils.php');


class RequestSchoolConcept extends BaseModel {
  public $table = 'spi_request_school_concept';
  public $select_all = "tbl.*, scl.name school_name, scl.number school_number";

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> join('spi_school scl', 'tbl.school_id = scl.id');
    $command -> where('1=1 ', array());
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
    $status_code = 'unfinished';
    $status_name = 'Unvollendet';
    foreach($rows as $row) {
      $id = $row['id'];
      if(!isset($items[$id])) $items[$id] = array();
      $items[$id]['date']        = $row['date'];
      $items[$id]['user_name']   = $row['user_name'];
      $items[$id]['status_code'] = $status_code;
      $items[$id]['status_name'] = $status_name;
      switch($row['column_name']) {
        case 'status':
          $status_code = $row['new_value'];
          $status_name = $this->getStatusByCode($row['new_value']);
          $items[$id]['status_code'] = $status_code;
          $items[$id]['status_name'] = $status_name;
          break;
        case 'comment':
          $items[$id]['comment'] = $row['new_value'];
          break;
        default:
          if(!isset($items[$id]['changes'])) $items[$id]['changes'] = array();
          $items[$id]['changes'][] = array(
            'code' => $row['column_name'],
            'name' => $this->getFieldNameByColumnName($row['column_name']),
            'old'  => $row['old_value'],
            'new'  => $row['new_value'],
          );
          break;
      }
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
        return 'Ablehnen';
      case 'in_progress':
        return 'Bereit zu überprüfen';
      case 'accepted':
        return 'Genehmigt';
    }
    return '';
  }

  protected function doBeforeUpdate($post, $id) {
    if(in_array(safe($post, 'status'), array('accepted', 'in_progress'))) {
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
            if($post['status'] != 'in_progress') {
              $valid = false;
            } else if(safe($post, 'status') == 'in_progress' && $row['status'] == 'in_progress') {
              $valid = false;
            } else if(safe($post, 'status') != 'in_progress' && ($row['offers_youth_social_work'] != safe($post, 'offers_youth_social_work') || $row['situation'] != safe($post, 'situation'))) {
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

}