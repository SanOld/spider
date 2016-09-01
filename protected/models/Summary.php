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
                        pjt.name type,
                        req.year, 
                        req.total_cost,
                        req.id request_id');
    $command->from('spi_request req');
    if(safe($_GET, 'list') == 'year') {      
      $command ->group('req.year');
    };
    $command->join('spi_project prj', 'prj.id = req.project_id');
    $command->join('spi_project_type pjt', 'pjt.id = prj.type_id');
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
    $command = $this->setWhereByRole($command);
    return $command;
  }
  
  protected function setWhereByRole($command) {
    switch($this->user['type']) {
      case TA:
        $command->andWhere("prj.performer_id = :performer_id",  array(':performer_id' => $this->user['relation_id']));
        break;
      case SCHOOL:
        $command -> leftJoin('spi_project_school sps',           'sps.project_id=prj.id');  
        $command -> andWhere("sps.school_id = :school_id", array(':school_id' => $this->user['relation_id']));
        $command -> andWhere("prj.type_id = 3");
        break;
    }
    return $command;
  }
  
  protected function doAfterSelect($results) {
    foreach($results['result'] as &$row) {
      if($row['project_id']){
        $schools = Yii::app() -> db -> createCommand()
        -> select('scl.*') -> from('spi_project_school prs')
        -> leftJoin('spi_school scl', 'prs.school_id=scl.id')
        -> where('prs.project_id=:id', array(':id' => $row['project_id'])) 
        -> queryAll();
        $row['schools'] = $schools;
      }

      if(isset($row['schools']))  {
        foreach ($row['schools'] as $key=>$schoolData) {
          $row['schools'][$schoolData['id']] = $schoolData;
          unset ($row['schools'][$key]);
        }
      }
    }
    
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
