<?php

class MediaDirectory extends CModel
{
	private $_fullPath;

	const DIR_MEDIA_ALIAS = 'webroot.media';
	const DIRECTORY_SEPARATOR_ENCODED = ':';
	const CHMOD_MODE = 0777;

	/**
	 * takes an encoded path (such as "blah.something.else") and covert it into a valid
	 * MediaDirectory object based on the media root!
	 * @param  string $encodedPath the subdirectory to load
	 * @return self
	 */
	public static function factory($encodedPath = '')
	{
		$fullPath = self::basePath();
		if (!empty($encodedPath)) {
			$fullPath .= DIRECTORY_SEPARATOR.str_replace(self::DIRECTORY_SEPARATOR_ENCODED, DIRECTORY_SEPARATOR, $encodedPath);
		}
		return new self($fullPath);
	}

	public function __construct($path)
	{
		$this->createBasePath();
		$this->setFullPath($path);
	}

	public function createArchive($path)
	{
		$zip = new Zip;
		if($zip->open($path, ZIPARCHIVE::CREATE)) {
			$zip->addDirectory($this->fullPath, $this->fullPath);
			$zip->close();
			return true;
		}
		return false;

	}

	public function attributeNames()
	{
		return array(
			'count',
			'directories',
			'files',
			'fullPath',
			'pathCoded',
			'name'
		);
	}

	public function copy($encodedPath)
	{
		$newPath = self::buildFullPathFromEncoded($encodedPath);
		if($this->_copyDirRecursive($this->fullPath, $newPath)) {
			return new self($newPath);
		}
		return false;
	}

	public function move($encodedPath)
	{
		if(($new = $this->copy($encodedPath)) !== false) {
			// remove old directory
			if(!$this->rrmdir($this->fullPath)) {
				throw new CException('unable to delete old directory');
			}
			return $new;
		}
		return false;
	}

	/**
	 * get the base path of the media directory
	 *
	 * @return string
	 */
	public static function basePath()
	{
		return Yii::getPathOfAlias(self::DIR_MEDIA_ALIAS);
	}

	/**
	 * Create the base path if it does not exist
	 */
	public function createBasePath()
	{
		$path = self::basePath();
		if (!is_dir($path)) {
			mkdir($path, self::CHMOD_MODE, true);
		}
	}

	public static function buildFullPathFromEncoded($encoded)
	{
		$fullPath = self::basePath();
		if(!empty($encoded)) {
			$fullPath .= DIRECTORY_SEPARATOR.str_replace(self::DIRECTORY_SEPARATOR_ENCODED, DIRECTORY_SEPARATOR, $encoded);
		}
		return $fullPath;
	}

	/**
	 * Determines if this directory is the root media directory
	 *
	 * @return boolean
	 */
	public function isRoot()
	{
		$path = $this->getPathCoded();
		return empty($path);
	}

	public function addSubDir($directoryName)
	{
		$newPath = $this->getFullPath().DIRECTORY_SEPARATOR.$directoryName;
		if(is_dir($newPath)) {
			throw new CException('path already exists '.$newPath);
		}
		if(!mkdir($newPath, self::CHMOD_MODE)) {
			throw new CException('unable to create directory '.$newPath);
			return false;
		}
		return true;
	}

	public function getParent()
	{
		return new self(dirname($this->_fullPath));
	}

	/**
	 * returns the relatitive path (to the base media directory) as an
	 * encoded string, where the path separators are replaced with a period (.)
	 *
	 * @return string
	 */
	public function getPathCoded()
	{
		$diff = substr($this->_fullPath, strlen(self::basePath())+1);
		return str_replace(DIRECTORY_SEPARATOR, self::DIRECTORY_SEPARATOR_ENCODED, $diff);
	}

	/**
	 * The name of the directory
	 * @return string
	 */
	public function getName()
	{
		return pathinfo($this->_fullPath, PATHINFO_FILENAME);
	}

