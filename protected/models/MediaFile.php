<?php

/**
 * represents an existing media file
 */
class MediaFile extends CModel
{
	private $_fullPath;
	static private $_mediaTypes = array(
		'image' => array('jpg', 'gif', 'png'),
		'video' => array('avi', 'mov', 'mp4', 'mkv'),
		'audio' => array('mp3', 'wav')
	);

	const TYPE_IMAGE = 'image';
	const TYPE_VIDEO = 'video';
	const TYPE_AUDIO = 'audio';

	public function __construct($fullPath)
	{
		$this->setFullPath($fullPath);
	}

	/**
	 * Load the MediaFile based on the filename & path
	 * @param  string $fileName
	 * @param  string $encodedPath
	 * @return MediaFile
	 */
	public static function factory($fileName, $encodedPath = '')
	{
		if ($fileName[0] !== '/') {
			// full path not provided!
			$fullPath = MediaDirectory::buildFullPathFromEncoded($encodedPath).DIRECTORY_SEPARATOR.$fileName;
		} else {
			$fullPath = $fileName;
		}
		$type = self::mediaType(strtolower(pathinfo($fullPath, PATHINFO_EXTENSION)));
		switch($type) {
			case 'image':
				$file = new MediaFileImage($fullPath);
				break;
			default:
				$file = new self($fullPath);
				break;
		}
		return $file;
	}

	public function attributeNames()
	{
		return array(
			'url',
			'fullPath',
			'filename',
			'extensionName',
			'mediaType'
		);
	}

	public function getParent()
	{
		return new MediaDirectory(dirname($this->_fullPath));
	}

	/**
	 * Get the related items that use this media file in some way
	 * @return string
	 */
	public function getRelatedItems()
	{
		$wim = new WebManager;
		return $wim->getItemsByMediaFile($this->getMediaUrl());
	}

	public function delete()
	{
		chmod($this->_fullPath, 0666);
		if (!is_writable($this->_fullPath)) {
			throw new CException('file not writable');
		}
		return unlink($this->_fullPath);
	}

	/**
	 * Copy the file to the new path, based on the media root
	 *
	 * @param  string $newPath path from media root, including file name
	 * @return MediaFile|boolean
	 */
	public function copy($newPath)
	{
		$copyPath = MediaDirectory::basePath().DIRECTORY_SEPARATOR.$newPath;
		if(copy($this->fullPath, $copyPath)) {
			return new self($copyPath);
		}
		return false;
	}

	/**
	 * Move the file to the new path, based on the media root
	 *
	 * @param string $newPath path from media root, including file name
	 * @return MediaFile|boolean
	 */
	public function move($newPath)
	{
		if(($new = $this->copy($newPath)) !== false) {
			if(!unlink($this->fullPath)) {
				throw new CException('unable to remove original file');
			}
			return $new;
		}
	}

	public function setFullPath($path)
	{
		// some basic checks
		if($path[0] !== '/') {
			throw new CException('path is not absolute');
		} else if(!file_exists($path) || !is_readable($path) || !is_file($path)) {
			throw new CException('path does not exist');
		}

		$this->_fullPath = $path;

	}

	public function getMediaUrl()
	{
		$dir = $this->parent->pathCoded;
		if(!empty($dir)) {
			$dir = str_replace(MediaDirectory::DIRECTORY_SEPARATOR_ENCODED, '/', $dir).'/';
		}

		return $dir.$this->getFilename();
	}

	public function getUrl($absolute = false)
	{
		$url = Yii::app()->baseUrl.'/media/'.$this->getMediaUrl();
		if($absolute) {
			$url = 'http://'.Yii::app()->request->getServerName().$url;
		}
		return $url;
	}

	public function getFullPath()
	{
		return $this->_fullPath;
	}

	public function getFilename()
	{
		return basename($this->_fullPath);
	}

	public function getExtensionName()
	{
		return strtolower(pathinfo($this->_fullPath, PATHINFO_EXTENSION));
	}

	/**
	 * get the type of media the file is,
	 * @return string|boolean false on unknown type
	 */
	public function getMediaType()
	{
		return self::mediaType($this->getExtensionName());
	}

	public static function mediaType($ext)
	{
		foreach(self::$_mediaTypes as $type=>$extensions) {
			if(in_array($ext, $extensions)) {
				return $type;
			}
		}
		return false;
	}

	public function __toString()
	{
		try {
			return $this->getFilename();
		} catch (Exception $e) {
			return '';
		}
	}
}