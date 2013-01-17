<?php

class MediaUploadForm extends CFormModel
{
	public $model;
	public $files = array();
	public $path;

	public static function loadFromDirectory(MediaDirectory $directory)
	{
		$form = new self;
		$form->model = $directory;
		$form->path = $directory->pathCoded;
		return $form;
	}

	public function rules()
	{
		$types = Config::instance()->mediaExtensions;
		return array(
			array('path', 'safe'), // no path = root
			array('files', 'file', 'maxFiles' => 5, 'types' => implode(',', $types), 'maxSize' => 10*1024*1024),
		);
	}

	public function save()
	{
		$attr = 'files';
		try {
			$this->fileUpload($attr);
		} catch(CException $e) {
			// problem trying to upload the files
			$this->addError($attr, $e->getMessage());
			return false;
		}
		return true;
	}

	protected function fileUpload($attribute)
	{
		$basePath = Yii::getPathOfAlias('webroot.media.'.$this->path);
		$filters = Config::instance()->mediaExtensions;

		$files = CUploadedFile::getInstances($this, $attribute);
		if (isset($files) && count($files) > 0) {
			foreach ($files as $file) {
				if (pathinfo($file->name, PATHINFO_EXTENSION) === 'zip') {
					// handle the archive!
					$zip = new Zip;
					$res = $zip->open($file->tempName);
					$zip->filteredExtractTo($basePath, $filters);
					$zip->close();
				} else {
					$savePath = $basePath.DIRECTORY_SEPARATOR.$file->name;
					if (file_exists($savePath)) {
						$this->addError($attribute, $file->name.' exists');
					} else if (!$file->saveAs($savePath)) {
						$this->addError($attribute, 'unable to upload '.$file->name);
					}
				}

			}
		}
		return $files;
	}
}