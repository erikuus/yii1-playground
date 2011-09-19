<?php 
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('LookupModule.ui', 'Install'); 
$this->breadcrumbs=array(
	Yii::t('LookupModule.ui', 'Lookup Names')=>array('/lookup'),
	Yii::t('LookupModule.ui', 'Installation')=>array('index'),
	Yii::t('LookupModule.ui', 'Installation is complete'),
);
?>

<h2><?php echo Yii::t('LookupModule.ui', 'Installation is complete'); ?></h2>

<p><?php echo CHtml::link(Yii::t('LookupModule.ui', 'Manage lookup names'), array('/lookup'));?></p>