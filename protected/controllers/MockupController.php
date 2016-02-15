<?php

class MockupController extends Controller {

  public function actionIndex($name)
  {
    $this->layout = false;
    $this->render($name);
  }

}