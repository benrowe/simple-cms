<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pagination
 *
 * @author ben
 * @package CMS_Widget
 */
class Pagination extends CPagination
{
	/**
	 *
	 * @param WebItemCollection $items 
	 */
	public function applyLimitItems(WebItemCollection $items)
	{
		$this->currentPage;
		return $items->slice($this->currentPage*$this->pageSize, $this->pageSize);
	}

}