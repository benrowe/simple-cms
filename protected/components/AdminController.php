<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminController
 *
 * @package CMS_Controller
 * @author ben
 */
class AdminController extends Controller
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
}