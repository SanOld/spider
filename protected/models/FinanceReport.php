<?php
require_once ('utils/utils.php');

class FinanceReport extends BaseModel {
  public $table = 'spi_finance_report';
  public $post = array();
  public $select_all = 'tbl.*, req.year, fct.description cost_type, prj.code project_code, frt.id report_type_id, frs.code status_code, frs.id status ';
  public $requestData = array();
  public $projectData = array();
  public $reportData = array();

  protected function getCommand() {
    if(safe($_GET, 'list') == 'year') {      
      $command = Yii::app() -> db -> createCommand()->selectDistinct('req.year')
                ->from('spi_request req')->group('year');
      $command  ->rightJoin ('spi_finance_report frp',   'frp.request_id = req.id' );      
      $command -> leftJoin ('spi_project prj',               'req.project_id = prj.id');
    }else if(safe($_GET, 'list') == 'project'){      
      $command = Yii::app() -> db -> createCommand()
                ->selectDistinct('prj.id project_id, prj.code project_code')
                ->from('spi_project prj')->group('prj.code');      
      $command  ->rightJoin ('spi_request req',          'req.project_id = prj.id' );
      $command  ->where ('req.status_id = 5');
    }else{
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      $command -> leftJoin ('spi_request req',               'tbl.request_id = req.id');
      $command -> leftJoin ('spi_project prj',               'req.project_id = prj.id');
      $command -> leftJoin ('spi_finance_cost_type fct',     'tbl.cost_type_id = fct.id');
      $command -> leftJoin ('spi_payment_method_type pmt',   'tbl.payment_method_id = pmt.id');
      $command -> leftJoin ('spi_finance_report_type frt',   'fct.report_type_id = frt.id');
      if($this->user['type'] == 'p' || $this->user['type'] == 'a'){      
        $command -> join   ('spi_finance_report_status frs',   'frs.id              = tbl.status_id_pa');
      }else{
        $command -> join   ('spi_finance_report_status frs',   'frs.id              = tbl.status_id');
      }
    } 
      
      $command -> where    (' 1=1 ', array());
    return $command;
  }
  
  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);    
    if(safe($params, 'PROJECT_TYPE_ID')) {
      $command -> andWhere('prj.type_id = :project_type_id',   array(':project_type_id' => $params['PROJECT_TYPE_ID']));
    }
    if(safe($params, 'REPORT_TYPE_ID')) {
      $command -> andWhere('frt.id = :report_type_id',         array(':report_type_id' => $params['REPORT_TYPE_ID']));
    }
    if(safe($params, 'REPORT_TYPE_ID')) {
      $command -> andWhere('frt.id = :report_type_id',         array(':report_type_id' => $params['REPORT_TYPE_ID']));
    }
    if(safe($params, 'COST_TYPE_ID')) {
      $command -> andWhere('tbl.cost_type_id = :cost_type_id', array(':cost_type_id' => $params['COST_TYPE_ID']));
    }
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('req.performer_id = :performer_id', array(':performer_id' => $params['PERFORMER_ID']));
    }
    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere('tbl.request_id = :request_id',     array(':request_id' => $params['REQUEST_ID']));
    }
    if(safe($params, 'PROJECT_ID')) {
      $command -> andWhere('prj.id = :project_id',             array(':project_id' => $params['PROJECT_ID']));
    }
    if(safe($params, 'YEAR')) {
      $command -> andWhere('req.year = :year',                 array(':year' => $params['YEAR']));
    }
    if(safe($params, 'CODE')) {
      $command -> andWhere('tbl.code = :code',                 array(':code' => $params['CODE']));
    }
    if(safe($params, 'PAYMENT_DATE')) {
      $command -> andWhere('tbl.payment_date = :payment_date',                 array(':payment_date' => $params['PAYMENT_DATE']));
    }
    if(safe($params, 'STATUS_ID')) {
      if($this->user['type'] == 'p' || $this->user['type'] == 'a'){      
        $command -> andWhere('tbl.status_id_pa = :status_id',       array(':status_id' => $params['STATUS_ID']));
      }else{
        $command -> andWhere('tbl.status_id = :status_id',       array(':status_id' => $params['STATUS_ID']));
      }
    }
    if(safe($params, 'SCHOOL_ID')) {
      $command -> leftJoin('spi_project_school sps',           'sps.project_id=prj.id');      
      $command -> join    ( 'spi_school scl',                  'sps.school_id = scl.id' );
      $command -> andWhere("scl.id = :school_id",              array(':school_id' => $params['SCHOOL_ID']));
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
        $command->  andWhere("sps.school_id = :school_id", array(':school_id' => $this->user['relation_id']));
        $command->  andWhere("prj.type_id = 3");
        break;
    }
    return $command;
  }
  
  protected function doBeforeInsert($post) {
    
      if(safe($post,'overhead_cost')){
        $Request = CActiveRecord::model('Request');
        $Request->user = $this->user;
        $requestInfo = $Request->select(array('id' => safe($post, 'request_id')), true);
        $this->requestData = $requestInfo['result'][0];
        
        $Project = CActiveRecord::model('Project');
        $Project->user = $this->user;
        $projectInfo = $Project->select(array('id' => safe($this->requestData, 'project_id')), true);
        $this->projectData = $projectInfo['result'][0];
        
        $post['code'] = '999999';
        $post['project_code'] = $this->projectData['code'];
        
        $Report = CActiveRecord::model('FinanceReport');
        $Report->user = $this->user;
        $reportInfo = $Report->select(array('code' => $post['project_code']. '/' .$post['code']), true);
        if(!safe($reportInfo['result'],0)){          
          $post['request_id'] = $this->requestData['id'];
          $post['cost_type_id'] = 5;
          $post['report_cost'] = $this->requestData['overhead_cost'];
          $post['chargeable_cost'] = $this->requestData['overhead_cost'];
          $post['payment_method_id'] = 2;
          $post['status_id'] = 4;
          $post['status_id_pa'] = 2;
          $post['status_message'] = 'in_progress';
          $post['payment_date'] = '0000-00-00';
          unset($post['overhead_cost']);
        }else{
          unset($post['code']);
          unset($post['project_code']);
          return array(
            'code' => '409',
            'result' => false,
            'system_code' => 'ERR_DUPLICATED',
            'message' => 'Beleg existiert bereits'
          );
        };     
      };
      
      $post['code'] = $post['project_code']. '/' .$post['code'];
      unset($post['project_code']);
      unset($post['report_type_id']);
      
      if(!safe($post,'chargeable_cost')){
        $post['chargeable_cost'] = $post['report_cost'];
      };
      
      return array(
          'result' => true,
          'params' => $post
      );
  }
  
  protected function doBeforeUpdate($post, $id) {
    
      if(safe($post,'project_code')){
        $post['code'] = $post['project_code']. '/' .$post['code'];
        unset($post['project_code']);
      };
      
      if(safe($post,'report_type_id')){
        unset($post['report_type_id']);
      };
      
      return array (
      'result' => true,
      'params' => $post,
      'post' => $post
    );
  }
  
}
