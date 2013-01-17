<?php

/**
 *
 * @property string $versions
 * @property object $sourceCode
 * @property string $category
 * @property array $demos
 * @property string $requirements
 */
class WebItemProject extends WebItemBase
{
	public function getVersions()
	{
		return $this->_getDataProperty('versions', array());
	}
	
	public function getSourceCode()
	{
		return $this->_getDataProperty('sourceCodeUrl', '');
	}
	
	public function getCategory()
	{
		return $this->_getDataProperty('category', 'n/a');
	}

	public function getDemos()
	{
		return $this->_getDataProperty('demos', array());
	}
	
	public function getRequirements()
	{
		return $this->_getDataProperty('requirements', array());
	}
	
	public function getMedia()
	{
		return $this->_getDataProperty('media', array());
	}
	
}