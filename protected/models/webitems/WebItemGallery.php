<?php

/**
 *
 * 
 */
class WebItemGallery extends WebItemBase
{
	
	public function getImages()
	{
		return $this->_getDataProperty('images', array());
	}
}