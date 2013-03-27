<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestCache
 *
 * @author ben
 */
class TestCache extends CFileCache
{

	protected function addValue($key, $value, $expire)
	{
		return parent::addValue($key, $value, 1);
	}

	public function add($id, $value, $expire = 0, $dependency = null)
	{
		return parent::add($id, $value, 1, $dependency);
	}

	public function set($id, $value, $expire = 0, $dependency = null)
	{
		return parent::set($id, $value, 1, $dependency);
	}

}