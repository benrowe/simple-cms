<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModifierCss
 *
 * @author ben
 */
class ModifierImage extends ModifierAbstract
{
    private $_params;

    /**
     * Get all available parameters for this modifier
     *
     * @return array
     */
    public function getParams()
    {
        if ($this->_params === null) {
            $tmp = $_GET;
            unset($tmp['file']);
            $this->_params = $tmp;
        }
        return $this->_params;
    }

    /**
     * get a specific parameter based on its key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        $p = $this->getParams();
        if (isset($p[$key])) {
            return $p[$key];
        }
        return $default;
    }

    public function modify()
    {

        return count($this->getParams()) !== 0;
    }

    public function isModable(File $file)
    {
        $ext = $file->getExtension();
        if (in_array($ext, array('png', 'jpg', 'gif'))) {
            return true;
        }
        return false;
    }
    
    public function modifyFile(File $file)
    {
        // do we need to modify this image?
        if (!$this->modify()) {
            return $file;
        }

        $ext = $file->getExtension();
        $cacheName = md5($_SERVER['REQUEST_URI']).'.'.$ext;
        $cachePath = CACHE_PATH.$cacheName;

        $p = $this->params;
        if (!is_file($cachePath)) {
            $img = Image::fromFile($file);

            switch($this->getParam('action')) {
                case 'canvas':
                    $img->canvas($this->getParam('width'), $this->getParam('height'), $this->getParam('bg', '000'));
                    break;
                case 'cropfrom':
                    $img->cropfrom($this->getParam('width'), $this->getParam('height'), $this->getParam('where', 'top-left'));
                    break;
                case 'crop':
                    $img->crop($this->getParam('width'), $this->getParam('height'), $this->getParam('x', 0), $this->getParam('y', 0));
                    break;
                default:
                    $img->resize($this->getParam('width'), $this->getParam('height'), $this->getParam('keepaspect') === 'false' ? false : true);
                    break;
            }

            $img->saveTo($cachePath, $ext);
            
        }
        $file = new File($cachePath);

        //$content = file_get_contents($cachePath);

        return $file;
    }
}