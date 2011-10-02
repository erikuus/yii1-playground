<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'New Menu');

$this->breadcrumbs=array(
	Yii::t('ui','Menus')=>array('index'),
	Yii::t('ui','New'),
);
?>

<h2><?php echo Yii::t('ui', 'New Menu'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>