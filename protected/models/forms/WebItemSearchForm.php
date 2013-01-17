<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebItemSearchForm
 *
 * @package CMS_Model_Form
 * @author ben
 */
class WebItemSearchForm extends CFormModel
{
	public $type;
	public $query;
	public $publishStatus = 'true';
	
	public function __construct($scenario = ''){
		if ($scenario === 'admin') {
			$this->publishStatus = null;
		}
		parent::__construct($scenario);
	}
	public function rules()
	{
		return array(
			array('type, query', 'safe'),
			array('publishStatus', 'safe', 'on' => 'admin'),
		);
	}

	/**
	 * Runs the search logic over the provided collection
	 * 
	 * @param WebItemCollection $items 
	 * @return WebItemCollection
	 */
	public function search(WebItemCollection $items) 
	{
		//$items->getby
		
		if (!empty($this->type)) {
			$items = $items->getByType($this->type);
		}
		
		if (!empty($this->publishStatus)) {
			$items = $items->getByProperty('published', $this->publishStatus === 'true');
		}
		if (!empty($this->query)) {
			$items = $items->searchProperties(array('title', 'description', 'body', 'tags'), $this->query);
		}
		return $items;
		
	}
	
}