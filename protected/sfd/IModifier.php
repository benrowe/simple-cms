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
 *
 * @author Ben Rowe <browe@arinex.com.au>
 */
interface IModifier
{
    public function modifyFile(File $file);
    
    public function isModable(File $file);
}