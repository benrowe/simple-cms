<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileDelivererModifierManager
 *
 * @author ben
 * @property array $modifiers
 */
class FileDelivererModifierManager extends Component
{
    private $_modifiers = array();
    private $_debug = false;

    public function __construct($debug = false)
    {
        $this->_debug = $debug;
    }

    public static function loadModifiers($modifiers, $debug = false)
    {
        $manager = new self($debug);
        foreach ($modifiers as $mod) {
            $className = 'Modifier'.ucfirst($mod);
            $m = new $className;
            $m->setDebug($debug);
            $manager->addModifier($m);
        }
        
        return $manager;
    }
    public function getModifiers()
    {
        return $this->_modifiers;
    }
    
    public function addModifier(IModifier $modifier) 
    {
        $this->_modifiers[] = $modifier;
    }
    
    public function modifyFile(SplFileInfo $file)
    {
        /* @var $modifier ModifierAbstract */
        foreach ($this->modifiers as $modifier) {
            if ($modifier->isModable($file) && (($this->_debug === true && $modifier->runOnDebug()) || $this->_debug === false)) {
                $file = $modifier->modifyFile($file);
            }
        }
        
        return $file;
    }
}