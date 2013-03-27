<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemsController
 *
 * @package CMS_Controller
 * @author ben
 */
class ItemsController extends AdminController
{

	/**
	 * List all the available items
	 */
	public function actionIndex()
	{
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/publish-date-selector.js', CClientScript::POS_END);

		Yii::import('application.models.forms.WebItemSearchForm');
		$searchModel = new WebItemSearchForm('admin');
		if (isset($_GET['WebItemSearchForm'])) {
			$searchModel->setAttributes($_GET['WebItemSearchForm']);
		}
		$wim = new WebManager();
		$items = $searchModel->search($wim->getAll(false));

		$all = $wim->getAll(false)->count();
		$pub = $wim->getAll()->count();

		$this->render('index', array(
			'search' => $searchModel,
			'types' => $wim->getTypes(false),
			'items' => $items,
			'count' => array(
				'published' => $pub,
				'unpublished' => $all - $pub,
				'all' => $all,
			)
		));
	}

	/**
	 * @todo implement view
	 * @return [type] [description]
	 */
	public function actionView()
	{
		$this->forward('edit');
	}

	/**
	 * feature the selected item
	 *
	 * @throws CHttpException
	 */
	public function actionFeature()
	{
		$webItem = $this->_loadModel();
		if ($webItem->featured === false) {
			$webItem->featured = true;
			$webItem->onSave = function($event) {
				WebManager::EmptyCache();
			};
			if ($webItem->save()) {
				if (Yii::app()->request->isAjaxRequest) {
					$this->renderPartial('//layouts/jsonapi', array(
						'status' => 200,
						'message' => 'ok',
						'data' => array('url' => $this->createAbsoluteUrl('unfeature', array('type' => $webItem->type, 'id' => $webItem->id)))
					));
				} else {
					Yii::app()->user->setFlash('success', $webItem->title." Featured");
					$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
				}
			} else {
				throw CHttpException(500, 'Unable to save item');
			}
		} else {
			$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
		}
	}

	/**
	 * un-feature the selected item
	 *
	 * @throws CHttpException
	 */
	public function actionUnfeature()
	{
		$webItem = $this->_loadModel();
		if ($webItem->featured === true) {
			$webItem->featured = false;
			$webItem->onSave = function($event) {
				WebManager::EmptyCache();
			};
			if ($webItem->save()) {
				if (Yii::app()->request->isAjaxRequest) {
					$this->renderPartial('//layouts/jsonapi', array(
						'status' => 200,
						'message' => 'ok',
						'data' => array('url' => $this->createAbsoluteUrl('feature', array('type' => $webItem->type, 'id' => $webItem->id)))
					));
				} else {
					Yii::app()->user->setFlash('success', $webItem->title." Un-featured");
					$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
				}
			} else {
				throw CHttpException(500, 'Unable to save item');
			}
		} else {
			$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
		}
	}

	/**
	 * publish the selected item
	 *
	 * @throws CHttpException
	 */
	public function actionPublish()
	{
		$webItem = $this->_loadModel();
		if ($webItem->published === false) {
			$webItem->published = true;
			$webItem->datePublished = date('Y/m/d');
			$webItem->onSave = function($event) {
				WebManager::EmptyCache();
			};
			if ($webItem->save()) {
				if (Yii::app()->request->isAjaxRequest) {
					$this->renderPartial('//layouts/jsonapi', array(
						'status' => 200,
						'message' => 'ok',
						'data' => array('url' => $this->createAbsoluteUrl('unpublish', array('type' => $webItem->type, 'id' => $webItem->id)))
					));
				} else {
					Yii::app()->user->setFlash('success', $webItem->title." Published");
					$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
				}
			} else {
				throw CHttpException(500, 'Unable to save item');
			}
		} else {
			$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
		}
	}

