<?php

/**
 * @package CMS_Model
 */
class WebItem extends CModel
{
	const DATE_FORMAT = 'Y/m/d';
	
	public function attributeNames()
	{
		return array();
	}
	
	public static function fromJson($path)
	{
		$jsonContentRaw = file_get_contents($path);
		$jsonDecoded = json_decode($jsonContentRaw);
		if ($jsonDecoded === null) {
			throw new Exception('unable to convert '. $path.'');
		}
		return self::toSelf($jsonDecoded);
	}
	
	public static function toSelf($data)
	{
		if (!is_array($data)) {
			$data = (array)$data;
		}
		return unserialize(sprintf(
			'O:%d:"%s"%s',
			strlen(__CLASS__),
			__CLASS__,
			strstr(serialize($data), ':')
		));
	}
}