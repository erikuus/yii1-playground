<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Google Map Input');
$this->layout = 'leftbar';
$this->leftPortlets['ptl.ExtensionMenu'] = array();
?>

<h2><?php echo Yii::t('ui','Google Map Input');?></h2>

<h3><?php echo Yii::t('ui','Ex 1: No data from database, default map data');?></h3>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mapA-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php $this->widget('ext.widgets.google.XGoogleInputMap', array(
		'googleApiKey'=>Yii::app()->params['googleApiKey'],
		'form'=>$form,
		'model'=>new Map,
	)); ?>
<?php $this->endWidget(); ?>
<br />

<h3><?php echo Yii::t('ui','Ex 2: Map and rectangle data from database');?></h3>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mapB-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php $this->widget('ext.widgets.google.XGoogleInputMap', array(
		'googleApiKey'=>Yii::app()->params['googleApiKey'],
		'form'=>$form,
		'model'=>new Map('test1')
	)); ?>
<?php $this->endWidget(); ?>
<br />

<h3><?php echo Yii::t('ui','Ex 3: Rectangle data from database, auto adjust map');?></h3>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mapC-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php $this->widget('ext.widgets.google.XGoogleInputMap', array(
		'googleApiKey'=>Yii::app()->params['googleApiKey'],
		'form'=>$form,
		'model'=>new Map('test2')
	)); ?>
<?php $this->endWidget(); ?>
<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleInputMap', array(
	'googleApiKey'=>Yii::app()->params['googleApiKey'],
	'form'=>$form,
	'model'=>$model,
));
<?php $this->endWidget(); ?>
</div>

