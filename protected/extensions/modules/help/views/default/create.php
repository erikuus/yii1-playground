<?php 
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('HelpModule.ui', 'New Help');
$this->breadcrumbs=array(
	Yii::t('HelpModule.ui', 'Helps')=>array('admin'),
	Yii::t('HelpModule.ui', 'New Help'),
); 
?>

<h2><?php echo Yii::t('HelpModule.ui', 'New Help'); ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>