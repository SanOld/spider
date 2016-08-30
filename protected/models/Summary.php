<?php
require_once ('utils/utils.php');

class Summary extends BaseModel {
  public $post = array();

  protected function getCommand() {
      
    $command = Yii::app() -> db -> createCommand()
              ->select('prj.code project_code,
                        prf.short_name performer_name,
                        fsr.programm,
                        req.year, 
                        req.total_cost,
                        req.id request_id')
              ->from('spi_request req')
              ->join('spi_project prj', 'prj.id = req.project_id')
              ->join('spi_performer prf', 'prf.id = req.performer_id')
              ->join('spi_finance_source fsr', 'fsr.id = prj.programm_id')
              ->where('req.status_id = 5');
    
    return $command;
  }
  
  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    
    $command = $this->setWhereByRole($command);
    
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
