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
 * Description of Image
 *
 * @package 
 * @copyright © Arinex 2011
 * @license http://arinex.com.au/licence
 * @author Ben Rowe <browe@arinex.com.au>
 *
 * @property resource $resource
 */
class Image extends Component
{

    private $_origResource;

    const TMP_DIR = 'tmp/';

    /**
     * Create a new
     *
     * @param string $content
     * @return Image
     */
    public static function fromString($content)
    {
        $img = new self;
        $img->resource = imagecreatefromstring($content);
        return $img;
    }

    public static function fromFile($file)
    {
        if (is_string($file)) {
            $file = new File($file);
        }
        $ext = $file->getExtension();

        $img = new self;
        switch($ext) {
            case 'jpg':
                $img->resource = imagecreatefromjpeg($file->getPathname());
                break;
            case 'png':
                $img->resource = imagecreatefrompng($file->getPathname());
                break;
            case 'gif':
                $img->resource = imagecreatefromgif($file->getPathname());
                break;
            default:
                throw new Exception('unknown image type');
                break;
        }
        
        return $img;
    }

    public function getResource()
    {
        return $this->_origResource;
    }

    public function setResource($resource)
    {
        $this->_origResource = $resource;
    }

    public function canvas($width, $height, $bgcolor = '000')
    {
        $new = imagecreatetruecolor($width, $height);

        // fill bg
        $rgb = $this->_hex2rgb($bgcolor);
        $bg = imagecolorallocate($new, $rgb['red'], $rgb['green'], $rgb['blue']);
        imagefilledrectangle($new, 0, 0, $width, $height, $bg);

        list($newWidth, $newHeight) = array_values($this->resizeDimentions($width, $height));

        list($origWidth, $origHeight) = array_values($this->details);

        
        

        $x = round(($width-$newWidth)/2);
        $y = round(($height-$newHeight)/2);
        
//exit;
//function imagecopyresampled ($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) {}

        imagecopyresampled($new, $this->resource, $x, $y, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        $this->resource = $new;
    }

    public function resize($width, $height, $keepAspect = true)
    {
        // calculate the new size of the canvas
        list($width, $height) = array_values($this->resizeDimentions($width, $height, $keepAspect));

        list($origWidth, $origHeight) = array_values($this->details);

        $new = imagecreatetruecolor($width, $height);
        imagecopyresampled($new, $this->resource, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);
        $this->resource = $new;
    }

    public function cropfrom($width, $height, $where = 'top-left')
    {

        list($origWidth, $origHeight) = array_values($this->details);

        $x = 0;
        $y = 0;

        switch (strtolower($where)) {

            case 'bottom':
                $x = ($origWidth - $width) / 2;
                $y = $origHeight - $height;
                break;
            case 'top':
                $x = ($origWidth - $width) / 2;
                break;
            case 'left':
                $y = ($origHeight - $height) / 2;
                break;
            case 'right':
                $x = $origWidth - $width;
                $y = ($origHeight - $height) / 2;

                break;
            case 'top-left':
                // use defaults
                break;
            case 'top-right';
                $x = $origWidth - $width;
                break;
            case 'bottom-left':
                $y = $origHeight - $height;
                break;
            case 'bottom-right':
                $x = $origWidth - $width;
                $y = $origHeight - $height;
                break;
            default:
                return;
                break;
        }
        $this->crop($width, $height, $x, $y);
    }

    /**
     *
     * @param type $width
     * @param type $height
     * @param type $x
     * @param type $y
     */
    public function crop($width, $height, $x = 0, $y = 0)
    {
        $new = imagecreatetruecolor($width, $height);
        imagecopyresampled($new, $this->resource, 0, 0, $x, $y, $width, $height, $width, $height);
        $this->resource = $new;
    }

    /**
     * generate new dimentions of the image based on the provided rules
     *
     * @param int $width
     * @param int $height
     * @param true $keepAspect
     */
    public function resizeDimentions($width = null, $height = null, $keepAspect = true)
    {
        if (!$keepAspect) {
            // we're ignoring the aspect ratio, so the image is going to look skewed
            return array(
                'width' => $width,
                'height' => $height
            );
        }

        list($origWidth, $origHeight) = array_values($this->details);

        // calculate the resize ratio, based on the desired width/height
        if ($width === NULL) {
            $ratio = $height / $origHeight;
        } else if ($height === NULL) {
            $ratio = $width / $origWidth;
        } else {
            $ratio = min($width / $origWidth, $height / $origHeight);
        }

        return array(
            'width' => $origWidth * $ratio,
            'height' => $origHeight * $ratio
        );
    }

    public function getDetails()
    {
        return array(
            'width' => imagesx($this->resource),
            'height' => imagesy($this->resource)
        );
    }

    /**
     * saves the image to the file system
     *
     * @param string $path
     * @param string $type
     */
    public function saveTo($path, $type = 'jpg')
    {
        switch ($type) {
            case 'jpg':

                imagejpeg($this->resource, $path, 100);
                break;
        }
    }

    private function _hex2rgb($hex)
    {
        // play with the format
        if ($hex[0] === '#') {
            $hex = substr($hex, 1);
        }

        // detect shortform "F00"
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        return array(
            'red'   => base_convert(substr($hex, 0, 2), 16, 10),
            'green' => base_convert(substr($hex, 2, 2), 16, 10),
            'blue'  => base_convert(substr($hex, 4, 2), 16, 10)
        );
    }

}