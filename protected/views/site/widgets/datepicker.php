<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Datepicker');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Datepicker');?></h2>

<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	//'model'=>$model,
	//'attribute'=>'',
	'name'=>'my_date',
	'language'=> Yii::app()->language=='et' ? 'et' : null,
	'options'=>array(
		'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
		'showOn'=>'button', // 'focus', 'button', 'both'
		'buttonText'=>Yii::t('ui','Select form calendar'),
		'buttonImage'=>XHtml::imageUrl('calendar.png'),
		'buttonImageOnly'=>true,
	),
	'htmlOptions'=>array(
		'style'=>'width:80px;vertical-align:top'
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
	'name'=>'my_date',
	'language'=>Yii::app()->language=='et' ? 'et' : null,
	'options'=>array(
		'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
		'showOn'=>'button', // 'focus', 'button', 'both'
		'buttonText'=>Yii::t('ui','Select form calendar'),
		'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.gif',
		'buttonImageOnly'=>true,
	),
	'htmlOptions'=>array(
		'style'=>'width:80px;vertical-align:top'
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/datepicker/">http://jqueryui.com/demos/datepicker/</a>