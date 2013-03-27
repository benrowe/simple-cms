<?php

class ContenttypesController extends AdminController
{

	public function actionIndex()
	{
		$wim = new WebManager;
		$types = $wim->getTypes();
		$this->render('index', array(
			'types' => $types
		));
	}

	public function actionCreate()
	{
		$model = new WebType;
		
		$this->render('create', array(
			'model' => $model
		));
	}

	public function actionEdit($id)
	{
		
		$model = $this->_loadModel($id);
		
		$this->render('edit', array(
			'model' => $model
		));
	}

	public function actionJson($id)
	{
		$wim = new WebManager;
		echo file_get_contents($wim->getSingleType($id)->itemAt(0)->path);
	}

	private function _loadModel($id)
	{
		$wim = new WebManager();
		$model = $wim->getSingleType($id)->itemAt(0);
		if (!$model) {
			throw new CHttpException(404, 'unknown type');
		}
		return $model;
	}

}