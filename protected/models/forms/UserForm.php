<?php

/**
 * @package CMS_Model_Form
 * 
 * @property string $email 
 * @property string $firstname 
 * @property string $lastname 
 * @property string $display 
 * @property string $password 
 * @property string $passwordConfirm 
 */
class UserForm extends CFormModel
{

	private $_email;
	private $_firstname;
	private $_lastname;
	private $_display;
	private $_password;
	private $_passwordConfirm;
	private $_bio;

	public function __construct($scenario = '')
	{
		parent::__construct($scenario);
		if ($scenario === 'profile') {
			// load the initial data from the user
			
			$this->setAttributes($this->_getModel()->getAttributes());
			$this->_password = null;
		}
	}
	
	public function attributeNames()
	{
		return array(
			'email',
			'password',
			'firstname',
			'lastname',
			'display',
			'bio'
		);
	}
	
	public function rules()
	{
		return array(
			array('email, firstname, lastname, display, bio', 'required', 'on' => 'profile'),
			array('password, passwordConfirm', 'safe', 'on' => 'profile'),
			array('password', 'application.components.validators.Password', 'on' => 'profile', 'allowEmpty' => true),
			array('passwordConfirm', 'compare', 'compareAttribute' => 'password', 'on' => 'profile')
		);
	}
	
	/**
	 * @return User
	 */
	private function _getModel()
	{
		return User::model()->getById(Yii::app()->user->id);
	}
	
	public function save()
	{
		$user = $this->_getModel();
		$user->setAttributes($this->getAttributes(array('email', 'firstname', 'lastname', 'display', 'bio')), false);
		if (!empty($this->password)) {
			$user->password = $this->password;
		}
		$user->onSave = function() {
			Yii::app()->cache->delete('users-all');
		};
		return $user->save();
	}

	public function getPassword()
	{
		return $this->_password;
	}

	public function setPassword($password)
	{
		$this->_password = $password;
	}

	public function getPasswordConfirm()
	{
		return $this->_passwordConfirm;
	}

	public function setPasswordConfirm($passwordConfirm)
	{
		$this->_passwordConfirm = $passwordConfirm;
	}

	public function getDisplay()
	{
		return $this->_display;
	}

	public function setDisplay($display)
	{
		$this->_display = $display;
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function setEmail($email)
	{
		$this->_email = $email;
	}

	public function getFirstname()
	{
		return $this->_firstname;
	}

	public function setFirstname($firstname)
	{
		$this->_firstname = $firstname;
	}

	public function getLastname()
	{
		return $this->_lastname;
	}

	public function setLastname($lastname)
	{
		$this->_lastname = $lastname;
	}

	public function getBio()
	{
		return $this->_bio;
	}

	public function setBio($bio)
	{
		$this->_bio = $bio;
	}

}