<?php
$this->pageTitle=Yii::app()->name.' - '.Yii::t('LookupModule.ui','Lookup Names');
$this->breadcrumbs=array(
	Yii::t('LookupModule.ui','Lookup Names'),
);
?>

<h2><?php echo Yii::t('LookupModule.ui','Lookup Names'); ?></h2>

<?php $this->widget('zii.widgets.CMenu', array(
	'items'=>Lookup::model()->menu,
	'htmlOptions'=>array('style'=>'line-height:200%'),
)); ?>