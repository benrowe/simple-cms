<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

Yii::setPathOfAlias('widgets', realpath(dirname(__FILE__).'/../components/widgets'));
Yii::setPathOfAlias('validators', realpath(dirname(__FILE__).'/../components/validators'));

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Ben Rowe',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.models.webitems.*',
		'application.models.forms.*',
		'application.components.*',
	),
	'aliases' => array(
		'xupload' => 'ext.xupload'
	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'admin',
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'bootstrap' => array(
			'class' => 'ext.bootstrap.components.Bootstrap',
			'responsiveCss' => true,
		),
		'clientScript'=>array(
          'packages'=>array(
            'jquery'=>array(
              'baseUrl'=>'http://ajax.googleapis.com/ajax/libs/jquery/',
              'js'=>array('1.7.2/jquery.min.js'),
            )
          ),
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('admin/default/login'),
		),
		// uncomment the following to enable URLs in path-format

		/*'urlManager'=>array(
			'urlFormat'=>'path',
			'urlSuffix' => '.html',
			'showScriptName'=>false,
			'rules'=>array(

				'<module:\w+>/<controller:\w+>/<action:\w+>' => array('<module>/<controller>/<action>'),
				//'sd'			=> array('<module>/<action>', 'pattern' => '<module:\w+>/<action:\w+>', 'defaultParams' => array('controller' => 'default')),
				//'moduleonly'	=> array('<module>', 'pattern' => '<module:\w+>'),

				/*'preview'		=> array('site/p', 'pattern' => 'p'),
				'tags' => array('site/tag', 'pattern' => 'tag/<tags:.+>'),
				'item' => array('site/item', 'pattern' => '<type:.+>/<slug:.+>'),
				'type' => array('site/type', 'pattern' => '<type:\w+>'),
				'home' => array('site/index', 'pattern' => ''),
				'pageslug' => array('site/item', 'type' => 'page', 'pattern' => '<slug:.+>'), // page slugs
				//'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				//'<controller:\w+>/<action:\w+>/<id:\d+>'=> array('<controller>/<action>'),
				'<controller:\w+>/<action:\w+>'=> array('<controller>/<action>'),
			),
		),*/

		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'cache' => array(
			'class' => 'system.caching.CFileCache',
			//'directoryLevel' => 2,
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'me@benrowe.info',
		'records-per-page' => 10,
		'tag-split' => "/,|-/",
		'site-url'	=> 'http://benrowe.info',
		'rss-description' => 'something about me',
	),
);