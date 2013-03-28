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
 * Reponsible for management of http headers & initial response code sent to the client
 *
 * @package Static_File_Deliverer
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 */
class HttpResponseHeader
{
    private $_headers = array();
    private $_responseCode = self::CODE_SUCCESS_OK;
    private $_codeDescriptions = array(
        200 => 'ok',

        300 => 'multiple choices',
        301 => 'moved permanently',
        302 => 'found',
        304 => 'not modified',
        307 => 'temporary redirect',

        400 => 'bad request',
        401 => 'unauthorized',
        403 => 'forbidden',
        404 => 'not found',
        410 => 'gone',

        500 => 'interal server error',
        501 => 'not implemented',
        503 => 'service unavailable',
        550 => 'permission denied',


    );

    /**
     * Common http response codes
     */
    const CODE_SUCCESS_OK                   = 200;

    const CODE_REDIRECT_MULTIPLE            = 300;
    const CODE_REDIRECT_MOVED               = 301;
    const CODE_REDIRECT_FOUND               = 302;
    const CODE_REDIRECT_NOT_MODIFIED        = 304;
    const CODE_REDIRECT_TEMP_REDIECT        = 307;

    const CODE_CLIENT_ERROR_BAD_REQUEST     = 400;
    const CODE_CLIENT_ERROR_UNAUTHORISED    = 401;
    const CODE_CLIENT_ERROR_FORBIDDEN       = 403;
    const CODE_CLIENT_ERROR_NOT_FOUND       = 404;
    const CODE_CLIENT_ERROR_GONE            = 410;

    const CODE_SERVER_ERROR_INTERNAL        = 500;
    const CODE_SERVER_ERROR_NOT_IMPLEMENTED = 501;
    const CODE_SERVER_ERROR_UNAVAILABLE     = 503;
    const CODE_SERVER_ERROR_PERMISSION      = 550;

    /**
     * Estabish the response code & initial headers
     *
     * @param int $responseCode
     * @param array $headers
     */
    public function __construct($responseCode = self::CODE_SUCCESS_OK, array $headers = null)
    {
        $this->setReponseCode($responseCode);
        if (is_array($headers)) {
            $this->set($headers);
        }
    }

    /**
     * Get all the headers currently set
     *
     * @return array
     */
    public function getAll()
    {
        return $this>_headers;
    }

    /**
     * Add a header, if it exists already it will be appended or over-ridden based on the $replace value
     *
     * @param string $name
     * @param string $value
     * @param boolean $replace
     */
    public function add($name, $value, $replace = true)
    {
        if ($replace || !$this->exists($name)) {
            return $this->set($name, $value);
        } else {
            // append the value (if the exist value isn't "appendable" then convert into an array first)
            if (!is_array($this->_headers[$name])) {
                $this->_headers[$name] = array($this->_headers[$name]);
            }
            $this->_headers[$name][] = $value;
        }
    }

    /**
     * Add/Replace the header
     *
     * @param string $name
     * @param string $value
     * @return HttpResponseHeader
     */
    public function set($name, $value)
    {
        $this->_headers[$name] = $value;
        return $this;
    }

    /**
     * Check if the header has been set or not
     *
     * @param string $name
     * @return boolean
     */
    public function exists($name)
    {
        return array_key_exists($name, $this->_headers);
    }

    /**
     * Remove the header from the reponse
     *
     * @param type $name
     * @return HttpResponseHeader
     */
    public function remove($name)
    {
        if($this->exists($name)) {
            unset($this->_headers[$name]);
        }
        return $this;
    }

    /**
     * Set the response code to deliver
     *
     * @param int $responseCode
     */
    public function setReponseCode($responseCode)
    {
        $this->_responseCode = $responseCode;
    }

    /**
     * Retrieve the response code currently set
     *
     * @return int
     */
    public function getReponseCode()
    {
        return $this->_responseCode;
    }

    /**
     * Deliver the http headers are currently set to the http service
     */
    public function deliver()
    {
        // response code
        header('HTTP/1.1 '.$this->_responseCode.' '.$this->_getResponseCodeDescription());
        // headers
        foreach($this->_headers as $name=>$value) {
            // handle multiple values for the same name
            if(is_array($value)) {
                foreach($value as $headerPart) {
                    header($name.': '.$headerPart, false);
                }
            } else {
                header($name.': '.$value);
            }
        }
    }

    private function _getResponseCodeDescription($responseCode = null)
    {
        if ($responseCode === null) {
            $responseCode = $this->getReponseCode();
        }
        if (array_key_exists($responseCode, $this->_codeDescriptions)) {
            return $this->_codeDescriptions[$responseCode];
        }

        return null;
    }
}