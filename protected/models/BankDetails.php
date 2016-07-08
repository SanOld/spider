<?php
require_once ('utils/utils.php');

class BankDetails extends BaseModel {
  public $table = 'spi_bank_details';
  public $post = array();
  public $select_all = ' * ';
  public $isFinance = true;
  public $request_id = '';

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    
    $where = ' 1=1 ';
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }
    
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('tbl.performer_id = :performer_id', array(
        ':performer_id' => $params['PERFORMER_ID']
      ));

      if(safe($params, 'REQUEST_ID')) {
        $this->request_id = $params['REQUEST_ID'];
      }
    }
    return $command;
  }

    protected function doAfterSelect($result) {

      if($this->request_id != ''){
        $status_id = Yii::app() -> db -> createCommand()
                                    -> select('status_id')
                                    -> from('spi_request tbl')
                                    -> where('tbl.id = :id', array(':id' => $this->request_id))
                                    -> queryScalar();

      if($status_id == '5'){
        foreach($result['result'] as &$row) {
          $row = $this->changeToLock($row);
        }
      }

      }

    return $result;
  }

  protected function changeToLock($row){
    $id = $row['id'];
    $lock_result = Yii::app() -> db -> createCommand()
                                      -> select("*")
                                      -> from('spi_bank_details_lock tbl')
                                      -> where('tbl.bank_details_id=:id', array(':id' => $id))
                                      -> andWhere('tbl.request_id=:request_id', array(':request_id' => $this->request_id))

//            $ttt=$lock_result->text;
                                      -> queryRow();

    unset($lock_result['id']);
    if(!$lock_result){
      return $row;
    } else {
      $new_row = array_replace ($row, $lock_result);
    }
    

    if($new_row){
      return $new_row;
    } else {
      return $row;
    }
  }

}
