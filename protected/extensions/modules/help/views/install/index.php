<?php 
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('HelpModule.ui', 'Helps'); 
$this->breadcrumbs=array(
	Yii::t('HelpModule.ui', 'Helps'),
);
?>

<h2><?php echo Yii::t('HelpModule.ui', 'Installation'); ?></h2>

<p><?php echo Yii::t('HelpModule.ui', 'Create table "{table}" for help module.', 
	array('{table}'=>Yii::app()->controller->module->helpTable)); ?></p>

<?php echo CHtml::linkButton(Yii::t('HelpModule.ui', 'Create Table'),array(
	'submit'=>array('create'), 'confirm'=>Yii::t('HelpModule.ui','Are you sure to create new table?'),
));?>