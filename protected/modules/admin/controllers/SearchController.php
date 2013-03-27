<?php

class SearchController extends AdminController
{
	public function actionIndex()
	{
		$request = Yii::app()->request;
		$query = $request->getParam('query');
		
		$model = new User;
		
		if (!empty($query)) {
		
			$wim = new WebManager();
			$search = new WebSearch(array(
				'sources' => array(
					$wim->getAll(null),
					User::model()->getAll()
				)
			));

			$this->render('results', array(
				'dataProvider' => new CArrayDataProvider($search->search($query)->toArray()),
				'query' => $query,
				'model' => $model
			));
			
		} else {
			$this->render('index', array('model' => $model));
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