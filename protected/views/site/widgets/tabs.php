<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Tabs advanced');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Tabs advanced');?></h2>

<?php $this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		'Static tab'=>'Static content',
		'Render tab'=>$this->renderPartial('pages/_content1',null,true),
		'Ajax tab'=>array('ajax'=>array('ajaxContent','view'=>'_content2')),
	),
	'options'=>array(
		'collapsible'=>true,
		'selected'=>1,
	),
	'htmlOptions'=>array(
		'style'=>'width:500px;'
	),
)); ?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs'=>array(
		'Static tab'=>'Static content',
		'Render tab'=>$this->renderPartial('pages/_content1',null,true),
		'Ajax tab'=>array('ajax'=>array('ajaxContent','view'=>'_content2')),
	),
	'options'=>array(
		'collapsible'=>true,
		'selected'=>1,
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
protected/controllers/SiteController.php: public function actions()
protected/views/site/pages/_content1.php
protected/views/site/pages/_content2.php
</pre></div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/tabs/">http://jqueryui.com/demos/tabs/</a>