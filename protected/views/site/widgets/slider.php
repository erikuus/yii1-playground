<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Slider');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Slider');?></h2>
<h3><?php echo Yii::t('ui','Zoom');?></h3>

<?php $this->widget('zii.widgets.jui.CJuiSlider', array(
	'value'=>50,
	'options'=>array(
		'min'=>1,
		'max'=>100,
		'slide'=>'js:
			function(event,ui){
				$("#image").width(400*ui.value/100);
				$("#zoom").text(ui.value+"%");
			}
		',
	),
	'htmlOptions'=>array(
		'style'=>'width:200px; float:left;'
	),
)); ?>

<div id="zoom" style="margin-left:215px;">50%</div>

<br class="clearfloat" />
<br />

<img id="image" width="200" src="<?php echo XHtml::imageUrl('marilyn-monroe.jpg');?>">

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiSlider', array(
	'value'=>40,
	'options'=>array(
		'min'=>1,
		'max'=>100,
		'slide'=>'js:
			function(event,ui){
				$("#image").width(400*ui.value/100);
				$("#zoom").text(ui.value+"%");
			}
		',
	),
	'htmlOptions'=>array(
		'style'=>'width:200px; float:left;'
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Input');?></h3>

<?php $this->widget('zii.widgets.jui.CJuiSliderInput', array(
	//'model'=>$model,
	//'attribute'=>'size',
	'name'=>'my_slider',
	'value'=>50,
	'event'=>'change',
	'options'=>array(
		'min'=>0,
		'max'=>100,
		'slide'=>'js:function(event,ui){$("#amount").text(ui.value);}',
	),
	'htmlOptions'=>array(
		'style'=>'width:200px; float:left;'
	),
)); ?>

<div id="amount" style="margin-left:215px;">50</div>

<br class="clearfloat" />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiSliderInput', array(
	//'model'=>$model,
	//'attribute'=>'size',
	'name'=>'my_slider',
	'value'=>50,
	'event'=>'change',
	'options'=>array(
		'min'=>0,
		'max'=>100,
		'slide'=>'js:function(event,ui){$("#amount").text(ui.value);}',
	),
	'htmlOptions'=>array(
		'style'=>'width:200px; float:left;'
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/slider/">http://jqueryui.com/demos/slider/</a>