<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once LIB_PATH.'vendors/lessphp/lessc.inc.php';

/**
 * Description of ModifierCss
 *
 * @author ben
 */
class ModifierLess extends ModifierAbstract
{
    public function isModable(File $file)
    {
        $ext = $file->getExtension();
        if ($ext === 'less') {
            return true;
        }
        return false;
    }
    
    public function modifyFile(File $file)
    {
        // build the cachename
        //$import = $this->_getImportFiles($file->getPathname());
        $name = $file->getBasename('.less');
        $cacheFile = CACHE_PATH.$name.md5($file->getPathname().$file->getMTime()).'.css';
        if (!file_exists($cacheFile)) {
            $less = new lessc($file->getPathname());
            
            lessc::ccompile($file->getPathname(), $cacheFile);
        }
        $file = new File($cacheFile);
        return $file;
    }


}