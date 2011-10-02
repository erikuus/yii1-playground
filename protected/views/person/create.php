<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'New Person');

$this->breadcrumbs=array(
	Yii::t('ui','Persons')=>array('admin'),
	Yii::t('ui','New'),
);
?>

<h2><?php echo Yii::t('ui', 'New Person'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>