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
class ModifierStripComments extends ModifierAbstract
{
    protected $_runOnDebug = false;

    public function isModable(File $file)
    {
        $ext = $file->getExtension();
        if ($ext === 'css' || $ext === 'js' || $ext === 'less') {
            return true;
        }
        return false;
        
    }
    
    public function modifyFile(File $file)
    {
        $content = $file->getContent();
        $content = preg_replace('!/\*.*?\*/!s', '', $content);
        $file->setContent($content);
        return $file;
    }
}