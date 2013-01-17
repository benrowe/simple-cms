<?php

class MediaFileImage extends MediaFile
{
	private $_meta;

	public function attributeNames()
	{
		return array_merge(parent::attributeNames(), array(
			'width',
			'height'
		));
	}

	public function getWidth()
	{
		$meta = $this->_getMeta();
		return $meta['width'];
	}

	public function getHeight()
	{
		$meta = $this->_getMeta();
		return $meta['height'];
	}

	/**
	 * Get meta details about the image
	 *
	 * @return array
	 */
	private function _getMeta()
	{
		if(!$this->_meta) {
			$details = getimagesize($this->getFullPath());
			$meta = array(
				'width'  => $details[0],
				'height' => $details[1]
			);
			$this->_meta = $meta;
		}
		return $this->_meta;
	}
}