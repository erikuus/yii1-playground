<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'View Person');

$this->breadcrumbs=array(
	Yii::t('ui','Persons')=>$this->getReturnUrl() ? $this->getReturnUrl() : array('index'),
	$model->firstname.' '.$model->lastname,
);
?>

<h2><?php echo Yii::t('ui', 'View Person'); ?></h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'id', // only admin user can see person id
			'visible'=>Yii::app()->user->name=='admin'? true : false,
		),
		'firstname',
		'lastname',
		'birthyear',
		'email:email',
		'webpage:url',
		array(
			'name'=>'country_id',
			'value'=>$model->country->name,
		),
		array(
			'name'=>'eyecolor_code',
			'value'=>Lookup::item('eyecolor',$model->eyecolor_code),
		),
		'registered',
	),
));
?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'id', // only admin user can see person id
			'visible'=>Yii::app()->user->name=='admin'? true : false,
		),
		'firstname',
		'lastname',
		'birthyear',
		'email:email',
		'webpage:url',
		array(
			'name'=>'country_id',
			'value'=>$model->country->name,
		),
		array(
			'name'=>'eyecolor_code',
			'value'=>Lookup::item('eyecolor',$model->eyecolor_code),
		),
		'registered',
	),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/PersonController.php: public function actionView()
protected/models/Person.php
</pre></div>
