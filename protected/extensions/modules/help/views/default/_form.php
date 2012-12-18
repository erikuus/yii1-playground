<div class="form" style="width: 700px">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'help-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p><?php echo Yii::t('HelpModule.ui', 'Fields with {mark} are required',
	array('{mark}'=>'<span class="required">*</span>')); ?>
</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="complex">
		<table class="grid" cellpadding="5" cellspacing="0">
			<?php if(Yii::app()->user->name=='admin'): ?>
			<tr>
				<td>
					<?php echo $form->labelEx($model,'code'); ?>
					<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64)); ?>
					<?php echo $form->error($model,'code'); ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td>
					<?php echo $form->labelEx($model,'title_et'); ?>
					<?php echo $form->textField($model,'title_et',array('size'=>60,'maxlength'=>256)); ?>
					<?php echo $form->error($model,'title_et'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($model,'content_et'); ?>
					<?php $this->widget('ext.widgets.xheditor.XHeditor',array(
						'model'=>$model,
						'modelAttribute'=>'content_et',
						'config'=>array(
							'id'=>'Help_content_et',
							'loadCSS'=>Yii::app()->baseUrl.'/css/'.Yii::app()->controller->module->editorCSS,
							'tools'=>Yii::app()->controller->module->editorTools,
							'width'=>'690px',
							'height'=>'400px',
							'upImgUrl'=>Yii::app()->controller->module->editorUploadRoute ? Yii::app()->controller->createUrl(Yii::app()->controller->module->editorUploadRoute) : null,
							'upImgExt'=>'jpg,jpeg,gif,png',
						)
					));?>
					<?php echo $form->error($model,'content_et'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($model,'title_en'); ?>
					<?php echo $form->textField($model,'title_en',array('size'=>60,'maxlength'=>256)); ?>
					<?php echo $form->error($model,'title_en'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($model,'content_en'); ?>
					<?php $this->widget('ext.widgets.xheditor.XHeditor',array(
						'model'=>$model,
						'modelAttribute'=>'content_en',
						'config'=>array(
							'id'=>'Help_content_en',
							'loadCSS'=>Yii::app()->baseUrl.'/css/'.Yii::app()->controller->module->editorCSS,
							'tools'=>Yii::app()->controller->module->editorTools,
							'width'=>'690px',
							'height'=>'400px',
							'upImgUrl'=>Yii::app()->controller->module->editorUploadRoute ? Yii::app()->controller->createUrl(Yii::app()->controller->module->editorUploadRoute) : null,
							'upImgExt'=>'jpg,jpeg,gif,png',
						)
					));?>
					<?php echo $form->error($model,'content_en'); ?>
				</td>
			</tr>
		</table>
	</div><!--complex-->

	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
		'buttonType'=>'submit',
		'name'=>'btnSubmit',
		'value'=>'Submit',
		'caption'=>$model->isNewRecord ? Yii::t('HelpModule.ui', 'Create') : Yii::t('HelpModule.ui','Save'),
	));  ?>
	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
		'buttonType'=>'link',
		'name'=>'btnCancel',
		'value'=>'Cancel',
		'caption'=>Yii::t('HelpModule.ui', 'Cancel'),
		'url'=>$model->isNewRecord || !$this->getReturnUrl()  ? array('admin') : $this->getReturnUrl(),
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->