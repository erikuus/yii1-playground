<?php 
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('LookupModule.ui', 'Lookup Names'); 
$this->breadcrumbs=array(
	Yii::t('LookupModule.ui', 'Lookup Names'),
);
?>

<h2><?php echo Yii::t('LookupModule.ui', 'Installation'); ?></h2>

<p><?php echo Yii::t('LookupModule.ui', 'Create table "{table}" for lookup module.', 
	array('{table}'=>Yii::app()->controller->module->lookupTable)); ?></p>

<?php echo CHtml::linkButton(Yii::t('LookupModule.ui', 'Create Table'),array(
	'submit'=>array('create'), 'confirm'=>Yii::t('LookupModule.ui','Are you sure to create new table?'),
));?>