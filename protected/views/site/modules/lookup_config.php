<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui','Classificators') .' - '.Yii::t('ui', 'Configuration');
$this->layout='leftbar';
$this->leftPortlets['ptl.ModuleMenu']=array();
?>

<h2><?php echo Yii::t('ui','Classificators') .' - '.Yii::t('ui', 'Configuration');?></h2>

<b>protected/config/main.php</b>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
	// autoloading
	'import'=>array(
		'ext.modules.lookup.models.*',
	),
	// modules
	'modules'=>array(
		'lookup'=>array(
			'class'=>'ext.modules.lookup.LookupModule',
			'lookupLayout'=>'application.views.layouts.leftbar',
			'lookupTable'=>'tbl_lookup',
			'rbac'=>'manageLookups',
			'safeTypes'=>array('eyecolor'),
			'leftPortlets'=>array(
				'ptl.ModuleMenu'=>array()
			)
		),
	),
<?php $this->endWidget(); ?>