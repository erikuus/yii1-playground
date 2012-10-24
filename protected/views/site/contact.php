<?php $this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui','Contact'); ?>

<h1><?php echo Yii::t('ui','Contact'); ?></h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="confirmation">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
	<?php echo Yii::t('ui','If you have questions, please fill out the following form to contact us. Thank you.'); ?>
</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="simple">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('style'=>'width:200px')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('style'=>'width:200px')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('style'=>'width:300px','maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="simple">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('style'=>'width:400px; height:100px')); ?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="complex">
		<span>
			<?php echo $form->labelEx($model,'verifyCode'); ?>
		</span>
		<div class="panel">
			<?php $this->widget('CCaptcha'); ?>
			<?php echo $form->textField($model,'verifyCode',array('style'=>'width:100px')); ?>
			<?php echo $form->error($model,'verifyCode'); ?>
			<p>
				<?php echo Yii::t('ui','Please enter the letters as they are shown in the image above.'); ?>
			</p>
		</div>
	</div>
	<?php endif; ?>

	<div class="action">
		<?php echo CHtml::submitButton(Yii::t('ui','Submit'), array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>