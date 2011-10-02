<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Batch menu');
$this->leftPortlets=null;
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui', 'Batch menu'); ?></h2>

<?php $this->widget('ext.widgets.bmenu.XBatchMenu', array(
	'formId'=>'person-form',
	'checkBoxId'=>'person-id',
	'emptyText'=>Yii::t('ui','Please check items you would like to perform this action on!'),
	'confirm'=>Yii::t('ui','Are you sure to perform this action on checked items?'),
	'items'=>array(
		array('label'=>Yii::t('ui','Make selected persons 1 year younger'),'url'=>array('updateYears','op'=>'more')),
		array('label'=>Yii::t('ui','Make selected persons 1 year older'),'url'=>array('updateYears','op'=>'less')),
		// if CGridView has 'ajaxUpdate'=>false, then use ReturnableUrl and remove 'ajaxUpdate'=>'person-grid' from this widget
		//array('label'=>Yii::t('ui','Make selected persons 1 year younger'),'url'=>$this->createReturnableUrl('updateYears',array('op'=>'more'))),
		//array('label'=>Yii::t('ui','Make selected persons 1 year older'),'url'=>$this->createReturnableUrl('updateYears',array('op'=>'less'))),
	),
	'htmlOptions'=>array('class'=>'actionBar'),
	'ajaxUpdate'=>'person-grid', // if you want to update grid by ajax
)); ?>

<?php echo CHtml::beginForm('','post',array('id'=>'person-form'));?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'person-grid',
	'dataProvider'=>$model->search(),
	'selectableRows'=>2, // multiple rows can be selected
	//'ajaxUpdate'=>false,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'id'=>'person-id',
		),
		'lastname',
		'firstname',
		'birthyear',
		array(
			'name'=>'country_id',
			'value'=>'$data->country->name',
		),
		array(
			'name'=>'eyecolor_code',
			'value'=>'Lookup::item("eyecolor",$data->eyecolor_code)',
		),
	),
)); ?>
<?php echo CHtml::endForm();?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.bmenu.XBatchMenu', array(
	'formId'=>'person-form',
	'checkBoxId'=>'person-id',
	'ajaxUpdate'=>'person-grid', // if you want to update grid by ajax
	'emptyText'=>Yii::t('ui','Please check items you would like to perform this action on!'),
	'confirm'=>Yii::t('ui','Are you sure to perform this action on checked items?'),
	'items'=>array(
		array('label'=>Yii::t('ui','Make selected persons 1 year younger'),'url'=>array('updateYears','op'=>'more')),
		array('label'=>Yii::t('ui','Make selected persons 1 year older'),'url'=>array('updateYears','op'=>'less')),
	),
	'htmlOptions'=>array('class'=>'actionBar'),
));

echo CHtml::beginForm('','post',array('id'=>'person-form'));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'person-grid',
	'dataProvider'=>$model->search(),
	'selectableRows'=>2, // multiple rows can be selected
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'id'=>'person-id',
		),
		'lastname',
		'firstname',
		'birthyear',
		array(
			'name'=>'country_id',
			'value'=>'$data->country->name',
		),
		array(
			'name'=>'eyecolor_code',
			'value'=>'Lookup::item("eyecolor",$data->eyecolor_code)',
		),
	),
));
echo CHtml::endForm();
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/PersonController.php: public function actionUpdateYears()
protected/models/Person.php
</pre></div>

