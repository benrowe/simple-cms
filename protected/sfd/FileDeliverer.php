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
 * Description of FileDeliverer
 *
 * @package Static_File_Deliverer
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 *
 * @property HttpResponse $response
 * @property File $file
 * @property-read string $mimetype the mimetype of the file
 */
class FileDeliverer extends Component
{

    private $_mimeHandler;
    private $_compress = false;
    private $_ttl;

    private $_file;
    
    private $_response;

    //private $_content;

    private $_debug = false;

    const TTL_HOUR  = 3600;
    const TTL_DAY   = 86400;
    const TTL_MONTH = 2678400;

    /**
     * Constructor
     * 
     *
     * @param string $fileName The file to deliver
     * @param boolean $compress defaults true, allow the file to be additionally compressed (if possible)
     * @param int $ttl the amount of time the file should try to live in the client cache
     */
    public function __construct($fileName, $compress = true, $ttl = self::TTL_MONTH)
    {
        $this->file = $fileName;
        $this->_compress = $compress;
        $this->_ttl = $ttl;
    }

    public function setFile($file)
    {
        if (is_string($file)) {
            $file = new File($file);
        }
        $this->_file = $file;
    }
    
    public function getFile()
    {
        return $this->_file;
    }
    
    

    /**
     * Enable debug functionality.
     * This automatically disables caching and debug functionality
     */
    public function enableDebug()
    {
        $this->_debug = true;
    }

    /**
     * Disable all debug functionality
     */
    public function disableDebug()
    {
        $this->_debug = false;
    }

    /**
     * Get the mime type handler
     *
     * @return FileMimeTypes
     */
    public function getMimeTypeHandler()
    {
        if (!$this->_mimeHandler) {
            $this->_mimeHandler = new FileMimeTypes;
        }
        return $this->_mimeHandler;
    }

    /**
     * Set the mime type handler to use
     *
     * @param FileMimeTypes $fmt
     */
    public function setMimeTypeHandler(FileMimeTypes $fmt)
    {
        $this->_mimeHandler = $fmt;
    }

    /**
     * Get the http response object
     *
     * @return HttpResponse
     */
    public function getResponse()
    {
        if (!$this->_response) {

            $this->_response = new HttpResponse;
        }
        return $this->_response;
    }

    /**
     * Set the http response object to use
     *
     * @param HttpResponse $response
     */
    public function setReponse($response)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * Deliver the requested file to the http sevice
     */
    public function deliver()
    {
        // firstly check the request, if it's a cache check, tell it to bugger off!
        if (is_int($this->_ttl) && isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            $this->response->headers->setReponseCode(HttpResponseHeader::CODE_REDIRECT_NOT_MODIFIED);
        } else {

            // prepare the delivery
            $this->response->headers->setReponseCode(HttpResponseHeader::CODE_SUCCESS_OK);

            $this->response->body = $this->file->getContent();
        }

        // @todo rework this to ensure
        if ($this->_ttl && !$this->_debug) {
            $this->response->headers->add('last-modified', gmdate('D, d M Y H:i:s', $this->file->getMTime()).' GMT');
            $this->response->headers->add('cache-control', 'private');
            //$this->response->headers->add('pragma', 'public');
            //$this->response->headers->add('expires', '-1');
            $this->response->headers->add('expires', gmdate('D, d M Y H:i:s', time() + $this->_ttl).' GMT');
        }
        $this->response->headers->add('content-type', $this->getMimeType());
        if ($this->_compress) {
            ob_start("ob_gzhandler");
        }
        $this->response->deliver();

    }


    /**
     * Get the mime type for the current file
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->getMimeTypeHandler()->get($this->file->getExtension());
    }

}