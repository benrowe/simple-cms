<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebCollection
 *
 * @author ben
 */
class WebCollection extends CMap
{
	/**
	 * Get all the items where the property name matches the value
	 * 
	 * @param string $propertyName
	 * @param mixed $value
	 * @return WebItemCollection 
	 */
	public function getByProperty($propertyName, $value)
	{
		$items = $this->toArray();
		$cls = $this->_class();
		return new $cls($this->_filterProperty($items, $propertyName, $value));
	}
	
	

	/**
	 * Search through all the provided properties for any match of the search term
	 * 
	 * @param array $properties
	 * @param string $search 
	 * @return WebItemCollection
	 * @todo if $arrayProperty needs %like% matching added in (currently it uses in_array, which means an exact match!)
	 */
	public function searchProperties($properties, $search)
	{
		$items = $this->toArray();
		// loop through each of the properties and see if we have a match
		if (count($items) > 0) {
			$newItems = array();
			foreach ($items as $item) {
				$itemMatch = false;
				//var_dump($item);
				foreach($properties as $propertyName) {
					$stringProperty = is_string($item->$propertyName) && stristr($item->$propertyName, $search) !== false;
					$arrayProperty = is_array($item->$propertyName) && in_array($search, $item->$propertyName);
					if ($stringProperty || $arrayProperty) {
						$itemMatch = true;
					}
				}
				if ($itemMatch) {
					$newItems[] = $item;
				}
			}
			$items = $newItems;
		}
		$cls = $this->_class();
		return new $cls($items);
	}
	
	/**
	 * Slice a selection of the items
	 * 
	 * @param int $offset the offset position to start from
	 * @param int $length number of items to retrieve
	 * @return WebItemCollection
	 */
	public function slice($offset, $length = null)
	{
		$items = $this->toArray();
		$cls = $this->_class();
		return new $cls(array_slice($items, $offset, $length));
	}

	/**
	 * Get the latest items
	 * 
	 * @param int $limit
	 * @return WebItemCollection
	 * 
	 */
	public function getLatest($limit)
	{
		return $this->slice(0, $limit);
	}
	
	/**
	 * Filter the array of items where $property = $value
	 * 
	 * @param array $items
	 * @param string $property
	 * @param mixed $value 
	 * @return array
	 */
	protected function _filterProperty($items, $property, $value)
	{
		if (count($items) > 0) {
			$newItems = array();
			foreach ($items as $item) {
				$stringMatch = (is_string($value) && $item->$property === $value);
				$arrayMatch = (is_array($value) && in_array($item->$property, $value));
				$boolMatch = (is_bool($value) && $item->$property === $value);
				//var_dumP($stringMatch, $arrayMatch, $boolMatch);
				//echo '<br />';
				if ($stringMatch || $arrayMatch || $boolMatch) {
					$newItems[] = $item;
				}
			}
			$items = $newItems;
		}
		return $items;
	}

	/**
	 * sort the items by the selected property
	 * 
	 * @param array $items
	 * @param string $property
	 * @return array
	 */
	protected function _sortBy($items, $property)
	{
		if (count($items) > 0) {
			usort($items, function($a, $b) use ($property) {
						if ($a->$property == $b->$property) {
							return 0;
						}
						return $a->$property < $b->$property ? 1 : -1;
					});
		}
		return $items;
	}
	
	protected function _class()
	{
		return get_class($this);
	}
}