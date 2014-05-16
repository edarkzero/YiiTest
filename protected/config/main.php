<?php

	// uncomment the following to define a path alias
	// Yii::setPathOfAlias('local','path/to/local-folder');

	// This is the main Web application configuration. Any writable
	// CWebApplication properties can be configured here.
	return array(
		'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
		'name'       => 'Edarkzero Playground',

		// preloading 'log' component
		'preload'    => array('log'),

		// autoloading model and component classes
		'import'     => array(
			'application.models.*',
			'application.components.*',
			'application.include.*',
			'application.include.helpers.*',
		),

		'modules'    => array(
			'gii' => array(
				'class'     => 'system.gii.GiiModule',
				'password'  => '123456',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters' => array('127.0.0.1', '::1'),
			),
		),

		// application components
		'components' => array(
			//Register custom jquery and jquery-ui
			'clientScript' => array(
				'packages' => array(
					'jquery'              => array(
						'baseUrl' => Yii::app()->request->basePath . '/test/scripts/jquery-ui/js',
						'js'      => array('jquery-1.10.2.js'),
					),
					'jquery.ui'           => array(
						'baseUrl' => Yii::app()->request->basePath . '/test/scripts/jquery-ui/js',
						'js'      => array('jquery-ui-1.10.4.custom.min.js'),
					),
					'coreScriptsPosition' => CClientScript::POS_END,
				)
			),
			'user'         => array(
				// enable cookie-based authentication
				'allowAutoLogin' => true,
			),

			'urlManager'   => array(
				'urlFormat'      => 'path',
				'showScriptName' => false,
				'caseSensitive'  => false,
				'rules'          => array(
					'<controller:\w+>/<id:\d+>'              => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
				),
			),

			'db'           => array(
				'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
			),
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
			'errorHandler' => array(
				// use 'site/error' action to display errors
				'errorAction' => 'site/error',
			),
			'log'          => array(
				'class'  => 'CLogRouter',
				'routes' => array(
					array(
						'class'  => 'CFileLogRoute',
						'levels' => 'error, warning',
					),
					// uncomment the following to show log messages on web pages
					/*
					array(
						'class'=>'CWebLogRoute',
					),
					*/
				),
			),
		),

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'     => array(
			// this is used in contact page
			'adminEmail' => 'edgarcardona87@gmail.com',
		),
	);