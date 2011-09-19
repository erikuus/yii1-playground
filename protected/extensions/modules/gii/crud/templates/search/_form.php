<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p><?php  echo "<?php echo Yii::t('ui', 'Fields with {mark} are required', 
	array('{mark}'=>'<span class=\"required\">*</span>')); ?>\n"; ?></p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->isPrimaryKey)
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
		<?php echo "<?php \$this->widget('zii.widgets.jui.CJuiButton', array(
			'buttonType'=>'submit',
			'name'=>'btnSubmit',
			'value'=>'Submit',
			'caption'=>\$model->isNewRecord ? Yii::t('ui', 'Create') : Yii::t('ui','Save'),
		));  ?>\n"; ?>
		<?php echo "<?php \$this->widget('zii.widgets.jui.CJuiButton', array(
			'buttonType'=>'link',
			'name'=>'btnCancel',
			'value'=>'Cancel',
			'caption'=>Yii::t('ui', 'Cancel'),
			'url'=>\$model->isNewRecord ? array('admin') : \$this->getReturnUrl(),
		)); ?>\n"; ?>
	</div>			
	<?php /* echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? Yii::t('ui', 'Create') : Yii::t('ui','Save')); ?>\n"; */ ?>
	<?php /* echo "<?php echo CHtml::button(Yii::t('ui', 'Cancel'), array('submit' => \$model->isNewRecord ? array('admin') : \$this->getReturnUrl())) ?>\n"; */ ?>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->