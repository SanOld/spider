<?php
require_once ('utils/utils.php');


class Request extends BaseModel {
  public $table = 'spi_request';
  public $post = array();
  public $select_all = "tbl.*, prf.name performer_name, prj.code, fns.programm, rqs.name status_name, rqs.code status_code";
  protected function getCommand() {
    if(safe($_GET, 'list') == 'year') {
      $command = Yii::app() -> db -> createCommand()->select('year')->from($this -> table)->group('year');
    } else {
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      $command -> join( 'spi_request_status rqs', 'tbl.status_id           = rqs.id' );
      $command -> join( 'spi_performer prf',      'tbl.performer_id        = prf.id' );
      $command -> join( 'spi_project prj',        'tbl.project_id          = prj.id' );
      $command -> join( 'spi_finance_source fns', 'prj.finance_programm_id = fns.id' );
      $command -> where(' 1=1 ', array());
    }

    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'YEAR')) {
      $command -> andWhere('tbl.year = :year', array(':year' => $params['YEAR']));
    }
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('prf.id = :performer_id', array(':performer_id' => $params['PERFORMER_ID']));
    }
    if(safe($params, 'FINANCE_TYPE')) {
      $command -> andWhere('prj.finance_source_type = :finance_type', array(':finance_type' => $params['FINANCE_TYPE']));
    }
    if(safe($params, 'PROGRAM_ID')) {
      $command -> andWhere('fns.id = :program_id', array(':program_id' => $params['PROGRAM_ID']));
    }
    if(safe($params, 'STATUS_ID')) {
      $command -> andWhere('rqs.id = :status_id', array(':status_id' => $params['STATUS_ID']));
    }
    return $command;
  }

  protected function calcResults($result) {
    if(safe($_GET, 'list') == 'year') {
      foreach($result['result'] as &$row) {
        $row = (int)$row['year'];
      }
      if(!in_array(date("Y"), $result['result'])) {
        array_push($result['result'], (int)date("Y"));
      }
    } else {
      foreach($result['result'] as &$row) {
        $row['start_date_unix'] = strtotime($row['start_date']).'000';
        $row['due_date_unix'] = strtotime($row['due_date']).'000';
        $row['last_change_unix'] = strtotime($row['last_change']).'000';
      }
    }
    return $result;
  }

  protected function doAfterUpdate($result, $params, $post, $id) {
    Yii::app()->db->createCommand()->update($this->table, array('last_change' => date("Y-m-d", time())), 'id=:id', array(':id' => $id ));
    return $result;
  }

  protected function doBeforeDelete($id) {
    $row = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table . ' tbl') -> where('id=:id', array(
      ':id' => $id
    )) -> queryRow();
    if (!$row) {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_NOT_EXISTS'
      );
    }

    return array(
      'result' => true
    );
  }

}
