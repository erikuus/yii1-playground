<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'person-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p><?php echo Yii::t('ui', 'Fields with {mark} are required',
	array('{mark}'=>'<span class="required">*</span>')); ?>
</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="simple">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>40,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>40,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'birthyear'); ?>
		<?php echo $form->textField($model,'birthyear',array('size'=>6,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'birthyear'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>40,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'webpage'); ?>
		<?php echo $form->textField($model,'webpage',array('size'=>40,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'webpage'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->DropDownList($model,'country_id',Country::model()->options,array('prompt'=>''));?>
		<?php echo $form->error($model,'country_id'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'eyecolor_code'); ?>
		<?php echo $form->dropDownList($model,'eyecolor_code',Lookup::items('eyecolor'),array('prompt'=>''));?>
		<?php echo $form->error($model,'eyecolor_code'); ?>
	</div>

	<div class="action">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('ui', 'Create') : Yii::t('ui','Save'),array('class'=>'btn btn-primary')); ?>
		<?php echo CHtml::link(Yii::t('ui', 'Cancel'), $model->isNewRecord ? array('admin') : $this->getReturnUrl(), array('class'=>'btn')) ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->