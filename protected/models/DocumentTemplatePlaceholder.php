<?php
require_once ('utils/utils.php');

class DocumentTemplatePlaceholder extends BaseModel {
  public $table = 'spi_document_template_placeholder';
  public $post = array();
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command -> where(' 1=1 ', array());



    return $command;
  }


    protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);

    if (isset($params['IS_EMAIL']) && $params['IS_EMAIL'] == '1') {
      $command -> andWhere("tbl.is_email = :is_email", array(':is_email' => $params['IS_EMAIL']));
    }
    if (isset($params['DOCUMENT_ID'])) {
      $command -> andWhere("tbl.document_id = :document_id", array(':document_id' => $params['DOCUMENT_ID']));
    }

    return $command;
  }
}
