<?php

/**
 *
 * @property object $company
 */
class WebItemPortfolio extends WebItemBase
{
	public function getCompany()
	{
		return $this->_getDataProperty('company', 'n/a');
	}
	
	public function getDate()
	{
		return $this->_getDataProperty('date', 'n/a');
		return $this->data['date'];
	}
	
	public function getUrls()
	{
		return $this->_getDataProperty('urls', array());
	}
}