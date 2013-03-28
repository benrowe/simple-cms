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
 * Handle the http response of the request
 *
 * This is broken down into preparing the response, and delivering the response.
 * Each response is further broken down into headers, and the response content
 *
 * @package Static_File_Deliverer
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 *
 * @property HttpResponseHeader $headers
 * @property string $body
 */
class HttpResponse extends Component
{
    private $_header;
    private $_body;



    public function getHeaders()
    {
        if (!$this->_header) {
            $this->_header = new HttpResponseHeader;
        }
        return $this->_header;
    }


    public function setBody($body)
    {
        $this->_body = $body;
    }

    public function getBody()
    {
        return $this->_body;
    }

    public function deliver()
    {
        $this->headers->deliver();
        $this->_deliverBody();
    }

    private function _deliverBody()
    {
        echo $this->_body;
    }
}