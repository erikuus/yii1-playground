<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Progressbar');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();

//  Dummy function just to provide an example
Yii::app()->clientScript->registerScript('scriptId', "
	var count = 0;
	var step  = 10;
	var speed = 500;
	function progress() {
		$('#amount').text(count+'%');
		$('#progress').progressbar('option', 'value', count);
		if(count < 100) {
			count = count+step;
			setTimeout(progress, speed);
		}
	}
	progress();
", CClientScript::POS_LOAD);
?>

<h2><?php echo Yii::t('ui','Progressbar');?></h2>

<?php $this->widget('zii.widgets.jui.CJuiProgressBar', array(
	'id'=>'progress',
	'value'=>0,
	'htmlOptions'=>array(
		'style'=>'width:200px; height:20px; float:left;'
	),
));
?>

<div id="amount" style="margin-left:210px; padding:3px;"></div>

<br class="clearfloat" />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiProgressBar', array(
	'id'=>'progress',
	'value'=>0,
	'htmlOptions'=>array(
		'style'=>'width:200px; height:20px; float:left;'
	),
));
<?php $this->endWidget(); ?>
</div>

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/progressbar/">http://jqueryui.com/demos/progressbar/</a>