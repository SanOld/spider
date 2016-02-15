<?php
require_once ('utils/utils.php');


class Performer extends BaseModel {
  public $table = 'spi_performer';
  public $post = array();
  public $select_all = " tbl.*, CONCAT(usp.first_name, ' ', usp.last_name) representative_user";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
        -> from($this -> table . ' tbl')
        -> leftJoin('spi_user usp', 'tbl.representative_user_id = usp.id')
        -> leftJoin('spi_bank_details bnd', 'bnd.performer_id = tbl.id');
    $command -> where(' 1=1 ', array());
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command,
        array('tbl.address', 'tbl.email', "CONCAT(usp.first_name, ' ', usp.last_name)"),
        safe($params, 'KEYWORD'));
    $command = $this->setLikeWhere($command,
        array('bnd.contact_person', 'bnd.iban', 'bnd.bank_name', 'bnd.outer_id'),
        safe($params, 'BANK_DETAILS'));
    if (isset($params['IS_CHECKED'])) {
      $command -> andWhere("tbl.is_checked = :is_checked", array(':is_checked' => $params['IS_CHECKED']));
    }
    return $command;
  }

}
