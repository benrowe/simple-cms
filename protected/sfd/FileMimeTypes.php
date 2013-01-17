<?php

/*
 * Short description for the file
 *
 * Long description for the file (if any)...
 *
 * LICENSE: © Arinex 2011. All rights reserved
 *
 * @package Static_File_Deliverer
 * @copyright © Arinex 2011
 * @version $Id:$
 * @since YYYY/MM/DD
 * @author Ben Rowe <browe@arinex.com.au>
 */

/**
 * Description of FileMimeTypes
 *
 * @package Static_File_Deliverer
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 */
class FileMimeTypes
{
    private $_mimes = array(
        'css'   => 'text/css',
        'less'  => 'text/css',
        'js'    => 'text/javascript',
        'jpg'   => 'image/jpeg',
        'gif'   => 'image/gif',
        'png'   => 'image/png'
    );

    /**
     * Get the requested mime type based on the extension
     *
     * @param string $extensionName
     * @return string
     */
    public function get($extensionName)
    {
        if ($this->exists($extensionName)) {
            return $this->_mimes[$extensionName];
        }
        return null;
    }

    /**
     * Check if the mime type exists (against the extension)
     *
     * @param string $extensionName
     * @return boolean
     */
    public function exists($extensionName)
    {
        return array_key_exists($extensionName, $this->_mimes);
    }

    /**
     * Register a mimetype against an extension
     *
     * @param string $extensionName
     * @param string $mimeValue
     */
    public function set($extensionName, $mimeValue)
    {
        $this->_mimes[$extensionName] = $mimeValue;
    }
}