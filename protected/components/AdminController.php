<<<<<<< HEAD
<?php

/**
 * Abstract base controller for all "admin" controllers. These are controllers
 * that are used for an admin area (by default all actions require authentication!)
 *
 * This enables the authentication functionality to automatically block un-authenticated
 * attempts to access any action
 *
 * @package CMS_Controller
 * @author ben
 */
abstract class AdminController extends Controller
{
	public $layout = '/layouts/main';


	public function accessRules()
	{
		return array(
			array('allow',
				'users' => array('@'), // auth
			),
			array('deny',
				'users' => array('*'), // all
			)
		);
	}

	public function filters()
	{
		return array(
			'accessControl'
		);
	}
=======
<?php

/**
 * Abstract base controller for all "admin" controllers. These are controllers
 * that are used for an admin area (by default all actions require authentication!)
 *
 * This enables the authentication functionality to automatically block un-authenticated
 * attempts to access any action
 *
 * @package CMS_Controller
 * @author ben
 */
abstract class AdminController extends Controller
{
	public $layout = '/layouts/main';


	public function accessRules()
	{
		return array(
			array('allow',
				'users' => array('@'), // auth
			),
			array('deny',
				'users' => array('*'), // all
			)
		);
	}

	public function filters()
	{
		return array(
			'accessControl'
		);
	}
>>>>>>> fe2c02650a5026a07777acf110af6fc4bb87729b
}