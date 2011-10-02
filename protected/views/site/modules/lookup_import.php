<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui','Classificators') .' - '.Yii::t('ui', 'Imported functions');
$this->layout='leftbar';
$this->leftPortlets['ptl.ModuleMenu']=array();
// For this example only
$model=Person::model()->findByPk(1);
?>

<h2><?php echo Yii::t('ui','Classificators') .' - '.Yii::t('ui', 'Imported functions');?></h2>

<h3><?php echo Yii::t('ui','Display classificator');?></h3>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
echo Lookup::item("eyecolor",$model->eyecolor_code);
<?php $this->endWidget(); ?>

<?php echo Lookup::item("eyecolor",$model->eyecolor_code); ?>

<h3 style="margin-top:30px"><?php echo Yii::t('ui','Dropdown classificators');?></h3>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
echo CHtml::activeDropDownList($model,'eyecolor_code',Lookup::items('eyecolor'));
<?php $this->endWidget(); ?>

<?php echo CHtml::activeDropDownList($model,'eyecolor_code',Lookup::items('eyecolor')); ?>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
echo CHtml::activeDropDownList($model,'eyecolor_code',
	Lookup::add()+Lookup::items('eyecolor'),array('prompt'=>''));
<?php $this->endWidget(); ?>

<?php echo CHtml::activeDropDownList($model,'eyecolor_code',
	Lookup::add()+Lookup::items('eyecolor'),array('prompt'=>'')); ?>

<h3 style="margin-top:30px"><?php echo Yii::t('ui','Gridview with classificators');?></h3>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'firstname',
		'lastname',
		array(
			'name'=>'eyecolor_code',
			'value'=>'Lookup::item("eyecolor",$data->eyecolor_code)',
		),
	),
))
<?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>Person::model()->search(),
	'pager'=>array(
		'header'=>'',
		'firstPageLabel'=>'<<',
		'prevPageLabel'=>'<',
		'nextPageLabel'=>'>',
		'lastPageLabel'=>'>>',
	),
	'columns'=>array(
		'firstname',
		'lastname',
		array(
			'name'=>'eyecolor_code',
			'value'=>'Lookup::item("eyecolor",$data->eyecolor_code)',
		),
	),
)); ?>