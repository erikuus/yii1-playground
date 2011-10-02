<?php
Yii::app()->clientScript->registerScript('formTree', "
	$('#menu-treeview a').live('click',function(){
		var id=$(this).attr('id');
		$('#parent-id').val(id);
		$.ajax({
			url:'".$this->createUrl('ajaxPath')."',
			data:{'id':id},
			cache:false,
			success:function(data){return $('#parent-path').val(data);}
		});
		$('#tree-dialog').dialog('close');
		return false;
	});
");
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menu-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p><?php echo Yii::t('ui', 'Fields with {mark} are required',
	array('{mark}'=>'<span class="required">*</span>')); ?>
</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="simple">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parentPath', array(
			'id'=>'parent-path',
			'onclick'=>'$("#tree-dialog").dialog("open");return false;',
			'readonly'=>'readonly',
			'class'=>'readonly',
			'style'=>'width:200px',
		)); ?>
		<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'suggest_hierarchy',
			'source'=>$this->createUrl('suggestHierarchy'),
			'options'=>array(
				'select'=>"js:function(event, ui) {
					$('#parent-id').val(ui.item.id);
					$('#parent-path').val(ui.item.label);
				}"
			),
			'htmlOptions'=>array(
				'class'=>'autocomplete',
				'style'=>'width:200px'
			),
		));	?>
		<?php echo $form->hiddenField($model,'parent_id',array('id'=>'parent-id')); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'label'); ?>
		<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'label'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

	<div class="action">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('ui', 'Create') : Yii::t('ui','Save')); ?>
		<?php echo CHtml::button(Yii::t('ui', 'Cancel'), array('submit'=>$this->getReturnUrl())) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'tree-dialog',
	'options'=>array(
		'title'=>Yii::t('ui','Select form hierarchy'),
		'width'=>500,
		'height'=>300,
		'autoOpen'=>false,
		'modal'=>true,
	)
));
echo $this->renderPartial('_tree');
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>