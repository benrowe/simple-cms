<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Ensure that the users provided email address is unique
 *
 * @author ben
 */
class UserUniqueEmail extends CValidator
{
	protected function validateAttribute($object, $attribute)
	{
		$value = $object->$attribute;
		// see if this value exists
		$users = User::model()->getAll();
		foreach ($users as $user) {
			if ($user->email === $value && $object->id != $user->id) {
				$this->addError($object, $attribute, 'This email address is already taken.');
			}
		}
		
		
				
	}
	
	/*public function clientValidateAttribute($object, $attribute)
	{
	}*/


}