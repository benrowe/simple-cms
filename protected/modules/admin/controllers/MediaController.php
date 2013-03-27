<?php

/**
 * Handles the management of files within the
 *
 * @todo
 */
class MediaController extends AdminController
{

	public function actionRename($path)
	{
		$this->forward('move');
	}

	public function actions()
	{
		return array(
			'upload'=>array(
				'class'      => 'xupload.actions.XUploadAction',
				'path'       => Yii::getPathOfAlias('webroot.media'),
				'publicPath' => Yii::app()->baseUrl .'/media',
            ),
		);
	}

	/*public function actionUpload()
	{
		$request = Yii::app()->request;
		$path = $request->getParam('path', '');

		$directory = MediaDirectory::factory($path);
		$model = MediaUploadForm::loadFromDirectory($directory);

		$this->ajaxValidateModel($model);

		if(isset($_POST['MediaUploadForm'])) {
			// process upload
			if ($model->validate(null, false)) {
				if ($model->save()) {

					$this->redirect(array('index', 'path' => $path));
				}
			} else {
			}
		}
		exit;
		$this->render('upload', array(
			'directory' => $directory,
			'model'     => $model
		));
	}*/

	/**
	 * Create a new directory
	 *
	 * @param  string $path the base path of where to load the directory
	 */
	public function actionNewDirectory($path)
	{
		$directory = MediaDirectory::factory($path);
		$model = NewDirectoryForm::loadFromDirectory($directory);

		$this->ajaxValidateModel($model);

		if(isset($_POST['NewDirectoryForm']) || isset($_GET['name'])) {
			// process form
			if(isset($_POST['NewDirectoryForm'])) {
				$model->attributes = $_POST['NewDirectoryForm'];
			} else {
				$model->name = $_GET['name'];
			}

			if($model->validate()) {
				try {
					if($model->save()) {
						Yii::app()->user->setFlash('success', 'Added directory "'.$model->name.'"');
						$this->redirect(array('index', 'path' => $directory->pathCoded));
					}
				} catch(CException $e) {
					$model->addError('name', $e->getMessage());
				}
			}
		}

		$this->render('newdirectory', array(
			'directory' => $directory,
			'model' => $model,
		));
	}

	public function actionDownload($path)
	{
		$wr = Yii::getPathOfAlias('webroot');
		try {
			$file = Yii::app()->request->getParam('file');
			if($file) {
				$file = MediaFile::factory($file, $path);
				$name = $file->filename;


				$wrRelPath = substr($file->fullPath, strlen($wr)+1);
				Yii::app()->request->xSendFile($wrRelPath);
			} else {
				$directory = MediaDirectory::factory($path);
				$path = Yii::getPathOfAlias('application.runtime.tmp');
				if(!file_exists($path)) {
					mkdir($path, 0755, true);
				}
				$tmpZipName = time().'.zip';
				$tmpZipPath = $path.DIRECTORY_SEPARATOR.$tmpZipName;

				if($directory->createArchive($tmpZipPath)) {
					$wrRelPath = substr($tmpZipPath, strlen($wr)+1);
					Yii::app()->request->xSendFile($wrRelPath, array(
						'saveName' => $directory->name.'.zip'
					));
				} else {

					throw new CHttpException(500, 'unable to create archive');
				}
			}
		} catch(CException $e) {
			throw new CHttpException(404, 'unknown file');
		}


	}

