<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Resizable');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Resizable');?></h2>

<?php $this->beginWidget('zii.widgets.jui.CJuiResizable', array(
	'options'=>array(
		'minWidth'=>50,
		'minHeight'=>50,
		'maxWidth'=>500,
		'maxHeight'=>500,
	),
	'htmlOptions'=>array(
		'style'=>'width: 150px; height: 150px; padding: 0.5em; border: 1px solid #e3e3e3; background: #f7f7f7'
	),
));
	echo 'Your resizable content here';

$this->endWidget();
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->beginWidget('zii.widgets.jui.CJuiResizable', array(
	'options'=>array(
		'minWidth'=>50,
		'minHeight'=>50,
		'maxWidth'=>500,
		'maxHeight'=>500,
	),
	'htmlOptions'=>array(
		'style'=>'width: 150px; height: 150px; padding: 0.5em; border: 1px solid #e3e3e3; background: #f7f7f7'
	),
));
	echo 'Your resizable content here';
$this->endWidget();
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/resizable/">http://jqueryui.com/demos/resizable/</a>