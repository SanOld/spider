<?php

class MockupController extends Controller {

  public function actionIndex($name)
  {
    $this->layout = false;
    
    $this->render($name);
  }
  public function demo()
  {
    if(Yii::app()->params['hideDemo']) {
      echo(' style="display:none;" ');
    }
  }

}