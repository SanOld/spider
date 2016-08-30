<?php
require_once ('utils/utils.php');

class DocumentTemplatePlaceholder extends BaseModel {
  public $table = 'spi_document_template_placeholder';
  public $post = array();
  public $select_all = " * ";
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) 
            -> from($this -> table . ' tbl')
            -> leftJoin('spi_document_type_placeholder dtp', 'dtp.placeholder_id = tbl.id');;
    $command -> where(' 1=1 ', array());



    return $command;
  }

    protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    $command = $this->setLikeWhere($command,array('tbl.name', 'tbl.text'),safe($params, 'KEYWORD'));
    if (isset($params['TYPE_ID'])) {
      $command -> andWhere("dtp.document_type_id = :type_id", array(':type_id' => $params['TYPE_ID']));
    }
    if (isset($params['IS_EMAIL'])) {
      $command -> andWhere("dtp.is_email = :is_email", array(':is_email' => $params['IS_EMAIL']));
    }
    if (isset($params['DOCUMENT_ID'])) {
      $command -> andWhere("dtp.email_document_id = :document_id", array(':document_id' => $params['DOCUMENT_ID']));
    }

    return $command;
  }
}
