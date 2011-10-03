<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 *
 * EXAMPLE (on windows): yiic message C:\inetpub\wwwroot\labs\newapp\protected\config\messages.php
 */
return array(
	'sourcePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'messagePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'messages',
	'languages'=>array('et'),
	'fileTypes'=>array('php'),
	'exclude'=>array(
		'.svn',
		'.project',
		'.settings',
		'.cache',
		'/extensions',
		'/messages',
	),
	"overwrite" => true
);