<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of User
 *
 * @package CMS_Model
 * @author Ben Rowe <ben.rowe.83@gmail.com>
 * 
 * @property string $id
 * @property string $email
 * @property string $display
 * @property string $firstname
 * @property string $lastname
 * @property string $bio
 * 
 * 
 * @property string $path
 */
class User extends CFormModel
{

	private $_path;
	/**
	 * The identification for the user
	 * 
	 * @var string
	 */
	private $_id;
	
	/**
	 * The email address
	 * 
	 * @var email
	 */
	private $_email;
	
	/**
	 *
	 * @var type 
	 */
	private $_password;
	private $_salt;
	private $_firstname;
	private $_lastname;
	private $_display;
	private $_bio = 'fix me!';
	//private $_author;

	private $_users = array();
	
	const USER_LOCATION = 'protected/data/users/';
	const ITEM_EXTENSION = 'json';
	
	/**
	 * List of attributes for this model
	 * 
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'path',
			'id',
			'email',
			'password',
			'salt',
			//'author',
			'firstname',
			'lastname',
			'display',
			'bio',
		);
	}
	
	public function rules()
	{
		return array(
			array('email, firstname, lastname, display, bio', 'required'),
			array('email', 'email'),
			array('email', 'application.components.validators.UserUniqueEmail'),
			array('password', 'required', 'on' => 'create')
		);
	}
	
	public static function dropdown()
	{
		$m = self::model();
		return CHtml::listData($m->getAll(), 'id', 'display');
	}
	
	/*public function getAuthor()
	{
		return $this->_author;
	}

	public function setAuthor($author)
	{
		$this->_author = $author;
	}*/


	
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

	public function getEmail()
	{
		return $this->_email;
	}

	public function setEmail($email)
	{
		$this->_email = $email;
	}

	public function getPassword()
	{
		return $this->_password;
	}

	public function setPassword($password)
	{
		$this->_password = $password;
	}

	public function getSalt()
	{
		return $this->_salt;
	}

	public function setSalt($salt)
	{
		$this->_salt = $salt;
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

	public function getDisplay()
	{
		return $this->_display;
	}

	public function setDisplay($display)
	{
		$this->_display = $display;
	}
	
	public function getBio()
	{
		return $this->_bio;
	}

	public function setBio($bio)
	{
		$this->_bio = $bio;
	}

	/**
	 * Generate a random salt
	 * 
	 * @return string
	 */
	protected function _generateSalt()
	{
		return uniqid('',true);
	}
	
	/**
	 * Validate an externally supplied password against the currently set password
	 * 
	 * @param string $password
	 * @return boolean
	 */
	public function validatePassword($password)
	{
		return $this->hashPassword($password, $this->salt) === $this->password;
	}
	
	/**
	 * Hash a password using a supplied salt value
	 * 
	 * @param string $password
	 * @param string $salt
	 * @return string 
	 */
	public function hashPassword($password, $salt)
	{
		return md5($salt.$password.$salt);
	}
	
	/**
	 * Retrieve an initialised instance of this model
	 * 
	 * @param string $className
	 * @return User
	 */
	public static function model($className=__CLASS__)
	{
		return new $className;
	}
	
	/**
	 * Get the user by their primary key
	 * 
	 * @param string $id
	 * @return User
	 */
	public function getById($id)
	{
		$users = $this->_getAll()->getByProperty('id', $id);
		return $users->count() == 1 ? $users[0] : false;
	}
	
	/**
	 * Get all the users available
	 * 
	 * @return UserCollection
	 */
	private function _getAll()
	{
		$cacheName = 'users-all';
		if (empty($this->_users)) {
			//Yii::app()->cache->delete($cacheName);
			$users = Yii::app()->cache->get($cacheName);
			if ($users === false) {
				$users = Dir::findAllFiles(self::USER_LOCATION, "/\." . self::ITEM_EXTENSION . "/");
				$users = array_map('User::fromJson', $users);
				$users = $this->_toUserCollection($users);
				
				Yii::app()->cache->set($cacheName, $users);
				
			}
			$this->_users = $users;
		}
		return $this->_users;
	}
	
	/**
	 * Get all the users
	 * 
	 * @return UserCollection
	 */
	public function getAll()
	{
		return $this->_getAll();
	}
	
	public function beforeSave()
	{
		// make sure the password is hashed
		if (strlen($this->_id) === 0) {
			$this->_id = URLHelper::slugify($this->_display);
		}
		
		// encrypt password
		if (strlen($this->password) !== 32) {
			$salt = $this->_generateSalt();
			$this->salt = $salt;
			$this->password = $this->hashPassword($this->password, $salt);
		}
		
		return true;
	}
	
	/**
	 * Save the user model
	 * 
	 * @return boolean
	 * @throws CException 
	 */
	public function save()
	{
		if ($this->beforeSave() === false) {
			return;
		}
		
		if (empty($this->_path)) {
			$path = self::USER_LOCATION.$this->_id.'.'.self::ITEM_EXTENSION;
			if (file_exists($path)) {
				throw new CException('save path is already taken');
			}
			$this->_path = $path;
		}
		// convert object to json & save :)
		$itemAttributes = $this->getAttributes();
		
		unset($itemAttributes['path']);
		
		$dirName = dirname($this->_path);
		if (!file_exists($dirName)) {
			mkdir($dirName, 0755, true);
		}
		$encode = CJSON::encode($itemAttributes);
		if (file_put_contents($this->_path, $encode) !== false) {
			$this->onSave(new CEvent($this));
			return true;
		} 
		throw new CException('unable to save user');
		return false;
	}
	
	/**
	 * Raise the onSave event
	 * 
	 * @param CEvent $event 
	 */
	public function onSave($event)
	{
		$this->raiseEvent('onSave', $event);
	}
	
	/**
	 * Delete the model 
	 * 
	 * @return boolean
	 */
	public function delete()
	{
		if (empty($this->_path) || !file_exists($this->_path)) {
			// model was never saved
			return true;
		}
		if (unlink($this->_path)) {
			$this->onDelete(new CEvent($this));
			return true;
		}
		throw new CException('unable to delete user');
		return false;
	}
	
	/**
	 * Raise the onDelete event
	 * 
	 * @param CEvent $event 
	 */
	public function onDelete($event)
	{
		$this->raiseEvent('onDelete', $event);
	}
	
	/**
	 * Convert an array of items into a UserCollection
	 * 
	 * @param array $users
	 * @return UserCollection 
	 */
	private function _toUserCollection(array $users)
	{
		return new UserCollection($users);
	}
	
	/**
	 * Generate a user from the json file
	 * 
	 * @param string $path
	 * @return User
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
	 * @return User
	 */
	public static function toSelf($data, $path)
	{
		if (!is_array($data)) {
			$data = (array) $data;
		}
		$user = new User;
		$user->path = $path;
		foreach ($data as $k => $v) {
			$user->$k = $v;
		}
		return $user;

	}

}