<?php

	// uncomment the following to define a path alias
	 Yii::setPathOfAlias('local','D:\\Wamp\\www\\test\\');

	// This is the main Web application configuration. Any writable
	// CWebApplication properties can be configured here.
	return array(
		'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
		'name'       => 'Edarkzero Playground',
		'language' => 'en_us',
		'sourceLanguage' => 'en',

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
						'baseUrl' => Yii::app()->basePath . '/test/scripts/jquery-ui/js',
						'js'      => array('jquery-1.10.2.js'),
					),
					'jquery.ui'           => array(
						'baseUrl' => Yii::app()->basePath . '/test/scripts/jquery-ui/js',
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
					array(
						'class' => 'application.components.CustomUrlRules',
						'connectionID' => 'db',
					),
					'<controller:\w+>/<id:\d+>'              => '<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
				),
			),

			/*'db'           => array(
				'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
			),*/

			'db'           => array(
				'connectionString'   => 'mysql:host=localhost;dbname=onbizz',
				'username'           => 'root',
				'password'           => '123456',
				'charset'            => 'utf8',
				'emulatePrepare'     => true,
				'enableProfiling'    => true,
				'enableParamLogging' => true,
			),

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
			'localhost_domain' => 'http://edarkzero.playground.test/test/hybridauth/socialLogin?hauth.done=Google'
		),
	);