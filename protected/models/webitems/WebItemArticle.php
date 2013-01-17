<?php

/**
 *
 * @property array $pages
 */
class WebItemArticle extends WebItemBase
{
	public function getPages()
	{
		return $this->_getDataProperty('pages', array());
	}
}