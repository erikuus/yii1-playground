<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Tabs simple');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Tabs simple');?></h2>

<?php $this->widget('CTabView',array(
	'activeTab'=>'tab2',
	'tabs'=>array(
		'tab1'=>array(
			'title'=>'Static tab',
			'content'=>'Content for tab 1'
		),
		'tab2'=>array(
			'title'=>'Render tab',
			'view'=>'pages/_content1'
		),
		'tab3'=>array(
			'title'=>'Url tab',
			'url'=>Yii::app()->createUrl("site/index"),
		)
	),
	'htmlOptions'=>array(
		'style'=>'width:500px;'
	)
)); ?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CTabView',array(
	'activeTab'=>'tab2',
	'tabs'=>array(
		'tab1'=>array(
			'title'=>'Static tab',
			'content'=>'Content for tab 1'
		),
		'tab2'=>array(
			'title'=>'Render tab',
			'view'=>'pages/_content1'
		),
		'tab3'=>array(
			'title'=>'Url tab',
			'url'=>Yii::app()->createUrl("site/index"),
		)
	),
	'htmlOptions'=>array(
		'style'=>'width:500px;'
	)
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/views/site/pages/_content1.php
</pre></div>