<?php

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
	protected function beforeAction($event)
	{
		//print_r(Yii::app()->controller->action->id);
		return true;
	}

	public function actionIndex()
	{
		$this->layout = 'mainWithoutLogin';
		$this->render('index');
	}

	public function actionForgotPassword()
	{
		$this->layout = 'mainWithoutLogin';
		$this->render('forgot-password');
	}

	public function actionResetPassword() {
		$params = array_change_key_case($_GET, CASE_UPPER);
		if(!isset($params['RECOVERY_TOKEN']))
			$this->redirect('/');
		$this->layout = 'mainWithoutLogin';
		$this->render('reset-password');
	}

	public function actionDashboard()
	{
		$this->render('dashboard');
	}

	public function actionUsers() {
		$this->render('users');
	}

	public function actionHints() {
		$this->render('hints');
	}

	public function actionUserRoles() {
		$this->render('user-roles');
	}

	public function actionPerformers() {
		$this->render('performers');
	}

	public function actionSchools() {
		$this->render('schools');
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