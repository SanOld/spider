<?php
require_once ('utils/utils.php');

class FinancialRequest extends BaseModel {
  public $table = 'spi_financial_request';
  public $post = array();
  public $select_all = 'tbl.*,  frs.code status_code,
                                frs.id status,
                                rte.name rate, 
                                prj.id project_id,
                                prj.code project_code,
                                prf.id performer_id,  
                                req.start_date, 
                                req.due_date, 
                                req.total_cost,
                                req.year,
                                prf.name performer_name, 
                                prf.address, req.year, 
                                bnk.bank_name kreditor,
                                pat.name payment_name,
                                (SELECT name FROM spi_school scl WHERE scl.id=prj.id) AS `school_name`';

  protected function getCommand() {
    
    if(safe($_GET, 'list') == 'year') {      
      $command = Yii::app() -> db -> createCommand()->selectDistinct('req.year')
                ->from('spi_request req')->group('year');
      $command -> leftJoin ('spi_project prj',                    'req.project_id      = prj.id');
      $command  ->where ('req.status_id = 5');
    }else if(safe($_GET, 'list') == 'project'){      
      $command = Yii::app() -> db -> createCommand()
                ->selectDistinct('prj.id project_id, prj.code project_code')
                ->from('spi_project prj')->group('prj.code');      
      $command  ->leftJoin  ('spi_request req',                    'req.project_id = prj.id' );
      $command  ->where ('req.status_id = 5');
    }else{   
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      $command -> leftJoin ('spi_payment_type pat',               'tbl.payment_type_id = pat.id');
      $command -> leftJoin ('spi_rate rte',                       'tbl.rate_id         = rte.id');
      if($this->user['type'] == 'p' || $this->user['type'] == 'a'){      
        $command -> join   ('spi_financial_request_status frs',   'frs.id              = tbl.status_id_pa');
      }else{
        $command -> join   ('spi_financial_request_status frs',   'frs.id              = tbl.status_id');
      }
      $command -> leftJoin ('spi_bank_details bnk',               'tbl.bank_account_id = bnk.id');
      $command -> leftJoin ('spi_request req',                    'tbl.request_id      = req.id');
      $command -> leftJoin ('spi_project prj',                    'req.project_id      = prj.id');
      $command -> leftJoin ('spi_performer prf',                  'prj.performer_id    = prf.id');
      $command -> where    (' 1=1 ', array());
      if(safe($_GET, 'list') == 'summary'){ 
        $command ->andWhere ('req.status_id = 5');
      }
    }
    return $command;
  }
  
  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'PROJECT_ID')) {
      $command -> andWhere('prj.id = :project_id',             array(':project_id' => $params['PROJECT_ID']));
    }
    if(safe($params, 'TYPE_ID')) {
      $command -> andWhere('tbl.payment_type_id = :type_id',   array(':type_id' => $params['TYPE_ID']));
    }
    if(safe($params, 'STATUS_ID')) {
      $command -> andWhere('tbl.status_id = :status_id',       array(':status_id' => $params['STATUS_ID']));
    }
    if(safe($params, 'YEAR')) {
      $command -> andWhere('req.year = :year',                 array(':year' => $params['YEAR']));
    }
    if(safe($params, 'PROJECT_TYPE_ID')) {
      $command -> andWhere('prj.type_id = :project_type_id',   array(':project_type_id' => $params['PROJECT_TYPE_ID']));
    }
    if(safe($params, 'SCHOOL_ID')) {      
      $command -> leftJoin('spi_project_school sps',           'sps.project_id=prj.id');      
      $command -> join    ( 'spi_school scl',                  'sps.school_id = scl.id' );
      $command -> andWhere("scl.id = :school_id",              array(':school_id' => $params['SCHOOL_ID']));
    }
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('prj.performer_id = :performer_id', array(':performer_id' => $params['PERFORMER_ID']));
    }
    if(safe($params, 'PAYMENT_TYPE_ID')) {
      $command -> andWhere('tbl.payment_type_id = :payment_type_id', array(':payment_type_id' => $params['PAYMENT_TYPE_ID']));
    }
    if(safe($params, 'RECEIPT_DATE')) {
      $command->andWhere('tbl.receipt_date LIKE "'.safe($params, 'RECEIPT_DATE').'%" ');
    }
    if(safe($params, 'PAYMENT_DATE')) {
      $command->andWhere('tbl.payment_date LIKE "'.safe($params, 'PAYMENT_DATE').'%" ');
    }
    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere('tbl.request_id = :request_id', array(':request_id' => $params['REQUEST_ID']));
      $command -> order('tbl.rate_id');
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
        $command->andWhere("sps.school_id = :school_id", array(':school_id' => $this->user['relation_id']));
        $command->andWhere("prj.type_id = 3");
        break;
    }
    return $command;
  }
  
  protected function doAfterSelect($result) {
    if (!safe($_GET, 'list') && !isset($_GET['id']) && $this->user['type'] == TA){
      foreach($result['result'] as &$row) {        
          $schools = Yii::app() -> db -> createCommand()
          -> select('scl.*') -> from('spi_project_school prs')
          -> leftJoin('spi_school scl', 'prs.school_id=scl.id')
          -> leftJoin('spi_request req', 'req.project_id=prs.project_id')
          -> where('req.id=:id', array(':id' => $row['request_id'])) 
          -> queryAll();
          $row['schools'] = $schools;
      };        
    };
    if(safe($_GET, 'list') == 'summary'){
      if(sizeof($result['result']) == 1){
        $summary = $this->getSummary($result['result'][0]['request_id'], $result['result'][0]['year'], $result['result'][0]['total_cost']);
      }else if(sizeof($result['result']) > 1){
        $res = true;
        for($item = 1; $item < sizeof($result['result']); $item++){
          if($result['result'][$item]['request_id'] != $result['result'][$item - 1]['request_id']){
            $res = false;
          };
        };
        if($res){
          $summary = $this->getSummary($result['result'][0]['request_id'], $result['result'][0]['year'], $result['result'][0]['total_cost']);
        };
      }else{
        $command = Yii::app() -> db -> createCommand()
                  ->select('prj.id project_id, prj.code project_code, req.*')
                  ->from('spi_project prj')    
                  ->join  ('spi_request req','req.project_id = prj.id' )
                  ->leftJoin($this->table.' tbl', 'tbl.request_id = req.id')
                  ->where ('req.status_id = 5')
                  ->andWhere ('req.id = :id', array(':id' => safe($_GET, 'request_id')))
                  ->andWhere ('req.year = :year',     array(':year' => safe($_GET, 'year')))
                  ->queryAll();
        $result['result'] = $command;
      };
      if(safe($summary,'actual')){   
        $result['result'][0]['changes']  = $summary['changes'];
        $result['result'][0]['spending'] = $summary['spending'];
        $result['result'][0]['remained'] = $summary['remained'];
        $result['result'][0]['payed']    = $summary['payed'];
        $result['result'][0]['actual']   = $summary['actual'];
      }
    };
    
    return $result;
  }
  
  public function getSummary ($request_id, $year, $total_cost) {
    $summary = [
        'changes'     =>  0,
        'spending'    =>  0,
        'remained'    =>  0,
        'payed'       =>  0,
        'actual'      =>  0
      ];
    
    $financial_requests = Yii::app() -> db -> createCommand()
                          ->select('tbl.*')
                          ->from($this -> table . ' tbl')
                          ->join('spi_request req', 'req.id = tbl.request_id')
                          ->where ('tbl.request_id = :id', array(':id' => $request_id))
                          ->andWhere ('req.year = :year', array(':year' => $year))
                          -> queryAll();
    
    foreach($financial_requests as $request){
        if($request['status_id'] == '3'){          
          if($request['payment_type_id'] == '1'){
            $summary['payed'] += (integer) $request['request_cost'];
          }else{          
            if($request['payment_type_id'] == '2'){
              $summary['changes'] -= (integer) $request['request_cost'];
            };
            if($request['payment_type_id'] == '3'){
              $summary['changes'] += (integer) $request['request_cost'];
            };
         }
        };
      $summary['actual'] = $total_cost +  (integer) $summary['changes'];
      $summary['remained'] = $summary['actual'] -(integer) $summary['payed'];
    };
    return $summary;
  }
  
}
