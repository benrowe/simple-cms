<?php

/**
 * @property WebManager $wim
 */
class SiteController extends Controller
{
	private $_webManager;

	public function filters()
	{
		return array(
			array(
                'COutputCache + index, item, type, tag, author, authors',
                //'duration' => 24 * 3600,
                //'id' => 'tmp',
				'varyByRoute' => true,
				'varyByParam' => array('type', 'id', 'slug', 'view'),
            ),
		);
	}


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$items = $this->wim->getFeaturedItems();
		$pages = new Pagination($items->count());

		if (isset($_GET['view']) && $_GET['view'] === 'rss') {

			if (Config::instance()->rssEnabled) {
				$this->renderPartial('rss', array(
					'items' => $items
				));
			} else {
				throw new CHttpException(404, 'rss feed does not exists');
			}

		} else {
			$pages->pageSize = Config::instance()->recordsPerPage*3;
			$items = $pages->applyLimitItems($items);

			$this->render('index', array(
				'items' => $items,
				'pages' => $pages
			));
		}

	}



	/**
	 * Display the requested web item
	 */
	public function actionItem()
	{
		$item = $this->_getItem();

		if ($item->published === false && Yii::app()->user->isGuest) {
			throw new CHttpException(404, 'Item does not exist');
		}

		if (isset($_GET['view']) && $_GET['view'] === 'json') {
			die(require_once $item->path);
		} else {

			$this->render('item-'.$item->type, array(
				'item' => $item
			));
		}
	}

	public function actionAuthors()
	{
		$users = User::model()->getAll();

		$this->render('users', array(
			'users' => $users
		));
	}

	public function actionAuthor($id)
	{
		$user = User::model()->getById($id);
		if (!$user) {
			throw new CHttpException(404, 'Unknown author');
		}

		$this->render('user', array(
			'user' => $user
		));
	}

	public function test(array $test)
	{
		return '';
	}

	/**
	 * Alias for preview
	 */
	public function actionP()
	{
		$this->forward('preview');
	}

	public function actionPreview()
	{
		if (!Yii::app()->user->isGuest) {
			$item = Yii::app()->user->getState('preview');
			$this->render('item-'.$item->type, array(
				'item' => $item
			));
		} else {
			throw new CHttpException(404, 'Item does not exist');
		}
	}



	/**
	 * list all of the web items based on the provided types
	 */
	public function actionType($type)
	{
		$types = $this->wim->getTypesByIds(explode(',', $type));
        if($types->count() === 0) {
            throw new CHttpException(404, 'unknown type');
        }
		$items = $this->wim->getItemByTypes($types);
		$pages = new Pagination($items->count());

		if (isset($_GET['view']) && $_GET['view'] === 'rss') {
			if (Config::instance()->rssEnabled) {
				$this->renderPartial('rss', array(
					'items' => $items
				));
			} else {
				throw new CHttpException(404, 'rss feed does not exists');
			}
		} else {
			$pages->pageSize = Config::instance()->recordsPerPage;
			$items = $pages->applyLimitItems($items);

			$this->render('type', array(
				'types' => $types,
				'items' => $items,
				'pages' => $pages
			));
		}
	}

	public function actionTag()
	{
		$request = Yii::app()->request;
		$tags = trim($request->getParam('tags'));
		if (empty($tags)) {
			throw new CHttpException(404, "Unknown Tag(s)");
		}
		$tags = preg_split(Config::instance()->tagSplit, $tags);
		$items = $this->wim->getItemsByTags($tags);
		$types = $this->wim->getTypes();
		$pages = new Pagination($items->count());

		if (isset($_GET['view']) && $_GET['view'] === 'rss') {
			$this->renderPartial('rss', array(
				'items' => $items
			));
		} else {
			$pages->pageSize = Config::instance()->recordsPerPage;
			$items = $pages->applyLimitItems($items);

			$this->render('tag', array(
				'tags' => $tags,
				'items' => $items,
				'types' => $types,
				'pages' => $pages
			));
		}

	}

	private function _getItem()
	{
		$request = Yii::app()->request;
		$item = $this->wim->getSingleItem($request->getParam('slug'), $request->getParam('type', 'page'));
		if ($item === false) {
			throw new CHttpException(404, "Unknown Item");
		}
		return $item;
	}

	/**
	 * This is the action to handle external exceptions.
	 */
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

	/**
	 * Gets an instance of the WebItemManager
	 *
	 * @return WebManager
	 */
	public function getWim()
	{
		if (!$this->_webManager) {
			$this->_webManager = new WebManager;
		}
		return $this->_webManager;
	}

}