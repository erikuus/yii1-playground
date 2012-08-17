<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lookup-form',
	'enableClientValidation'=>true,
	'clientOptions'=> array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
	),
)); ?>

	<?php // echo $form->errorSummary($model); ?>

	<div class="simple">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>32)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'name_et'); ?>
		<?php echo $form->textField($model,'name_et',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name_et'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'name_en'); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name_en'); ?>
	</div>

	<div class="action">
		<?php $this->widget('zii.widgets.jui.CJuiButton', array(
			'buttonType'=>'submit',
			'name'=>'btnSubmit',
			'value'=>'Submit',
			'caption'=>Yii::t('LookupModule.ui', 'Create'),
		));  ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->