	/**
	 * unpublishes the selected item
	 *
	 * @throws CHttpException
	 */
	public function actionUnpublish()
	{
		$webItem = $this->_loadModel();
		if ($webItem->published === true) {
			$webItem->published = false;
			$webItem->onSave = function($event) {
				WebManager::EmptyCache();
			};
			if ($webItem->save()) {
				if (Yii::app()->request->isAjaxRequest) {
					$this->renderPartial('//layouts/jsonapi', array(
						'status' => 200,
						'message' => 'ok',
						'data' => array('url' => $this->createAbsoluteUrl('publish', array('type' => $webItem->type, 'id' => $webItem->id)))
					));
				} else {
					Yii::app()->user->setFlash('success', $webItem->title." Un-published");
					$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
				}
			} else {
				throw CHttpException(500, 'Unable to save item');
			}
		} else {
			$this->redirect(array('/admin/items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
		}
	}

	/**
	 * deletes the selected item
	 *
	 * @throws CHttpException
	 */
	public function actionDelete()
	{
		$webItem = $this->_loadModel();
		$webItem->onDelete = function($event) {
			WebManager::EmptyCache();
		};
		if ($webItem->delete()) {
			Yii::app()->user->setFlash('success', "Item Deleted");
			$this->redirect(array('items/index'));
		}
		throw CHttpException(500, 'Unable to delete item');
	}

	public function actionAdd()
	{
		Yii::import('application.models.forms.WebItemForm');
		$form = new WebItemForm('add');
		$form->authorId = Yii::app()->user->id;

        if (isset($_POST['ajax']) && $_POST['ajax'] == 'item-form') {
            echo CActiveForm::validate($form);
			Yii::app()->end();
        }

		if (isset($_POST['WebItemForm'])) {

			$form->setAttributes($_POST['WebItemForm']);

			if($form->validate()) {
				$clsName = 'WebItem'.ucfirst($form->type);
				$webItem = new $clsName;
				$webItem->setAttributes($form->getAttributes(), false);

				if($form->action === 'preview') {
					Yii::app()->user->setState('preview', $webItem);
				} else {

					$webItem->onSave = function($event) {
						WebManager::emptyCache();
					};
					if ($webItem->save()) {
						Yii::app()->user->setFlash('success', 'Successfully created <a href="'.$this->createUrl('items/edit', array('type' => $webItem->type, 'id' => $webItem->id)).'">'.$webItem->title.'</a>');
						$this->redirect(array('items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
					}
				}
			}

		}
		$this->render('add', array(
			'model' => $form
		));
	}

	public function actionEdit()
	{
		Yii::import('application.models.forms.WebItemForm');
		$form = new WebItemForm('edit');
		$webItem = $this->_loadModel();
		$form->setAttributes($webItem->getAttributes(), false);
		$form->tags = implode(', ', $form->tags);
		$form->data = json_encode($form->data);

		if (isset($_POST['ajax']) && $_POST['ajax'] == 'item-form') {
            echo CActiveForm::validate($form);
			Yii::app()->end();
        }

		//$model = new WebItemForm('edit');
		if (isset($_POST['WebItemForm'])) {
			$form->setAttributes($_POST['WebItemForm']);
			if($form->validate()) {
				$webItem->setAttributes($form->getAttributes(), false);
				if($form->action === 'preview') {
					Yii::app()->user->setState('preview', $webItem);
				} else {
					$webItem->onSave = function($event) {
						WebManager::emptyCache();
					};
					if ($webItem->save()) {
						Yii::app()->user->setFlash('success', 'Successfully updated <a href="'.$this->createUrl('items/edit', array('type' => $webItem->type, 'id' => $webItem->id)).'">'.$webItem->title.'</a>');
						$this->redirect(array('items/index', '#' => 'item_'.$webItem->type.'_'.$webItem->id));
					}
				}
			}
		}


		$this->render('edit', array(
			'model' => $form
		));
	}

	public function actionSearchform()
	{
		Yii::import('application.models.forms.WebItemSearchForm');
		$searchModel = new WebItemSearchForm('admin');
		if (isset($_GET['WebItemSearchForm'])) {
			$searchModel->setAttributes($_GET['WebItemSearchForm']);
		}
		$wim = new WebManager();
		$all = $wim->getAll(false)->count();
		$pub = $wim->getAll()->count();
		$this->renderPartial('_search', array(
			'model' => $searchModel,
			'types' => $wim->getTypes(false),
			'count' => array(
				'published' => $pub,
				'unpublished' => $all - $pub,
				'all' => $all,
			)
		), false, true);
	}

	public function actionEmptyCache()
	{
		WebManager::emptyCache();
		$this->redirect(array('/admin/items/index'));
	}

	private function _loadModel()
	{
		$r = Yii::app()->request;
		$wim = new WebManager;
		$model = $wim->getSingleItem($r->getParam('id'), $r->getParam('type'));
		if (!$model) {
			throw new Exception('unknown model');
		}
		return $model;
	}
}