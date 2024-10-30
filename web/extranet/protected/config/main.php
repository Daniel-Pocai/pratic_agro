<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

include('main-db.php');
include('main-email.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'pratic_agro',

	// preloading 'log' component
	'preload'=>array('log'),
	
	'language'=>'pt_br',
	'sourceLanguage'=>'00',
	
	'charset' => 'ISO-8859-1',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.giix-components.*', 
		'ext.yii-mail.YiiMailMessage',
		'ext.CJuiDateTimePicker.CJuiDateTimePicker',
		'ext.galleryManager.models.*',
		'ext.galleryManager.*',
		'application.helpers.*',
		'ext.cascadedropdown.ECascadeDropDown',
		'ext.behaviors.AttachmentBehavior',
		'ext.m2brimagem.m2brimagem',
	),
	
	'aliases' => array(
		//If you manually installed it
		'xupload' => 'ext.xupload',
	),
	
	'controllerMap' => array(
        'gallery' => array(
            'class' => 'ext.galleryManager.GalleryController',
        ),
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'ext.gii-brsis.GiiModule',
			'password'=>'b4c8z1t9',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','192.168.0.*','::1', '192.167.0.*','devbrsis'),
			'generatorPaths' => array(
				'ext.giix-core', // giix generators
			),
		),
		
	),
	
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		'image'=>array(
			'class'=>'application.extensions.image.CImageComponent',
			// GD or ImageMagick
			'driver'=>'GD',
			// ImageMagick setup path
        ),
		
		'mail' => array(
			'class' => 'application.extensions.yii-mail.YiiMail',
			'transportType'=>'smtp', /// case sensitive!
			'transportOptions'=>array(
				'host'=>$email['host'],
				'username'=>$email['username'],
				// or email@googleappsdomain.com
				'password'=>$email['password'],
				'port'=>$email['port'],
				//'encryption'=>'ssl',
				),
			'viewPath' => 'application.views.mail',
			'logging' => true,
			'dryRun' => false
		),
		
		'metadata'=>array('class'=>'Metadata'),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'entrar' => 'site/login',
				'<action:(login|logout|recuperacao_senha|esqueci_senha)>' => 'site/<action>',
				'<controller:\w+>'=>'<controller>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>?<id:\d+>'=>'<controller>/view',
				'thumbnail/<tipo:\w+>/<dimensoes:\w+>/<model:\w+>/<img:\S+>/<rgb:\S+>'=>'thumbnail/redimensionar',
				'thumbnail/<tipo:\w+>/<dimensoes:\w+>/<model:\w+>/<img:\S+>'=>'thumbnail/redimensionar',
				'thumbnail/<model:\w+>/<img:\S+>'=>'thumbnail/original',
			),
		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host='.$db['host'].';dbname='.$db['db'],
			'emulatePrepare' => true,
			'username' => $db['username'],
			'password' => $db['password'],
			'charset' => 'latin1',
			'enableProfiling' => true,
     		'enableParamLogging' => true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		//'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning',
//				),
//				// uncomment the following to show log messages on web pages
//				/*
//				array(
//					'class'=>'CWebLogRoute',
//				),
//				*/
//			),
//		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				/*array(
					'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
					'ipFilters'=>array('127.0.0.1'),
				),
                array(
                    'class' => 'ext.phpconsole.PhpConsoleYiiExtension',
					'ipFilters'=>array('127.0.0.1'),
					'handleSql' => true,
                    'handleErrors' => true,
                    'handleExceptions' => true,
                    'basePathToStrip' => dirname($_SERVER['DOCUMENT_ROOT']),
                )*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'defaultPageSize' => 10,
	),
);