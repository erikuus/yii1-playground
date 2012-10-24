<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Droppable');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Droppable');?></h2>

<?php $this->beginWidget('zii.widgets.jui.CJuiDroppable', array(
	'options'=>array(
		'drop'=>'js:function(event,ui){$(this).html("Dropped!")}',
	),
	'htmlOptions'=>array(
		'style'=>'width: 150px; height: 150px; padding: 5px; border: 1px solid #e3e3e3; background: #f7f7f7',
	),
));
	echo 'Drop here';

$this->endWidget();
?>

<br />

<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
	'options'=>array(
		'cursor'=>'move',
	),
	'htmlOptions'=>array(
		'style'=>'width: 50px; height: 50px; padding: 5px; border: 1px solid #fad42e; background: #fcefa1',
	),
));
	echo 'Drag';

$this->endWidget();
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->beginWidget('zii.widgets.jui.CJuiDroppable', array(
	'options'=>array(
		'drop'=>'js:function(event,ui){$(this).html("Dropped!")}',
	),
	'htmlOptions'=>array(
		'style'=>'width: 150px; height: 150px; padding: 5px; border: 1px solid #fad42e; background: #fcefa1;',
	),
));
	echo 'Drop here';
$this->endWidget();
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/droppable/">http://jqueryui.com/demos/droppable/</a>