<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tag
 *
 * @author ben
 */
class Tag extends CRegularExpressionValidator
{

	public $pattern = "/^[\w\d\r\-]+(,?\s?[\w\d\r\-]+)*$/";
	public $limit;

	protected function validateAttribute($object, $attribute)
	{
		parent::validateAttribute($object, $attribute);
		$value = $object->$attribute;
		if (is_numeric($this->limit)) {
			$tags = explode(',', $value);
			if (count($tags) > $this->limit) {
				$this->addError($object, $attribute, Yii::t('validation', 'Tags have exceeded limit of '.$this->limit));
			}
		}
	}

}