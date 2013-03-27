<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Settings
 *
 * @author ben
 */
class Settings
{
	/**
	 * The raw data for this level within the settings
	 * @var array
	 */
	private $_d = array();
	
	/**
	 * The schema representing the potential setting values
	 * @var array
	 */
	private $_s = array();
	
	/**
	 * Only allow values that match up against the schema, otherwise new values
	 * can be added to the stack
	 * 
	 * @var boolean
	 */
	private $_enforceSchema = true;
	
	public function get()
	{
		
	}
	
	/**
	 *  
	 */
	public function set($key, $value)
	{
		
	}
	
	/**
	 * Determine if the key exists within the settings stack
	 * 
	 * @param string $key
	 * @return boolean
	 */
	public function contains($key)
	{
		return isset($this->_d[$key]) || array_key_exists($key, $this->_d);
	}
	
	/**
	 * Get the setting node based on the supplied namespace
	 * @return Settings 
	 */
	public function getNamespace()
	{
		
	}
	
	/**
	 * Alias of {@see getNamespace} 
	 */
	public function ns()
	{
		
	}
}
