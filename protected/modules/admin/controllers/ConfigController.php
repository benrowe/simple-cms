<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConfigController
 *
 * @author ben
 */
class ConfigController extends AdminController
{
	
	public function actionIndex()
	{
		$model = Config::instance();
		
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'config-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		if (isset($_POST['Config'])) {
			$model->setAttributes($_POST['Config']);
			if ($model->validate()) {
				$model->save();
				Yii::app()->user->setFlash('success', 'Config saved');
				$this->redirect(array('config/index'));
			}
		}
		
		$this->render('index', array(
			'model' => $model
		));
	}
}