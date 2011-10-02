<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Alpha pagination');
$this->leftPortlets=null;
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui', 'Alpha pagination'); ?></h2>

<?php $this->widget('ext.widgets.alphapager.XAlphaLinkPager',array(
	'pages'=>$alphaPages,
	'header'=>false,
)); ?>

<br /><br />

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'ajaxUpdate'=>false,
	'template'=>'{pager}{sorter}{summary}{items}{pager}',
	'itemView'=>'_view',
	'pager'=>array(
		'header'=>false,
		'maxButtonCount'=>'9',
	),
	'sortableAttributes'=>array(
		'firstname',
		'lastname',
		'birthyear',
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.alphapager.XAlphaLinkPager',array(
	'pages'=>$alphaPages,
	'header'=>false,
));

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'ajaxUpdate'=>false,
	'template'=>'{pager}{sorter}{summary}{items}{pager}',
	'itemView'=>'_view',
	'pager'=>array(
		'header'=>false,
		'maxButtonCount'=>'9',
	),
	'sortableAttributes'=>array(
		'firstname',
		'lastname',
		'birthyear',
	),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/PersonController.php: public function actionAlpha()
protected/models/Person.php
protected/views/person/_view.php
</pre></div>