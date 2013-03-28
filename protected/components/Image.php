<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Image
 *
 * @author ben
 */
class Image extends CWidget
{
	private $_image;
	public $class = '';
	private $_href;



	public function run()
	{
		$this->render('image', array(
			'image' => $this->image,
			'class' => $this->class,
			'href'	=> $this->href
		));
	}

	public function getImage()
	{
		return $this->_image;
	}

	public function setImage($image)
	{
		$this->_image = $image;
	}

	public function getHref()
	{
		if (!$this->_href) {
			$this->_href = $this->image['file'];
		}
		return $this->_href;
	}

	public function setHref($href)
	{
		$this->_href = $href;
	}

}