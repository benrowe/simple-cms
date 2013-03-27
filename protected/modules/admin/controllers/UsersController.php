<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsersController
 *
 * @package CMS_Controller
 * @author Ben Rowe <ben.rowe.83@gmail.com>
 */
class UsersController extends AdminController
{


	/**
	 * Display all users 
	 */
	public function actionIndex()
	{
		$users = User::model()->getAll();
		$this->render('index', array(
			'users' => $users
		));
	}

	/**
	 * Create a new user 
	 */
	public function actionCreate()
	{
		$model = new User('create');

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['User'])) {
			$model->setAttributes($_POST['User']);
			if ($model->validate()) {
				$model->onSave = function() {
					WebManager::emptyCache();
				};
				$model->save();
				Yii::app()->user->setFlash('success', $model->display.' created');
				$this->redirect(array('users/index'));
			}
		}

		$this->render('create', array(
			'model' => $model
		));
	}

	/**
	 * Edit an existing user 
	 */
	public function actionEdit()
	{
		$model = $this->_loadModel();
		$pwd = $model->password;
		$model->password = '';

		if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['User'])) {
			$model->setAttributes($_POST['User']);
			if ($model->password === '') {
				$model->password = $pwd;
			}
			if ($model->validate()) {
				$model->onSave = function() {
					WebManager::emptyCache();
				};
				$model->save();
				Yii::app()->user->setFlash('success', $model->display.' updated');
				$this->redirect(array('users/index'));
				//$this->redirect(array('users/view', 'id' => $model->id));
			}
		}

		$this->render('edit', array(
			'model' => $model
		));
	}

	/**
	 * Delete an existing user 
	 */
	public function actionDelete()
	{
		$model = $this->_loadModel();
		if (Yii::app()->user->id === $model->id) {
			Yii::app()->user->setFlash('warning', 'You can not delete yourself!');
			$this->redirect(array('users/index'));
		}
				
		$model->onDelete = function($event) {
			WebManager::EmptyCache();
		};
		if ($model->delete()) {
			Yii::app()->user->setFlash('success', "User Deleted");
			$this->redirect(array('users/index'));
		}
		throw CHttpException(500, 'Unable to delete item');
	}

	/**
	 * View details of an existing user 
	 */
	public function actionView()
	{
		$this->redirect(array('users/index'));
		
		$model = $this->_loadModel();
		
	}

	/**
	 * Load the user model based on the primary key
	 * 
	 * @return User
	 * @throws CHttpException 
	 */
	private function _loadModel()
	{
		$id = Yii::app()->getRequest()->getParam('id');
		$user = User::model()->getById($id);
		if (!$user) {
			throw new CHttpException(404, 'Unknown User');
		}
		return $user;
	}

}