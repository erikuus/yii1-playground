<?php 
$this->pageTitle=Yii::app()->name.' - '.Yii::t('LookupModule.ui','Lookup Names'); 
$this->breadcrumbs=array(
	Yii::t('LookupModule.ui','Lookup Names')=>array('index'),
	Yii::t('ui',XHtml::labelize($model->type))=>array('admin','type'=>$model->type),
	Yii::t('LookupModule.ui', 'Update'),
);
?>

<h2>
<?php echo Yii::t('LookupModule.ui', 'Update'); ?>
 &#171;<?php echo Yii::t('ui', XHtml::labelize($model->type)); ?>&#187;
</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>