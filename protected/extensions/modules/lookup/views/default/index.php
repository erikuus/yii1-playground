<?php
$this->pageTitle=Yii::app()->name.' - '.Yii::t('LookupModule.ui','Lookup Names');
$this->breadcrumbs=array(
	Yii::t('LookupModule.ui','Lookup Names'),
);
Yii::app()->clientScript->registerScript('search', "
	$('.new-type-button').click(function(){
		$('.new-type-form').toggle();
		return false;
	});
");
?>

<h2><?php echo Yii::t('LookupModule.ui','Lookup Names'); ?></h2>

<?php if(Yii::app()->user->name=='admin'):?>
	<p><?php echo CHtml::link(Yii::t('LookupModule.ui', 'New'),'#',array('class'=>'new-type-button')); ?></p>
	<div class="new-type-form" style="display:none">
		<?php $this->renderPartial('_indexForm',array(
			'model'=>$model,
		)); ?>
	</div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CMenu', array(
	'items'=>Lookup::model()->menu,
	'htmlOptions'=>array('style'=>'line-height:200%'),
)); ?>