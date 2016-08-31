<?php
require_once ('utils/utils.php');

class Summary extends BaseModel {
  public $post = array();

  protected function getCommand() {
      
    $command = Yii::app() -> db -> createCommand()
              ->select('prj.code project_code,
                        prj.id project_id,
                        prf.short_name performer_name,
                        prf.id performer_id,
                        fsr.programm,
                        req.year, 
                        req.total_cost,
                        req.id request_id');
    $command->from('spi_request req');
    if(safe($_GET, 'list') == 'year') {      
      $command ->group('req.year');
    };
    $command->join('spi_project prj', 'prj.id = req.project_id');
    $command->join('spi_performer prf', 'prf.id = req.performer_id');
    $command->join('spi_finance_source fsr', 'fsr.id = prj.programm_id');
    $command->where('req.status_id = 5');
    
    return $command;
  }
  
  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('req.performer_id = :performer_id',           array(':performer_id' => $params['PERFORMER_ID']));
    }
    if(safe($params, 'SCHOOL_TYPE_ID')) {
      $command -> andWhere('prj.school_type_id = :school_type_id',       array(':school_type_id' => $params['SCHOOL_TYPE_ID']));
    }
    if(safe($params, 'PROJECT_TYPE_ID')) {
      $command -> andWhere('prj.type_id = :project_type_id',                array(':project_type_id' => $params['PROJECT_TYPE_ID']));
    }
    if(safe($params, 'YEAR')) {
      $command -> andWhere('req.year = :year',                array(':year' => $params['YEAR']));
    }
    
    return $command;
  }
  
  protected function doAfterSelect($results) {
    foreach ($results['result'] as &$row){
      $FinRequest = CActiveRecord::model('FinancialRequest');
      $FinRequest->user = $this->user;
      $summary = $FinRequest->getSummary($row['request_id'], $row['year'], $row['total_cost']);
      
      $row['changes']  = $summary['changes'];
      $row['spending'] = $summary['spending'];
      $row['remained'] = $summary['remained'];
      $row['payed']    = $summary['payed'];
      $row['actual']   = $summary['actual'];
    }; 
       
    return $results;
  }
  
}
