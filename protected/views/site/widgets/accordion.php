<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Accordion');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Accordion');?></h2>

<?php $this->widget('zii.widgets.jui.CJuiAccordion', array(
	'panels'=>array(
		'panel 1'=>'Content for panel 1',
		'panel 2'=>'Content for panel 2',
		'panel 3'=>$this->renderPartial('pages/_content1',null,true),
	),
	'options'=>array(
		'collapsible'=>true,
		'active'=>1,
	),
	'htmlOptions'=>array(
		'style'=>'width:500px;'
	),
)); ?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiAccordion', array(
	'panels'=>array(
		'panel 1'=>'Content for panel 1',
		'panel 2'=>'Content for panel 2',
		'panel 3'=>$this->renderPartial('pages/_content1',null,true),
	),
	'options'=>array(
		'collapsible'=>true,
		'active'=>1,
	),
	'htmlOptions'=>array(
		'style'=>'width:500px;'
	),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/views/site/pages/_content1.php
</pre></div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/accordion/">http://jqueryui.com/demos/accordion/</a>