<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Masked textfield');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Masked textfield');?></h2>

<?php $this->widget('CMaskedTextField',array(
	//'model'=>$model,
	//'attribute'=>'date',
	'name'=>'date',
	'mask'=>'99.99.9999',
	'htmlOptions'=>array(
		'style'=>'width:80px;'
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CMaskedTextField',array(
	//'model'=>$model,
	//'attribute'=>'date',
	'name'=>'date',
	'mask'=>'99.99.9999',
	'htmlOptions'=>array(
		'style'=>'width:80px;'
	),
));
<?php $this->endWidget(); ?>
</div>

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank"
	href="http://digitalbush.com/projects/masked-input-plugin/">http://digitalbush.com/projects/masked-input-plugin/</a>