	public function setFullPath($path)
	{
		if($path[0] !== '/') {
			throw new CException('path is not absolute');
		} else if(!is_dir($path)) {
			throw new CException('path is not a valid directory');
		}

		$this->_fullPath = $path;
	}

	/**
	 * The number of sub-items within this directory
	 *
	 * @return int
	 */
	public function getCount()
	{
		return count($this->getDirectories()) + count($this->getFiles());
	}

	public function getAll($filters = false)
	{
		return array_merge($this->directories, $this->getFiles($filters));
	}

	/**
	 * Get the sub-directories of this current directory
	 * @return MediaDirectory[]
	 */
	public function getDirectories()
	{
		return $this->_getChildren('directory');
	}

	/**
	 * Get the files
	 *
	 * @return MediaFile[]
	 */
	public function getFiles($filters = false)
	{
		return $this->_getChildren('file', $filters);
	}

	private function _getChildren($type = false, $filters = false)
	{
		$config = Config::instance();
		$exts = $config->mediaExtensions;

		$dh = opendir($this->_fullPath);
		$children = array();
		while(($file = readdir($dh)) !== false) {
			if($file[0] === '.') {
				continue;
			}
			$newPath = $this->_fullPath.DIRECTORY_SEPARATOR.$file;
			if(is_dir($newPath) && ($type === false || $type === 'directory')) {
				$children[] = new MediaDirectory($newPath);
			} else if(is_file($newPath) && (empty($exts) xor in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $exts)) && ($type === false || $type === 'file')) {
				$mf = MediaFile::factory($newPath);
				if($filters === false || in_array($mf->mediaType, $filters)) {
					$children[] = $mf;
				}
			}
		}
		return $children;
	}

	/**
	 * Get the absolute path of the media directory
	 * @return [type] [description]
	 */
	public function getFullPath()
	{
		return $this->_fullPath;
	}

	/**
	 * Delete the directory
	 * @return [type] [description]
	 */
	public function delete()
	{
		return $this->rrmdir($this->fullPath);
	}

	/**
	 * Recursively remove the requested path
	 * @param  string $path file path to remove
	 * @return boolean
	 */
	protected function rrmdir($path)
	{
		if(!is_dir($path)) {
			throw new CException('invalid path '.$path);
		} else if(!is_writable($path)) {
			throw new CException('path not removeable');
		}
		if($dh = opendir($path)) {
			while(false !== ($file = readdir($dh))) {
				if($file === '.' || $file === '..') {
					continue;
				}
				$newPath = $path.DIRECTORY_SEPARATOR.$file;
				if(is_dir($newPath) === true) {
					$this->rrmdir($newPath);
				} else {
					unlink($newPath);
				}
			}
			closedir($dh);
			return rmdir($path);
		}
		return false;
	}

	/**
	 * Get all the related items for any item within this directory
	 * @return array
	 */
	public function getRelatedItems()
	{
		$wim = new WebManager;
		$collection = new WebItemCollection;

		// loop through each file recursively
		foreach($this->directories as $dir) {
			$collection->merge($dir->getRelatedItems());
		}
		foreach($this->files as $file) {
			$collection->merge($wim->getItemsByMediaFile($file->getMediaUrl()));
		}
		var_dump($collection);
		return $collection;//$wim->getItemsByMediaFile($this->getMediaUrl());
	}

	private function _copyDirRecursive($source, $destination)
	{
		if(!is_dir($source)) {
			throw new CException('Source is not a valid dir');
		}
		if(!is_dir($destination)) {
			mkdir($destination, self::CHMOD_MODE, true);
		}
		$dir = opendir($source);
		while(false !== ($file = readdir($dir))) {
			if($file === '.' || $file === '..') {
				continue;
			}
			$old = $source.DIRECTORY_SEPARATOR.$file;
			$new = $destination.DIRECTORY_SEPARATOR.$file;
			if(is_dir($old)) {
				$this->_copyDirRecursive($old, $new);
			} else {
				if(!copy($old, $new)) {
					throw new CException('unable to copy file');
				}
			}
		}
		closedir($dir);
		return true;
	}
}