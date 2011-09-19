<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Persons');

$this->breadcrumbs=array(
	Yii::t('ui','Persons'),
);
?>

<h2><?php echo Yii::t('ui', 'Persons'); ?></h2>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'ajaxUpdate'=>false,
	'template'=>'{sorter}{pager}{summary}{items}{pager}',
	'itemView'=>'_view',
	'pager'=>array(
		'maxButtonCount'=>'7',
	),
	'sortableAttributes'=>array(
		'firstname',
		'lastname',
		'birthyear',
	),
)); ?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'ajaxUpdate'=>false,
	'template'=>'{sorter}{pager}{summary}{items}{pager}',
	'itemView'=>'_view',
	'pager'=>array(
		'maxButtonCount'=>'7',
	),
	'sortableAttributes'=>array(
		'firstname',
		'lastname',
		'birthyear'
	),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/PersonController.php: public function actionIndex()
protected/models/Person.php
protected/views/person/_view.php
</pre></div>
