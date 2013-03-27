<?php

/**
 * Bootstrap for the file deliverer
 *  
 */

/**
 * Inline config (edit as needed)
 */

define('LIB_PATH', 'protected/sfd/');
define('CACHE_PATH', 'protected/runtime/cache/sfd/');


// do not modify
$debug = isset($_GET['debug']);
require_once LIB_PATH.'Autoload.php';



$fd = new FileDeliverer($_GET['file']);
if ($debug) {
    $fd->enableDebug();
}

$modifiers = FileDelivererModifierManager::loadModifiers(array(
    'css',
    'image',
    'less',
    'stripcomments'
), $debug);
$fd->file = $modifiers->modifyFile($fd->file);


$fd->deliver();