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
 * Description of Component
 *
 * @package PACKAGE_NAME
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 */
class Component
{
    public function __get($name)
    {
        $methodName = 'get'.ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        return null;
    }

    public function __set($name, $value)
    {
        $methodName = 'set'.ucfirst($name);
        if (method_exists($this, $methodName)) {
            return $this->$methodName($value);
        }
        return $this;
    }
}