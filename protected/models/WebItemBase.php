<?php

/**
 * Base class for web item
 *
 * @property string $id
 * @property string $title
 * @property string $type
 * @property boolean $featured
 * @property string $dateCreated
 * @property string $datePublished
 * @property string $description
 * @property boolean $published
 * @property string $body
 * @property string $image
 * @property array $tags
 * @property array $data
 * @property string $path
 * @property-read string $permaUrl
 */
abstract class WebItemBase extends CModel
{

	private $_path;

	private $_id;
	private $_title;
	private $_type;
	private $_featured = false;
	private $_dateCreated;
	private $_datePublished;
	private $_description;
	private $_published = false;
	private $_body;
	private $_image;
	private $_authorId;
	private $_tags = array();
	private $_data = array();

	function __construct() {
		$this->_data = new stdClass;
	}


	public function getPath()
	{
		return $this->_path;
	}

	public function setPath($path)
	{
		$this->_path = $path;
	}

	public function getAuthorId()
	{
		return $this->_authorId;
	}

	public function setAuthorId($authorId)
	{
		$this->_authorId = $authorId;
	}

	/**
	 * get the item id
	 * @return string
	 */
	public function getId()
	{
		return $this->_id;
	}

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getTitle()
	{
		return $this->_title;
	}

	public function setTitle($title)
	{
		$this->_title = $title;
	}

	public function getType()
	{
		return $this->_type;
	}

	public function setType($type)
	{
		$this->_type = $type;
	}

	public function getFeatured()
	{
		return $this->_featured;
	}

	public function setFeatured($featured)
	{
		$this->_featured = $featured;
	}

	public function getDateCreated($asDateTime = false)
	{
		if ($asDateTime) {
			return new DateTime($this->_dateCreated);
		}
		return $this->_dateCreated;
	}

	public function setDateCreated($dateCreated)
	{
		$this->_dateCreated = $dateCreated;
	}

	public function getDatePublished($asDateTime = false)
	{
		if ($asDateTime) {
			return new DateTime($this->_datePublished);
		}
		return $this->_datePublished;
	}

	public function setDatePublished($datePublished)
	{
		$this->_datePublished = $datePublished;
	}

	public function getDescription()
	{
		return $this->_description;
	}

	public function setDescription($description)
	{
		$this->_description = $description;
	}

	public function getBody()
	{
		return $this->_body;
	}

	public function setBody($body)
	{
		$this->_body = $body;
	}

	public function getImage()
	{
		return $this->_image;
	}

	public function setImage($image)
	{
		$this->_image = $image;
	}

	public function getTags()
	{
		return $this->_tags;
	}

	public function setTags($tags)
	{
		if (is_string($tags)) {
			$tags = array_map('trim', explode(',', $tags));
		}
		$this->_tags = $tags;
	}

	public function getData()
	{
		return (array)$this->_data;
	}

	public function setData($data)
	{

		if (empty($data)) {
			$data = array();
		} else if(is_string($data)) {
			$data = json_decode($data, true);
		} else if (!is_array($data)) {
			$data = (array)$data;
		}
		$this->_data = $data;
	}

	public function getPublished()
	{
		return $this->_published;
	}

	public function setPublished($published)
	{
		$this->_published = $published;
	}

	/**
	 * Get the absolute url to this item
	 * @return type
	 */
	public function getPermaUrl()
	{
		return Yii::app()->createAbsoluteUrl('site/item', array('type' => $this->type, 'slug' => $this->id));
	}

	public function attributeNames()
	{
		return array(
			'path',
			'id',
			'title',
			'type',
			'featured',
			'authorId',
			'dateCreated',
			'datePublished',
			'description',
			'published',
			'body',
			'image',
			'tags',
			'data'
		);
	}

	public static function fromJson($path)
	{
		$jsonContentRaw = file_get_contents($path);
		$jsonDecoded = json_decode($jsonContentRaw, true);
		if ($jsonDecoded === null) {
			throw new CException('Error decoding data from '.$path);
		}
		return self::toSelf($jsonDecoded, $path);
	}

	/**
	 * Convert an standard object into a web item, based on it's type
	 *
	 * @param stdClass $data
	 * @param string $path
	 * @return WebItemBase
	 */
	public static function toSelf($data, $path)
	{
		if (!is_array($data)) {
			$data = (array) $data;
		}
		$class = 'WebItem' . ucfirst($data['type']);
		$item = new $class;
		$item->path = $path;
		foreach ($data as $k => $v) {
			$item->$k = $v;
		}
		return $item;

	}



	/**
	 * Save the model
	 */
	public function save()
	{
		if (empty($this->_path)) {
			$path = WebManager::ITEM_LOCATION.$this->_type.DIRECTORY_SEPARATOR.$this->_id.'.json';
			if (file_exists($path)) {
				throw new CException('save path is already taken');
			}
			$this->_path = $path;
		}

		// convert object to json & save :)
		$itemAttributes = $this->getAttributes();

		unset($itemAttributes['path']);
		if (empty($itemAttributes['dateCreated'])) {
			$itemAttributes['dateCreated'] = date('Y/m/d');
		}
		if ($itemAttributes['published'] === true && empty($itemAttributes['datePublished'])) {
			$itemAttributes['datePublished'] = date('Y/m/d');
		}

		$dirName = dirname($this->_path);
		if (!file_exists($dirName)) {
			mkdir($dirName, 0755, true);
		}
		$encode = CJSON::encode($itemAttributes);


		if (file_put_contents($this->_path, $encode) !== false) {
			$this->onSave(new CEvent($this));
			return true;
		}
		throw new CException('unable to save item');
		return false;

	}

	public function delete()
	{
		if (empty($this->_path) || !file_exists($this->_path)) {
			return true;
		}
		if (unlink($this->_path)) {
			$this->onDelete(new CEvent($this));
			return true;
		}
		throw new CException('unable to delete item');
		return false;
	}

	public function onSave($event)
	{
		$this->raiseEvent('onSave', $event);
	}

	public function onDelete($event)
	{
		$this->raiseEvent('onDelete', $event);
	}

	/**
	 * Get the data property, if available
	 * @param string $key the key to retrieve
	 * @param mixed $default the value if the key doesn't exist
	 * @return mixed
	 */
	protected function _getDataProperty($key, $default = null)
	{
		return is_array($this->data) && isset($this->data[$key]) ? $this->data[$key] : $default;
	}

}