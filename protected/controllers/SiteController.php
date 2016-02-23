<?php
require_once ('utils/utils.php');
              
class SiteController extends Controller
{
    private $path = array('users'           => array('render' => 'users'),
                          'user-roles'      => array('render' => 'user-roles'),
                          'finance-source'  => array('render' => 'finance-source'),
                          'hints'           => array('render' => 'hints'),
                          'performers'      => array('render' => 'performers'),
                          'schools'         => array('render' => 'schools'),
                          'dashboard'       => array('render' => 'dashboard'),
                          'forgot-password' => array('render' => 'forgot-password', 'layout' => 'mainWithoutLogin'),
                          'reset-password'  => array('render' => 'reset-password',  'layout' => 'mainWithoutLogin'),
                          'index'           => array('render' => 'index',           'layout' => 'mainWithoutLogin'),
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

	public function actionIndex()
	{
        $page = safe($_GET,'page','index');
        $pageInfo = safe($this->path,$page);
        
        if($page == 'reset-password') {
          $params = array_change_key_case($_GET, CASE_UPPER);
          if(!isset($params['RECOVERY_TOKEN']))
            $this->redirect('/');
        }
        if(safe($pageInfo,'layout')) {
          $this->layout = $pageInfo['layout'];
        }
		$this->render($pageInfo['render']);
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