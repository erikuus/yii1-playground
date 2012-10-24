<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('ptl',dirname(__FILE__).'/../portlets');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Yii Playground',
	'defaultController'=>'Site',
	'language'=>'et',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model, component and extension classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.components.database.*',
		'ext.widgets.portlet.XPortlet',
		'ext.helpers.XHtml',
		'ext.modules.help.models.*',
		'ext.modules.lookup.models.*',
	),

	// modules
	'modules'=>array(
		'lookup'=>array(
			'class'=>'ext.modules.lookup.LookupModule',
			'lookupLayout'=>'application.views.layouts.leftbar',
			'lookupTable'=>'tbl_lookup',
			'safeTypes'=>array('eyecolor'),
			'leftPortlets'=>array(
				'ptl.ModuleMenu'=>array()
			)
		),
		'help'=>array(
			'class'=>'ext.modules.help.HelpModule',
			'helpLayout'=>'application.views.layouts.leftbar',
			'helpTable'=>'tbl_help',
			'leftPortlets'=>array(
				'ptl.ModuleMenu'=>array()
			),
			'editorCSS'=>'editor.css',
			'editorUploadRoute'=>'/request/uploadFile',
		),
	),

	// application components
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CProfileLogRoute',
					'report'=>'summary',
				),
			),
		),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'coreMessages'=>array(
			'basePath'=>'protected/messages',
		),
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'clientScript' => array(
			'scriptMap' => array(
				'jquery-ui.css'=> dirname($_SERVER['SCRIPT_NAME']).'/css/jui/custom/jquery-ui.css',
			),
		),
        'widgetFactory'=>array(
            'enableSkin'=>true,
        ),
		'urlManager'=>array(
			'class' => 'ext.components.language.XUrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>true,
			'appendParams'=>false,
			'rules'=>array(
				'<language:\w{2}>' => 'site/index',
				'<language:\w{2}>/<_c:\w+>' => '<_c>',
				'<language:\w{2}>/<_c:\w+>/<_a:\w+>'=>'<_c>/<_a>',
				'<language:\w{2}>/<_m:\w+>' => '<_m>',
				'<language:\w{2}>/<_m:\w+>/<_c:\w+>' => '<_m>/<_c>',
				'<language:\w{2}>/<_m:\w+>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
			),
		),
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/yiiplay.db',
		),
		'cache'=>array(
			'class'=>'CDbCache',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);