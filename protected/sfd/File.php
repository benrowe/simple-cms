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
 * Description of File
 *
 * @package PACKAGE_NAME
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 */
class File extends SplFileInfo
{
    private $_content;

    public function getExtension()
    {
        return strtolower(pathinfo($this->getBasename(), PATHINFO_EXTENSION));
    }

    public function getContent()
    {
        if ($this->_content === NULL) {
            $fileObj = $this->openFile();
            $content = '';
            while (!$fileObj->eof()) {
                $content .= $fileObj->fgets();
            }
            $this->_content = $content;
        }
        return $this->_content;
    }

    public function setContent($content)
    {
        $this->_content = $content;
    }
}