	/**
	 * @todo complete delet updatereferences functionality
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function actionDeleteDir($path)
	{
		$directory = MediaDirectory::factory($path);
		$request = Yii::app()->request;
		$confirm = $request->getParam('confirm', false);

		if($confirm === false) {
			$this->render('deletedir', array(
				'directory'	=> $directory
			));
		} else {
			$parent = $directory->parent;

			// get a list of all the files within this sub-directory recursively
			if($directory->delete()) {
				/*$updateReferences = $request->getParam('update', false) !== false;
				if($updateReferences) {
					//WebItemHelper::updateMediaReferences();
				}*/
				Yii::app()->user->setFlash('success', 'removed directory '.$directory->name);
				$this->redirect(array('index', 'path' => $parent->pathCoded));
			}
		}
	}

	/**
	 * Delete's the selected file
	 * @param  string $path
	 * @param  file $file
	 * @todo refactor, include form model & proper validation
	 */
	public function actionDeletefile($path, $file)
	{
		$file = MediaFile::factory($file, $path);
		$request = Yii::app()->request;
		$confirm = $request->getParam('confirm', false);

		if($confirm === false) {
			$this->render('delete', array(
				'file' => $file,
			));
		} else {
			// perform the delete action
			$path = $file->parent->pathCoded;
			if($file->delete()) {

				// update old references, if requested
				$updateReferences = $request->getParam('update', false) !== false;
				if ($updateReferences) {
					WebItemHelper::updateMediaReferences($file->relatedItems, $file->mediaUrl, false);
				}

				Yii::app()->user->setFlash('success', 'removed file '.$file->mediaUrl);
				$this->redirect(array('index', 'path' => $path));
			}
		}
	}

	public function actionCopyDir($path)
	{
		$directory = MediaDirectory::factory($path);
		$request = Yii::app()->request;
		$confirm = $request->getParam('confirm', false);

		if($confirm !== false) {
			//$path = $file->parent->pathCoded;
			$newDir = $request->getParam('newPath');

			if($directory->copy($newDir)) {
				Yii::app()->user->setFlash('success', 'copied directory '.$newDir);
				$this->redirect(array('index', 'path' => $newDir));
			}
		}
		$this->render('copydir', array(
			'directory' => $directory,
		));
	}

	public function actionRenamedir($path)
	{
		$this->forward('movedir');
	}

	public function actionMoveDir($path)
	{
		$directory = MediaDirectory::factory($path);
		$request = Yii::app()->request;
		$confirm = $request->getParam('confirm', false);

		if($confirm !== false) {
			$newDir = $request->getParam('newPath');

			if($directory->move($newDir)) {
				Yii::app()->user->setFlash('success', 'moved directory '.$newDir);
				$this->redirect(array('index', 'path' => $newDir));
			}
		}
		$this->render('movedir', array(
				'directory'	=> $directory
			));
	}

	/**
	 * Move a file
	 *
	 * @todo refactor, include form model & proper validation
	 *
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function actionMove($path, $file)
	{
		$file = MediaFile::factory($file, $path);

		$confirm = $request->getParam('confirm', false);

		if($confirm === false) {
			$this->render('move', array(
				'file' => $file,
			));
		} else {
			$newDir = MediaDirectory::factory($request->getParam('newPath'));
			$newFile = $newDir->getPathCoded().'/'.$request->getParam('newFile');
			$path = $file->parent->pathCoded;
			if($file->move($newFile)) {
				$updateReferences = $request->getParam('update', false) !== false;
				if ($updateReferences) {
					WebItemHelper::updateMediaReferences($file->relatedItems, $file->mediaUrl, $newFile);
				}
				Yii::app()->user->setFlash('success', 'moved file to '.$newFile);
				$this->redirect(array('index', 'path' => $path));
			}
		}
	}

	/**
	 * Copy a file
	 * @param  [type] $path [description]
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	public function actionCopy($path, $file)
	{
		$file = MediaFile::factory($file, $path);
		$request = Yii::app()->request;
		$confirm = $request->getParam('confirm', false);

		if($confirm === false) {
			$this->render('copy', array(
				'file' => $file,
			));
		} else {
			$path = $file->parent->pathCoded;
			$newDir = MediaDirectory::factory($request->getParam('newPath'));
			$newFile = $newDir->getPathCoded().'/'.$request->getParam('newFile');

			if($file->copy($newFile)) {
				Yii::app()->user->setFlash('success', 'copied file '.$newFile);
				$this->redirect(array('index', 'path' => $path));
			}
		}
	}


	/**
	 * Display the list of files & directories for the selected path + related functionality
	 *
	 * List the existing media
	 * Quick upload of media into the specified directory
	 * Replacement of media
	 * deletion of media!
	 * @return [type] [description]
	 */
	public function actionIndex()
	{
		$request = Yii::app()->request;

		$path = $request->getParam('path', '');
		try {
			$dir = MediaDirectory::factory($path);
		} catch(CException $e) {
			Yii::app()->user->setFlash('error', 'unable to load '.$path);
			$newPath = strpos($path, MediaDirectory::DIRECTORY_SEPARATOR_ENCODED) !== false ? substr($path, 0, strrpos($path, MediaDirectory::DIRECTORY_SEPARATOR_ENCODED)) : '';// go back one directory
			$this->redirect(array('index', 'path' => $newPath));
		}



		$this->render('index', array(
			'directory' => $dir,
			'filters' => $request->getParam('type', array()),
			'model' => $model = MediaUploadForm::loadFromDirectory($dir)
		));

	}

	public function actionUpdate()
	{
		$this->render('update');
	}

	public function actionView($path, $file)
	{
		$file = $this->loadFile($path, $file);
		$this->render('view', array(
			'file' => $file
		));
	}

	/**
	 * validate the path & value values on all requests!
	 * @param  [type] $action [description]
	 * @return [type]         [description]
	 */
	protected function beforeAction($action)
	{
		// ensure that the path & file attributes of the request haven't got tampered data!
		$request = Yii::app()->request;
		$file = $request->getParam('file', false);
		$path = $request->getParam('path', false);
		if (!$this->_checkPathValue($file, true) || !$this->_checkPathValue($path)) {
			// there is something wrong with one of the paths, let's just abort to
			// be safe
			throw new CHttpException(500, 'unable to process the request due to inappropriate path details');
			return false;
		}

		return parent::beforeAction($action);
	}

	/**
	 * Loads the media file based on it's path & file
	 * @param  string $path
	 * @param  string $file
	 * @return string
	 */
	private function loadFile($path, $file)
	{
		try {
			return MediaFile::factory($file, $path);
		} catch (Exception $e) {
			throw new CHttpException(404, 'Unknown file');
			return false;
		}
	}

	private function _checkPathValue($value, $isFile = false)
	{
		if($value === false) {
			return true; // invalid value to check
		}

		// ensure the media file is a valid extension!
		if($isFile && !in_array(strtolower(pathinfo($value, PATHINFO_EXTENSION)), $this->_allowedExtensions())) {
			return false;
		}

		// any requests that start with a dot, contain a directory separator, or a double dot!
		return preg_match("/(^\.)|\/|\.\./", $value) ? false : true;
	}

	private function _allowedExtensions()
	{
		$config = Config::instance();
		return $config->mediaExtensions;
	}

	/**
	 * Generates the breadcrumb array for the index & view pages..
	 *
	 * @param  MediaFile|MediaDirectory $item The item to build the breadcrumb
	 * @return array
	 * @todo  tidy this bitch
	 */
	protected function _buildBreadcrumbs($item = null, $action = null)
	{
		$items = array(
			'Admin' => array('default/index'),
			'Media Manager',
		);

		if($item !== null) {
			$dir = $item instanceof MediaDirectory ? $item : $item->parent;
			$file = $item instanceof MediaFile ? $item : false;

			$path = $dir->pathCoded;
			$dirBits = explode(MediaDirectory::DIRECTORY_SEPARATOR_ENCODED, $path);

			if(!empty($path) || $file !== false) {
				unset($items[0]);
				$items['Media Manager'] = array('media/index');
			}

			if(!empty($path)) {
				$tmp = '';
				foreach($dirBits as $i=>$dir) {
					$tmp .= empty($tmp) ? $dir : '.'.$dir;
					if($i == count($dirBits)-1 && $file === false && $action === null)  {
						$items[] = $dir;
					} else {
						$items[$dir] = array('index', 'path' => $tmp);
					}
				}
			}
			if($file !== false) {
				if ($action === null) {
					$items[] = $file->filename;
				} else {
					$items[$file->filename] = array('view', 'path' => $file->parent->pathCoded, 'file' => $file->filename);
				}
			}
			if($action !== null) {
				$items[] = $action;
			}
		}

		return $items;
	}

	protected function ajaxValidateModel($model)
	{
		if(isset($_POST['ajax'])) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}