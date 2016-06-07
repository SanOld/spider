<?php
require_once ('utils/utils.php');
              
class SiteController extends Controller
{
    private $path = array('users'           => array(),
                          'user-roles'      => array(),
                          'finance-source'  => array(),
                          'hints'           => array(),
                          'performers'      => array(),
                          'schools'         => array(),
                          'requests'        => array(),
                          'request'         => array(),
                          'projects'        => array(),
                          'dashboard'       => array(),
                          'forgot-password' => array('layout' => 'mainWithoutLogin'),
                          'reset-password'  => array('layout' => 'mainWithoutLogin'),
                          'index'           => array('layout' => 'mainWithoutLogin'),
//                          'index'           => array('render' => 'index',           'layout' => 'mainWithoutLogin'),
                          );
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
	protected function beforeAction($event)
	{
		//print_r(Yii::app()->controller->action->id);
		return true;
	}

	public function actionIndex() {
		$page = safe($_GET,'page','index');
		$pageInfo = safe($this->path,$page);
		if($page == 'reset-password') {
			$params = array_change_key_case($_GET, CASE_UPPER);
			if(!isset($params['RECOVERY_TOKEN']))
				$this->redirect('/');
		} else if($page == 'request') {
			$id = safe($_GET, 'id');
			if(!$id || !$this->validID($page, $id)) {
				$this->redirect('/requests');
			}
		}
		if(safe($pageInfo,'layout')) {
			$this->layout = $pageInfo['layout'];
		}
		$this->render(safe($pageInfo,'render',$page));
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


	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}