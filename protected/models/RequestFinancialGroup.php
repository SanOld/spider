<?php
require_once ('utils/utils.php');


class RequestFinancialGroup extends BaseModel {
  public $table = 'spi_request_financial_group';
  public $post = array();
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function doBeforeInsert($post) {
    $post['overhead_cost'] = 1800;
    $post['rate'] = Yii::app() -> db -> createCommand() -> select('rate') -> from('spi_project')
                               -> where('id=:id', array(':id' => safe($post,'project_id'))) 
                               -> queryScalar();
    
    return array(
        'result' => true,
        'params' => $post
    );
  }
//$data['overhead_cost'] = 1800;
}
