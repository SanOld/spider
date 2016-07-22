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

    if (isset($params['IS_EMAIL'])) {
      $command -> andWhere("tbl.is_email = :is_email", array(':is_email' => $params['IS_EMAIL']));
    }
    if (isset($params['DOCUMENT_ID'])) {
      $command -> andWhere("tbl.document_id = :document_id", array(':document_id' => $params['DOCUMENT_ID']));
    }

    return $command;
  }


  protected function calcResults($result) {
    $Request = CActiveRecord::model('Request');
    $Request->user = $this->user;

    if (safe($_GET, 'request_id')) {
      $requestFields = $Request->select(array('id' => safe($_GET, 'request_id')), true);

      $i = count($result);
      foreach ($requestFields['result'][0] as $key => $value) {
        if($key == 'schools'){
          foreach ($requestFields['result'][0][$key][0] as $key2 => $value2) {
            $result['result']['request']['school'][$key2] = $value2 ;
            $i++;
          }
        }
        $result['result']['request'][$key] = $value ;
        $i++;
      }

    } else {
      $requestFields = $Request->select(array('id' => '14'), true);

      $i = count($result);
      foreach ($requestFields['result'][0] as $key => $value) {
        if($key == 'schools'){
          foreach ($requestFields['result'][0][$key][0] as $key2 => $value2) {
            $result['result'][$i]['name'] ='{{request.school.'.$key2.'}}' ;
            $result['result'][$i]['text'] = $key2 ;
            $i++;
          }
        }
        $result['result'][$i]['name'] ='{{request.'.$key.'}}' ;
        $result['result'][$i]['text'] = $key ;
        $i++;
      }
    }

    return $result;
  }
}
