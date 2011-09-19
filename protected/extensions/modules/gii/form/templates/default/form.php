<?php
/**
 * This is the template for generating a form script file.
 * The following variables are available in this template:
 * - $this: the FormCode object
 */
?>
<div class="form">

<?php echo "<?php \$form=\$this->beginWidget('CActiveForm', array(
	'id'=>'".$this->class2id($this->modelClass).'-'.basename($this->viewName)."-form',
	'enableAjaxValidation'=>false,
)); ?>\n"; ?>

	<p><?php  echo "<?php echo Yii::t('ui', 'Fields with {mark} are required', 
	array('{mark}'=>'<span class=\"required\">*</span>')); ?>\n"; ?></p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php foreach($this->getModelAttributes() as $attribute): ?>
	<div class="simple">
		<?php echo "<?php echo \$form->labelEx(\$model,'$attribute'); ?>\n"; ?>
		<?php echo "<?php echo \$form->textField(\$model,'$attribute'); ?>\n"; ?>
		<?php echo "<?php echo \$form->error(\$model,'$attribute'); ?>\n"; ?>
	</div>

<?php endforeach; ?>
	<div class="action">
		<?php echo "<?php echo CHtml::submitButton(Yii::t('ui', 'Submit')); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

</div><!-- form -->