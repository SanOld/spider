<?php

class MockupController extends Controller {

  public function actionIndex($name)
  {
    $this->layout = false;
    try {
      $this->render($name);
    } catch (Exception $e) {
      throw new CHttpException(404);
    }

  }
  public function demo()
  {
    if(Yii::app()->params['hideDemo']) {
      echo(' style="display:none;" ');
    }
  }

}