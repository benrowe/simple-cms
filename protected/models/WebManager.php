<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class WebManager extends CModel
{

	const ITEM_LOCATION = 'protected/data/items/';
	const TYPE_LOCATION = 'protected/data/types/';
	const CACHE_ITEMS_ALL_PUBLISHED = 'items-all-published';
	const CACHE_ITEMS_ALL = 'items-all';
	const CACHE_ITEMS_LATEST = 'items-latest';
	const CACHE_TYPES_ALL = 'types-all';
	const ITEM_EXTENSION = 'json';

	private $_items = array();
	private $_types;

	/*public function __construct()
	{
		$this->_items = new WebItemCollection;
	}*/

	public function attributeNames()
	{
		return array();
	}

	/**
	 * retrieve a list of items that have ALL the specified tags
	 *
	 * @param string|array $tags
	 * @return array
	 */
	public function getItemsByTags($tags)
	{
		return $this->getAll()->getByTags($tags);
	}

	/**
	 * Empty the cache
	 * @todo relocate the users-all cache
	 */
	public static function emptyCache()
	{
		Yii::app()->cache->flush();
		/*Yii::app()->cache->delete(self::CACHE_ITEMS_ALL);
		Yii::app()->cache->delete(self::CACHE_ITEMS_ALL_PUBLISHED);
		Yii::app()->cache->delete(self::CACHE_ITEMS_LATEST);
		Yii::app()->cache->delete(self::CACHE_TYPES_ALL);
		Yii::app()->cache->delete('users-all');*/
	}

	/**
	 * Get a collection of the available types of assets
	 *
	 * @return WebTypeCollection
	 */
	public static function types()
	{
		$wim = new self;
		return $wim->getTypes(false);
	}

	/**
	 * Get a alphabetical list of item types
	 *
	 * @param boolean $published
	 * @return array
	 */
	public function getTypes($published = true)
	{
		return $this->_getAllTypes();
	}

	/**
	 * Get a collection of types by the array of supplied type ids
	 *
	 * @param array $ids
	 * @return WebTypeCollection
	 */
	public function getTypesByIds(array $ids)
	{
		if (!is_array($ids)) {
			$ids = (array)$ids;
		}
		return $this->_getAllTypes()->getByIds($ids);
	}

	/*public static function getLatest($limit = 20)
	{

		$wim = new self;
		return $wim->getLatestItems($limit);
	}*/

	public function getItemByTypes($types)
	{
		if (!is_array($types) && !($types instanceof WebTypeCollection)) {
			$types = (array)$types;
		}
		$wim = new self;
		$items = $wim->getAll();
		return $items->getByType($types);
	}

	public function getItemsByMediaFile($mediaFile)
	{
		$items = $this->_getAllItems(null);
		return $items->getByFilter(function($item) use($mediaFile) {
			$data = $item->data;
			if(isset($data['media'])) {
				foreach($data['media'] as $media) {
					if($media['file'] === $mediaFile) {
						return true;
					}
				}
			}
			return false;
		});
	}

	public function getLatestItems($limit = 20)
	{
		$items = $this->_getAllItems();
		return $items->getLatest($limit);
	}

	public function getFeaturedItems()
	{
		$items = $this->_getAllItems();
		return $items->featured();
	}

	/**
	 * Get all web items
	 *
	 * @param boolean $published
	 * @return WebItemCollection
	 */
	public function getAll($published = true)
	{
		return $this->_getAllItems($published);
	}

	/*public static function getItem($id, $type)
	{
		$wim = new self;
		return $wim->getSingleItem($id, $type);
	}*/

	/**
	 * Retrieve a single web item based on its id & type.
	 *
	 * @param string $id
	 * @param string $type
	 * @return WebItemBase|boolean false if no result
	 */
	public function getSingleItem($id, $type)
	{
		foreach ($this->_getAllItems(false) as $item) {
			if ($item->id === $id && $item->type === $type) {
				return $item;
			}
		}
		return false;
	}

	/**
	 * Retrieve a single web type based on its id
	 *
	 * @param sting $id
	 * @return WebItem|boolean false if no result
	 */
	public function getSingleType($id)
	{
		return $this->_getAllTypes()->getById($id);
	}

	/**
	 * Get all web items currently available
	 *
	 * @param boolean $published
	 * @return WebItemCollection
	 */
	private function _getAllItems($published = true)
	{
		$cacheName = $published ? self::CACHE_ITEMS_ALL_PUBLISHED : self::CACHE_ITEMS_ALL;

		if (!isset($this->_items[$cacheName])) {
			$items = Yii::app()->cache->get($cacheName);
			if ($items === false) {
				// grab all data items, convert into WebItem and return the Collection
				$items = Dir::findAllFiles(self::ITEM_LOCATION, "/\." . self::ITEM_EXTENSION . "/");
				$items = array_map('WebItemBase::fromJson', $items);
				$items = $this->_toItemCollection($items);

				// filter out the un-published items
				if ($published) {
					foreach ($items as $i=>$item) {
						if ($item->published === false) {
							unset($items[$i]);
						}
					}
				}
				Yii::app()->cache->set($cacheName, $items);
			}
			$this->_items[$cacheName] = $items;
		}
		return $this->_items[$cacheName];
	}

	/**
	 * Get all types currently available
	 *
	 * @return WebTypeCollection
	 */
	private function _getAllTypes()
	{

		$cacheName = self::CACHE_TYPES_ALL;
		if ($this->_types === null) {
			$types = Yii::app()->cache->get($cacheName);
			if ($types === false) {
				$types = Dir::findAllFiles(self::TYPE_LOCATION, "/\." . self::ITEM_EXTENSION . "/", false);
				$types = array_map('WebType::fromJson', $types);
				$types = $this->_toTypeCollection($types);
				Yii::app()->cache->set($cacheName, $types);
			}
			$this->_types = $types;
		}
		return $this->_types;

	}

	/**
	 * Convert an array of items into a WebItemCollection
	 *
	 * @param array $items
	 * @return WebItemCollection
	 */
	private function _toItemCollection(array $items)
	{
		return new WebItemCollection($items);
	}

	/**
	 * Convert an array of items into a WebTypeCollection
	 *
	 * @param array $types
	 * @return WebTypeCollection
	 */
	private function _toTypeCollection(array $types)
	{
		return new WebTypeCollection($types);
	}


}
