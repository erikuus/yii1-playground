<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Update Person');

$this->breadcrumbs=array(
	Yii::t('ui','Persons')=>$this->getReturnUrl() ? $this->getReturnUrl() : array('index'),
	Yii::t('ui','Update'),
);
?>

<h2><?php echo Yii::t('ui', 'Update Person'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>