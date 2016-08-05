<?php
require_once ('utils/utils.php');

class FinancialRequest extends BaseModel {
  public $table = 'spi_financial_request';
  public $post = array();
  public $select_all = 'tbl.*, frs.code status_code, rte.name rate, prj.id project_id, prj.code project_code, prf.id performer_id,  req.start_date, req.due_date, req.total_cost,
                        prf.name performer_name, prf.address, req.year, bnk.bank_name kreditor, pat.name payment_name, pat.payment_template_id ';
//  public $isFinance = true;
  protected function getCommand() {
    
    if(safe($_GET, 'list') == 'year') {      
      $command = Yii::app() -> db -> createCommand()->select('req.year')->from('spi_request req')->group('year');
      $command ->rightJoin ($this -> table . ' tbl',              'tbl.request_id = req.id' );
      
    }else if(safe($_GET, 'list') == 'project'){      
      $command = Yii::app() -> db -> createCommand()->select('prj.id project_id, prj.code project_code')->from('spi_project prj')->group('prj.code');      
      $command ->leftJoin  ('spi_request req',                    'req.project_id = prj.id' );
      $command ->rightJoin ($this -> table . ' tbl',              'tbl.request_id = req.id' );
      
    }else{   
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      $command -> leftJoin ('spi_payment_type pat',               'tbl.payment_type_id = pat.id');
      $command -> join     ('spi_rate rte',                       'tbl.rate_id = rte.id');
      $command -> join     ('spi_financial_request_status frs',   'frs.id = tbl.status_id');
      $command -> leftJoin ('spi_bank_details bnk',               'tbl.bank_account_id = bnk.id');
      $command -> leftJoin ('spi_request req',                    'tbl.request_id = req.id');
      $command -> leftJoin ('spi_project prj',                    'req.project_id     = prj.id');
      $command -> leftJoin ('spi_performer prf',                  'prj.performer_id     = prf.id');
      $command -> where    (' 1=1 ', array());
    }
    return $command;
  }
  
  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'PROJECT_ID')) {
      $command -> andWhere('prj.id = :project_id', array(':project_id' => $params['PROJECT_ID']));
    }
    if(safe($params, 'TYPE_ID')) {
      $command -> andWhere('tbl.payment_type_id = :type_id', array(':type_id' => $params['TYPE_ID']));
    }
    if(safe($params, 'STATUS_ID')) {
      $command -> andWhere('tbl.status_id = :status_id', array(':status_id' => $params['STATUS_ID']));
    }
    if(safe($params, 'YEAR')) {
      $command -> andWhere('req.year = :year', array(':year' => $params['YEAR']));
    }
    if(safe($params, 'PROJECT_TYPE_ID')) {
      $command -> andWhere('prj.type_id = :project_type_id', array(':project_type_id' => $params['PROJECT_TYPE_ID']));
    }
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('prj.performer_id = :performer_id', array(':performer_id' => $params['PERFORMER_ID']));
    }
    if(safe($params, 'RECEIPT_DATE')) {
      $command->andWhere('tbl.receipt_date LIKE "'.safe($params, 'RECEIPT_DATE').'%" ');
    }
    if(safe($params, 'PAYMENT_DATE')) {
      $command->andWhere('tbl.payment_date LIKE "'.safe($params, 'PAYMENT_DATE').'%" ');
    }
    
    return $command;
  }
  
  protected function doBeforeUpdate($post, $id) {
    
    unset ($post['payment_date']);
    unset ($post['receipt_date']);
    
    return array(
      'result' => true,
      'params' => $post
    );
    
  }

}
