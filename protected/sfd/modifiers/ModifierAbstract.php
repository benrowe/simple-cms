<?php

/*
 * Short description for the file
 *
 * Long description for the file (if any)...
 *
 * LICENSE: © Arinex 2011. All rights reserved
 *
 * @package PACKAGE_NAME
 * @copyright © Arinex 2011
 * @version $Id:$
 * @since YYYY/MM/DD
 * @author Ben Rowe <browe@arinex.com.au>
 */

/**
 * Description of ModifierAbstract
 *
 * @package PACKAGE_NAME
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 */
abstract class ModifierAbstract extends Component implements IModifier
{
    private $_debug = false;
    protected $_runOnDebug = true;

    public function runOnDebug()
    {
        return $this->_runOnDebug;
    }

    public function setDebug($debug)
    {
        $this->_debug = $debug;
    }

    public function getDebug()
    {
        
    }
}