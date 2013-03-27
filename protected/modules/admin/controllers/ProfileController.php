<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProfileController
 *
 * @package CMS_Controller
 * @author Ben Rowe <ben.rowe.83@gmail.com>
 */
class ProfileController extends AdminController
{

	public function actionIndex()
	{
		Yii::import('application.models.forms.UserForm');
		$model = new UserForm('profile');

		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'profile-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['UserForm'])) {
			$model->setAttributes($_POST['UserForm']);
			if ($model->validate()) {
				$model->save();
				Yii::app()->user->setFlash('success', 'Profile updated');
				$this->redirect(array('default/index'));
			}
		}
		$this->render('index', array(
			'model' => $model
		));
	}

}