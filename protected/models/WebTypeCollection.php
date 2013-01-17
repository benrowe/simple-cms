<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebTypeCollection
 *
 * @author ben
 */
class WebTypeCollection extends WebCollection
{
	public function __construct($data = array(), $readOnly = false)
	{
		// always sort items by their publish date
		$data = $this->_sortBy($data, 'id');
		parent::__construct($data, $readOnly);
	}
	
	/**
	 * Get an array of types by the provided list of ids
	 * 
	 * @param array $ids 
	 * @return WebTypeCollection
	 */
	public function getByIds(array $ids)
	{
		$types = $this->toArray();
		$cls = $this->_class();
		return new $cls($this->_filterProperty($types, 'id', $ids));
	}
	
	/**
	 * Get the type by its id
	 * 
	 * @param string $id
	 * @return WebTypeCollection
	 */
	public function getById($id)
	{
		$types = $this->toArray();
		$cls = $this->_class();
		return new $cls($this->_filterProperty($types, 'id', $id));
	}
}