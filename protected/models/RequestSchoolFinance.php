<?php
require_once ('utils/utils.php');


class RequestSchoolFinance extends BaseModel {
  public $table = 'spi_request_school_finance';
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
//
//  private function getStatusByCode($code) {
//    switch ($code) {
//      case 'rejected':
//        return 'Ablehnen';
//      case 'in_progress':
//        return 'Bereit zu überprüfen';
//      case 'accepted':
//        return 'Genehmigt';
//    }
//    return '';
//  }
//
//  protected function doBeforeUpdate($post, $id) {
//    if(in_array(safe($post, 'status'), array('accepted', 'in_progress'))) {
//      $post['comment'] = '';
//    }
//
//    if($row = Yii::app() -> db -> createCommand() -> select('*')
//      -> from($this -> table)
//      -> where('id = :id', array(':id' => $id))
//      -> queryRow()) {
//      $valid = true;
//      switch ($this->user['type']) {
//        case PA:
//          if($row['offers_youth_social_work'] != safe($post, 'offers_youth_social_work') || $row['situation'] != safe($post, 'situation')) {
//            $valid = false;
//          }
//          break;
//        case ADMIN:
//          break;
//        default:
//          if(safe($post, 'status')) {
//            if($post['status'] != 'in_progress') {
//              $valid = false;
//            } else if(safe($post, 'status') == 'in_progress' && $row['status'] == 'in_progress') {
//              $valid = false;
//            } else if(safe($post, 'status') != 'in_progress' && ($row['offers_youth_social_work'] != safe($post, 'offers_youth_social_work') || $row['situation'] != safe($post, 'situation'))) {
//              $valid = false;
//            }
//          }
//      }
//      if(!$valid) {
//        return array(
//          'code' => '409',
//          'result' => false,
//          'system_code' => 'ERR_UPDATE_FORBIDDEN',
//        );
//      }
//    }
//
//    return array (
//      'result' => true,
//      'params' => $post,
//      'post' => $post
//    );
//
//  }

}