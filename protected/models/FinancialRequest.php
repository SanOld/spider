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
    }else if(safe($_GET, 'list') == 'summary'){      
      $command = Yii::app() -> db -> createCommand()
                ->select('prj.id project_id, prj.code project_code, req.*, tbl.*')
                ->from('spi_project prj');      
      $command  ->join  ('spi_request req',                       'req.project_id = prj.id' );
      $command  ->leftJoin($this -> table . ' tbl',               'tbl.request_id = req.id');
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
    }
    return $command;
  }
  
  protected function doAfterSelect($result) {
    if (isset($_GET['id'])){
      $row = $result['result'][0];
      $row['schools'] = Yii::app() -> db -> createCommand()
                                      -> select("sch.*
                                                ,CONCAT(IF(user.sex = 1, 'Herr', 'Frau' ), ' ' , user.first_name, ' ', user.last_name)  user_name
                                                , user.function user_function")
                                      -> from('spi_project_school prj_sch')
                                      -> join( 'spi_school sch', 'prj_sch.school_id = sch.id' )
                                      -> leftJoin( 'spi_user user', 'user.id = sch.contact_id' )
                                      -> where('prj_sch.project_id=:id', array(':id' => $row['project_id']))
                                      -> queryAll();
      $result['result'] =  $row;
    }else {
      foreach($result['result'] as &$row) {
        if($row['project_id']){
          $schools = Yii::app() -> db -> createCommand()
          -> select('scl.*') -> from('spi_project_school prs')
          -> leftJoin('spi_school scl', 'prs.school_id=scl.id')
          -> where('prs.project_id=:id', array(':id' => $row['project_id'])) 
          -> queryAll();
          $row['schools'] = $schools;
        };
      };
    };
    return $result;
  }
  
}
