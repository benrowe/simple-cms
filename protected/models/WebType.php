<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebType
 *
 * @author ben
 * @property string $id
 * @property array $titles
 * @property array $options
 * @property array $schema
 * @property string $path
 * @property-read string $permaUrl
 */
class WebType extends CModel
{

	private $_path;
	
	private $_id;
	private $_titles;
	private $_options;
	private $_schema;
	private $_schema_string;

	//put your code here
	public function attributeNames()
	{
		return array(
			'path',
			'id',
			'titles',
			'options',
			'schema',
		);
	}

	public function getSchema_string()
	{
		return $this->_schema_string;
	}

	public function setSchema_string($schema_string)
	{
		$this->_schema_string = $schema_string;
	}

	public function getPath()
	{
		return $this->_path;
	}

	public function setPath($path)
	{
		$this->_path = $path;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getTitles()
	{
		return $this->_titles;
	}

	public function setTitles($titles)
	{
		$this->_titles = $titles;
	}

	public function getOptions()
	{
		return $this->_options;
	}

	public function setOptions($options)
	{
		$this->_options = $options;
	}

	public function getSchema()
	{
		return $this->_schema;
	}

	public function setSchema($schema)
	{
		$this->_schema = $schema;
	}
	
	public function getTitlePlural()
	{
		return $this->_titles->plural;
	}

	public function getTitleSingle()
	{
		return $this->_titles->single;
	}
	
	/**
	 * Get the absolute url to this type
	 * 
	 * @return type 
	 */
	public function getPermaUrl()
	{
		return Yii::app()->createAbsoluteUrl('site/type', array('type' => $this->slug));
	}
	
	/**
	 *
	 * @param string $path
	 * @return WebType
	 * @throws CException 
	 */
	public static function fromJson($path)
	{
		$jsonContentRaw = file_get_contents($path);
		$jsonDecoded = json_decode($jsonContentRaw);
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
	 * @return WebType
	 */
	public static function toSelf($data, $path)
	{
		if (!is_array($data)) {
			$data = (array) $data;
		}
		$type = new self;
		$type->path = $path;
		foreach ($data as $k => $v) {
			$type->$k = $v;
		}
		return $type;

	}

}