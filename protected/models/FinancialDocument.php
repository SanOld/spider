<?php
require_once ('utils/utils.php');


class FinancialDocument extends BaseModel {
  public $table = 'spi_district';
  public $post = array();
  public $href = '';
  public $select_all = " * ";

  public function addContent($file) {
    $fileContent = file($file);
    foreach($fileContent as &$row){
      $row = explode(',', $row);
      $params = array(
        'name'     => $row[2],
        'address'  => $row[3],
        'plz'      => $row[4],
        'city'     => $row[5],
        'phone'    => $row[6],
        'fax'      => $row[7],
        'email'    => $row[8],
        'homepage' => $row[9]
      );
      Yii::app ()->db->createCommand()->insert($this->table, $params);
    }
    unlink($file);
  }
}
