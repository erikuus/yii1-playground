<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Update Menu');

$this->breadcrumbs=array(
	Yii::t('ui','Menus')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('ui','Update'),
);
?>

<h2><?php echo Yii::t('ui', 'Update Menu'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>