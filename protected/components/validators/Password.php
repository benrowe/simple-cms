<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Password
 *
 * @author ben
 */
class Password extends CValidator
{

	const STENGTH_STRONG = 'strong';
	const STRENGTH_WEAK = 'weak';
	
	public $strength = self::STENGTH_STRONG;
	public $minLength = 4;
	public $maxLength = 30;
	
	public $allowEmpty = false;

	private $_patternStrong = '/^(?=.*\d(?=.*\d))(?=.*[a-zA-Z](?=.*[a-zA-Z])).{4,}$/';
	private $_patternWeak = '/^(?=.*[a-zA-Z0-9]).{4,}$/';

	/**
	 * Validate the requested attribute
	 * 
	 * @param CModel $object
	 * @param string $attribute 
	 */
	protected function validateAttribute($object, $attribute)
	{
		$pattern = $this->_getPattern();

		$password = $object->$attribute;
		
		if ($this->allowEmpty && empty($password)) {
			return;
		}
		
		$length = strlen($password);
		
		if ($length < $this->minLength) {
			$this->addError($object, $attribute, 'Password too short');
		} else if ($length > $this->maxLength) {
			$this->addError($object, $attribute, 'Password too long');
		} else if (!preg_match($pattern, $password)) {
			$this->addError($object, $attribute, 'Password not strong enough');
		}
	}

	/**
	 * Get the requested pattern
	 * 
	 * @return string 
	 */
	private function _getPattern()
	{
		return $this->strength === self::STENGTH_STRONG ? $this->_patternStrong : $this->_patternWeak;
	}

}