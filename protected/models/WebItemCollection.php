<?php

class WebItemCollection extends WebCollection implements ISearchable
{

	public function __construct($data = array(), $readOnly = false)
	{
		// always sort items by their publish date
		$data = $this->_sortBy($data, 'datePublished');
		parent::__construct($data, $readOnly);
	}

	/**
	 * get all the WebItems by a specific type
	 *
	 * @param string|array|WebTypeCollection $type item type
	 * @return WebItemCollection
	 */
	public function getByType($type)
	{
		if ($type instanceof WebTypeCollection) {
			$tmp = array();
			foreach($type as $t) {
				$tmp[] = $t->id;
			}
			$type = $tmp;
		} else if ($type instanceof WebType) {
			$type = $type->id;
		}
		$items = $this->toArray();
		$items = $this->_filterProperty($items, 'type', $type);
		return new self($items);
	}

	/**
	 * Get all webitems based on a customised callback. Each item is
	 * subject to the callback. Any callbacks that return true, they're included
	 * within the collection
	 * @param  ICallable $callback [description]
	 * @return WebItemCollection
	 */
	public function getByFilter($callback)
	{
		$items = $this->toArray();
		$items = array_filter($items, $callback);
		return new self($items);
	}

	public function getByTag($tag, $type = null)
	{
		return $this->getByTags($tag, $type);
	}

	public function featured()
	{
		$items = $this->toArray();
		$items = $this->_filterProperty($items, 'featured', true);
		return new self($items);
	}

	public function getByTags($tags, $type = null)
	{
		if (!is_array($tags)) {
			$tags = (array)$tags;
		}
		$tags = array_map('strtolower', $tags);
		$items = $this->toArray();
		if (count($items) > 0) {
			$newItems = array();
			foreach ($items as $item) {
				if (count(array_intersect($tags, $item->tags)) === count($tags)) {
					$newItems[] = $item;
				}
			}
			$items = $newItems;
		}
		return new self($items);
	}

	/**
	 * Merge another collection into this one
	 *
	 * @todo  implement this functionality
	 * @param  WebItemCollection $collection
	 * @param  boolean           $unique
	 * @return self
	 */
	public function merge(WebItemCollection $collection, $unique = true)
	{
		var_dump($collection);
		return $this;
	}

	/**
	 * Search the collection based on the search term(s)
	 *
	 * @param string|array $query
	 */
	public function search($query)
	{
		if (is_string($query)) {
			return $this->searchProperties(array(
				'id',
				'title',
				'description',
				'body'
			), $query);
		} else {

		}
	}



}