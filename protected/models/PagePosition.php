<?php
require_once ('utils/utils.php');

class PagePosition extends BaseModel {
  public $table = 'spi_page_position';
  public $post = array();
  public $select_all = ' * ';
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
    $params = array_change_key_case($params, CASE_UPPER);
    if (safe($params, 'PAGE_ID')) {
      $command->andWhere("tbl.page_id = :page_id", array(':page_id' => $params['PAGE_ID']));
    }
    if (safe($params, 'EXCEPT') && $params['EXCEPT'] == 'hint') {
      $sub = Yii::app()->db->createCommand()->select('position_id')->from('spi_hint');
      if (safe($params, 'PAGE_ID')) {
        $sub->where("page_id = :page_id", array(':page_id' => $params['PAGE_ID']));
      }
      $exceptIds = $sub->queryColumn();
      $command->andWhere(array('not in', 'id', $exceptIds));
    }
    return $command;
  }

}
