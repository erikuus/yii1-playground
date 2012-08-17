<?php 
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('HelpModule.ui', 'Install'); 
$this->breadcrumbs=array(
	Yii::t('HelpModule.ui', 'Helps')=>array('/help'),
	Yii::t('HelpModule.ui', 'Installation')=>array('index'),
	Yii::t('HelpModule.ui', 'Installation is complete'),
);
?>

<h2><?php echo Yii::t('HelpModule.ui', 'Installation is complete'); ?></h2>

<p><?php echo CHtml::link(Yii::t('HelpModule.ui', 'Manage help texts'), array('/help'));?></p>