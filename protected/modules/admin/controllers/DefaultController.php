<?php

/**
 * Default admin controller 
 */
class DefaultController extends AdminController
{


	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('login', 'error'),
				'users' => array('?'), // unauth
			),
			array('allow',
				'actions' => array('index', 'logout', 'cache', 'makeurl', 'error'),
				'users' => array('@'), // auth
			),
			array('deny',
				//'actions'=>array('delete'),
				'users' => array('*'), // all
			)
		);
	}

	public function actionMakeurl()
	{
		$r = Yii::app()->request;
		if ($r->getParam('a')) {
			$url = $this->createAbsoluteUrl($r->getParam('route'), $r->getParam('params', array()));
		} else {
			$url = $this->createUrl($r->getParam('route'), $r->getParam('params', array()));
		}
		echo $url;
	}

	public function actionIndex()
	{
		$this->render('index');
		//$this->forward('/admin/items/index');
		//$this->redirect('admin/items/index');
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('default/index'));
	}

	public function actionLogin()
	{
		Yii::import('application.models.forms.LoginForm');
		$form = new LoginForm;

		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($form);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$form->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($form->validate() && $form->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->layout = 'login';
		$this->render('login', array('model' => $form));
	}

	/**
	 * Clear everything within the cache 
	 */
	public function actionCache()
	{
		WebManager::emptyCache();
		Yii::app()->user->setFlash('success', Yii::t('cat', 'Cleared Cache Successfully'));
		$this->redirect(array('default/index'));
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

	// Uncomment the following methods and override them if needed
	/*
	  public function filters()
	  {
	  // return the filter configuration for this controller, e.g.:
	  return array(
	  'inlineFilterName',
	  array(
	  'class'=>'path.to.FilterClass',
	  'propertyName'=>'propertyValue',
	  ),
	  );
	  }

	  public function actions()
	  {
	  // return external action classes, e.g.:
	  return array(
	  'action1'=>'path.to.ActionClass',
	  'action2'=>array(
	  'class'=>'path.to.AnotherActionClass',
	  'propertyName'=>'propertyValue',
	  ),
	  );
	  }
	 */
}