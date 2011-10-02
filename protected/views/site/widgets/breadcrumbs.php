<?php $this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Breadcrumbs'); ?>

<?php
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Breadcrumbs'); ?></h2>

<?php
$this->widget('zii.widgets.CBreadcrumbs',array(
	'links'=>array(
		Yii::t('ui','Widgets')=>array('person/index'),
		Yii::t('ui','Breadcrumbs')
	)
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.CBreadcrumbs',array(
	'links'=>array(
		Yii::t('ui','Widgets')=>array('person/index'),
		Yii::t('ui','Breadcrumbs')
	)
));
<?php $this->endWidget(); ?>
</div>