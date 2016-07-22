<?php
require_once ('utils/utils.php');
              
class SiteController extends Controller
{
  
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
  
  public function get_pages(){
    $rows = Yii::app()->db->createCommand()
          ->select('pag.page_code, pag.is_without_login')
          ->from('spi_page pag')
          ->queryAll();
    $pages = array();
    foreach($rows as $row){
      $pages[$row['page_code']] = $row['page_code'];
      if($row['is_without_login']){
        $pages[$row['page_code']] = array('layout' =>'mainWithoutLogin');
      };
    };
    return $pages;
  }

  public function actionIndex() {
		$page = safe($_GET,'page','index');
    $pages = $this->get_pages();
		$pageInfo = safe($pages,$page);
    session_start();
		if(safe($pageInfo,'layout')) {
			$this->layout = $pageInfo['layout'];
		}
		if($page == 'reset-password') {
			$params = array_change_key_case($_GET, CASE_UPPER);
			if(!isset($params['RECOVERY_TOKEN']))
				$this->redirect('/');
		}      
    if($_SESSION['rights'][$page] && !$_SESSION['rights'][$page]['show']){       
      $this->redirect('/dashboard');      
    }else {
      try {

        if($page == 'request') {
          $id = safe($_GET, 'id');
          if(!$id || !$this->validID($page, $id)) {
            $this->redirect('/requests');
          }
        } 

        if (!safe($pageInfo,'layout') && empty($_SESSION) && $pages[$page]) {
          $this->redirect('/'); 
        }else{
          $this->render(safe($pageInfo,'render',$page)); 
        }
      } catch (Exception $e) {
        throw new CHttpException(404);        
      }    
    }
  }

	protected function validID($page, $id) {
		switch ($page) {
			case 'request':
				return (bool)Yii::app()->db->createCommand()->select('id')
					->from('spi_request')
					->where('id=:id', array(':id'=>$id))
					->queryScalar();
				break;
		}
		return false;
	}
    
	public function demo() {
		if(Yii::app()->params['hideDemo']) {
			echo(' style="display:none;" ');
		}
	}

	public function actionError() {
		if(safe(Yii::app()->errorHandler->error, 'code') === 404) {
			$this->redirect('404');
		}
	}
	
	public function beforeRender($view) {
		if($view === '404') {
			if(!safe($_COOKIE, 'isLogined')) {
				$this->layout = 'mainWithoutLogin';
			}
			header("HTTP/1.0 404 Page not found");
		}
		return true;
	}

}