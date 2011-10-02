<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui','Helps') .' - '.Yii::t('ui', 'Configuration');
$this->layout='leftbar';
$this->leftPortlets['ptl.ModuleMenu']=array();
?>

<h2><?php echo Yii::t('ui','Helps') .' - '.Yii::t('ui', 'Configuration');?></h2>

<b>protected/config/main.php</b>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
	// autoloading
	'import'=>array(
		'ext.modules.help.models.*',
	),
	// modules
	'modules'=>array(
		'help'=>array(
			'class'=>'ext.modules.help.HelpModule',
			'helpLayout'=>'application.views.layouts.leftbar',
			'helpTable'=>'tbl_help',
			'rbac'=>'manageHelps',
			'leftPortlets'=>array(
				'ptl.ModuleMenu'=>array()
			),
			'editorCSS'=>'editor.css',
			'editorUploadRoute'=>'/request/uploadFile',
		),
	),
<?php $this->endWidget(); ?>