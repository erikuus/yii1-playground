<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Dialog');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Dialog');?></h2>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'mydialog',
	'options'=>array(
		'title'=>'Dialog',
		'width'=>500,
		'height'=>300,
		'autoOpen'=>false,
	),
));
	echo 'dialog content here';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php echo CHtml::link(Yii::t('ui','Dialog'), '#', array('onclick'=>'$("#mydialog").dialog("open"); return false;')); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'mydialog',
	'options'=>array(
		'title'=>'Dialog',
		'width'=>500,
		'height'=>300,
		'autoOpen'=>false,
	),
));
	echo 'Dialog content here ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
<?php $this->endWidget(); ?>
</div>

<br />

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'mymodal',
	'options'=>array(
		'title'=>'Modal Dialog',
		'width'=>400,
		'height'=>200,
		'autoOpen'=>false,
		'resizable'=>false,
		'modal'=>true,
		'overlay'=>array(
			'backgroundColor'=>'#000',
			'opacity'=>'0.5'
		),
		'buttons'=>array(
			'OK'=>'js:function(){alert("OK");}',
			'Cancel'=>'js:function(){$(this).dialog("close");}',
		),
	),
));
	echo 'Modal dialog content here ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php echo CHtml::link(Yii::t('ui','Modal Dialog'), '#', array('onclick'=>'$("#mymodal").dialog("open"); return false;')); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'mymodal',
	'options'=>array(
		'title'=>'Modal Dialog',
		'width'=>400,
		'height'=>200,
		'autoOpen'=>false,
		'resizable'=>false,
		'modal'=>true,
		'overlay'=>array(
			'backgroundColor'=>'#000',
			'opacity'=>'0.5'
		),
		'buttons'=>array(
			'OK'=>'js:function(){alert("OK");}',
			'Cancel'=>'js:function(){$(this).dialog("close");}',
		),
	),
));
	echo 'Modal dialog content here ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/dialog/">http://jqueryui.com/demos/dialog/</a>

