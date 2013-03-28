<?php

/**
 * Autoload classes based on the classname
 *
 * @param string $className
 * @throws Exception
 */
function __autoload($className)
{
    $path = LIB_PATH.$className.'.php';

    if (substr($className, 0, 8) === 'Modifier') {
        $path = LIB_PATH.'modifiers/'.$className.'.php';
    }

    if (is_file($path)) {
        require_once $path;
    } else {
        throw new Exception('unable to locate class '.$className);
    }
}