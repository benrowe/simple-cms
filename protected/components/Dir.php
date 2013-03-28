<<<<<<< HEAD
<?php

/**
 * Represents a directory within the existing filestructure. Provides functionality for
 * finding & changing details about the current directory + locating files & resources
 * within the specified directory
 * 
 * 
 *
 * @package CMS_IO_Filesystem
 * 
 * @author Ben Rowe <ben.rowe.83@gmail.com>
 * @property string $path
 * 
 */
class Dir extends CComponent
{

    /**
     *
     * @var string
     */
    private $_path;

    /**
     * Constructor
     * Specify the directory path
     * 
     * @param string $path 
	 * @throws Exception
     */
    function __construct($path)
    {
		$realPath = realpath($path);
		if (!$realPath) {
			throw new Exception('Unable to resolve path "'.$path.'"');
		}
        $this->path = $realPath;
    }

    /**
     * Retrieve a list of files that match the patter
     * 
     * @param string $regexPattern
     * @param boolean $recursive 
     * @return array
     */
    public function findFiles($regexPattern, $recursive = false)
    {
        return $this->_findFiles($this->path, $regexPattern, $recursive);

        
    }

    /**
     * Find all files within the specified directory
     * 
     * @param string $path
     * @param string $pattern
     * @param boolean $recursive
     * @return array 
     */
    public static function findAllFiles($path, $pattern = null, $recursive = true)
    {
        $d = new self($path);
        return $d->findFiles($pattern, $recursive);
    }

    /**
     * determine if the current directory path exists
     * 
     * @return boolean 
     */
    public function exists()
    {
        return $this->_exists($this->path);
    }

    /**
     * get the current directory path
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * change the directory path
     * 
     * @param string $path 
     */
    public function setPath($path)
    {
        $this->_path = $path;
    }

    /**
     * Check if the path exists as a directory
     * 
     * @param string $path
     * @return boolean
     */
    private function _exists($path)
    {
        return file_exists($path) && is_dir($path);
    }

    /**
     * Find all files within the specified path, that match the pattern (if supplied)
     * 
     * @param string $path the path to scan
     * @param string $regexPattern the regex pattern to filter the find results
     * @param boolean $recursive recursively scan through directories
     * @return array|boolean false on invalid path
     */
    private function _findFiles($path, $regexPattern = null, $recursive = false)
    {
        
        if ($this->_exists($path)) {
            $files = array();
            foreach (new DirectoryIterator($path) as $iteminfo) {
                $pathname = $iteminfo->getPathname();
                if ($iteminfo->isFile() && ($regexPattern === null || (preg_match($regexPattern, $pathname)))) {
                    $files[] = $pathname;
                } else if ($iteminfo->isDir() && !$iteminfo->isDot() && $recursive) {
                    $dirFiles = $this->_findFiles($pathname, $regexPattern, $recursive);
                    if (is_array($dirFiles)) {
                        $files = array_merge($files, $dirFiles);
                    }
                }
            }
            return $files;
        }
        return false;
    }
  
=======
<?php

/**
 * Represents a directory within the existing filestructure. Provides functionality for
 * finding & changing details about the current directory + locating files & resources
 * within the specified directory
 * 
 * 
 *
 * @package CMS_IO_Filesystem
 * 
 * @author Ben Rowe <ben.rowe.83@gmail.com>
 * @property string $path
 * 
 */
class Dir extends CComponent
{

    /**
     *
     * @var string
     */
    private $_path;

    /**
     * Constructor
     * Specify the directory path
     * 
     * @param string $path 
	 * @throws Exception
     */
    function __construct($path)
    {
		$realPath = realpath($path);
		if (!$realPath) {
			throw new Exception('Unable to resolve path "'.$path.'"');
		}
        $this->path = $realPath;
    }

    /**
     * Retrieve a list of files that match the patter
     * 
     * @param string $regexPattern
     * @param boolean $recursive 
     * @return array
     */
    public function findFiles($regexPattern, $recursive = false)
    {
        return $this->_findFiles($this->path, $regexPattern, $recursive);

        
    }

    /**
     * Find all files within the specified directory
     * 
     * @param string $path
     * @param string $pattern
     * @param boolean $recursive
     * @return array 
     */
    public static function findAllFiles($path, $pattern = null, $recursive = true)
    {
        $d = new self($path);
        return $d->findFiles($pattern, $recursive);
    }

    /**
     * determine if the current directory path exists
     * 
     * @return boolean 
     */
    public function exists()
    {
        return $this->_exists($this->path);
    }

    /**
     * get the current directory path
     * 
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * change the directory path
     * 
     * @param string $path 
     */
    public function setPath($path)
    {
        $this->_path = $path;
    }

    /**
     * Check if the path exists as a directory
     * 
     * @param string $path
     * @return boolean
     */
    private function _exists($path)
    {
        return file_exists($path) && is_dir($path);
    }

    /**
     * Find all files within the specified path, that match the pattern (if supplied)
     * 
     * @param string $path the path to scan
     * @param string $regexPattern the regex pattern to filter the find results
     * @param boolean $recursive recursively scan through directories
     * @return array|boolean false on invalid path
     */
    private function _findFiles($path, $regexPattern = null, $recursive = false)
    {
        
        if ($this->_exists($path)) {
            $files = array();
            foreach (new DirectoryIterator($path) as $iteminfo) {
                $pathname = $iteminfo->getPathname();
                if ($iteminfo->isFile() && ($regexPattern === null || (preg_match($regexPattern, $pathname)))) {
                    $files[] = $pathname;
                } else if ($iteminfo->isDir() && !$iteminfo->isDot() && $recursive) {
                    $dirFiles = $this->_findFiles($pathname, $regexPattern, $recursive);
                    if (is_array($dirFiles)) {
                        $files = array_merge($files, $dirFiles);
                    }
                }
            }
            return $files;
        }
        return false;
    }
  
>>>>>>> fe2c02650a5026a07777acf110af6fc4bb87729b
}