<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php"; ?>
Yii::app()->clientScript->registerScript('formTree', "
	$('#<?php echo $this->class2id($this->modelClass); ?>-treeview a').live('click',function(){
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

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p><?php  echo "<?php echo Yii::t('ui', 'Fields with {mark} are required',
	array('{mark}'=>'<span class=\"required\">*</span>')); ?>\n"; ?></p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

	<div class="simple">
		<?php echo "<?php"; ?> echo $form->labelEx($model,'parent_id'); ?>
		<?php echo "<?php"; ?> echo $form->textField($model,'parentPath', array(
			'id'=>'parent-path',
			'onclick'=>'$("#tree-dialog").dialog("open");return false;',
			'readonly'=>'readonly',
			'class'=>'readonly',
			'style'=>'width:200px',
		)); ?>
		<?php echo "<?php"; ?> $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
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
		)); ?>
		<?php echo "<?php"; ?> echo $form->hiddenField($model,'parent_id',array('id'=>'parent-id')); ?>
		<?php echo "<?php"; ?> echo $form->error($model,'parent_id'); ?>
	</div>
<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->name=='id' || $column->name=='parent_id')
		continue;
?>
	<div class="simple">
		<?php echo "<?php echo ".$this->generateActiveLabel($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo ".$this->generateActiveField($this->modelClass,$column)."; ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'{$column->name}'); ?>\n"; ?>
	</div>

<?php
}
?>
	<div class="action">
		<?php echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? Yii::t('ui', 'Create') : Yii::t('ui','Save')); ?>\n"; ?>
		<?php echo "<?php echo CHtml::link(Yii::t('ui', 'Cancel'), \$this->getReturnUrl() ? \$this->getReturnUrl() : array('admin')); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->

<?php echo "<?php"; ?> $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>