<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebSearch
 *
 * @author ben
 */
class WebSearch extends CComponent
{

	private $_sources = array();

	function __construct(array $config = array())
	{
		if (isset($config['sources'])) {
			$this->setSources($config['sources']);
		}
	}

	public function getSources()
	{
		return $this->_sources;
	}

	public function setSources($sources)
	{
		foreach ($sources as $source) {
			if (!($source instanceof ISearchable)) {
				throw new CException('unknown source type of '.get_class($source));
			}
		}
		$this->_sources = $sources;
	}

	public function search($query)
	{
		$results = array();
		/* @var $source ISearchable */
		foreach ($this->_sources as $source) {
			$results = array_merge($results, $source->search($query)->toArray());
		}
		return new WebCollection($results);
	}

}