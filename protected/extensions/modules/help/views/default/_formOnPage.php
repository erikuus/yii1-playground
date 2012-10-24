<div class="form" style="width: auto">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'help-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p><?php echo Yii::t('HelpModule.ui', 'Fields with {mark} are required',
	array('{mark}'=>'<span class="required">*</span>')); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="complex">
		<table class="grid" cellpadding="5" cellspacing="0">
			<tr>
				<td>
					<?php echo $form->labelEx($model,$model->localizeAttribute('title')); ?>
					<?php echo $form->textField($model,$model->localizeAttribute('title'),array('size'=>60,'maxlength'=>256)); ?>
					<?php echo $form->error($model,$model->localizeAttribute('title')); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($model,$model->localizeAttribute('content')); ?>
					<?php $this->widget('ext.widgets.xheditor.XHeditor',array(
						'model'=>$model,
						'modelAttribute'=>$model->localizeAttribute('content'),
						'config'=>array(
							'id'=>'Help_content_et',
							'loadCSS'=>Yii::app()->baseUrl.'/css/'.Yii::app()->controller->module->editorCSS,
							'tools'=>Yii::app()->controller->module->editorTools,
							'width'=>'945px',
							'height'=>'500px',
							'upImgUrl'=>Yii::app()->controller->module->editorUploadRoute ? Yii::app()->controller->createUrl(Yii::app()->controller->module->editorUploadRoute) : null,
							'upImgExt'=>'jpg,jpeg,gif,png',
						)
					));?>
					<?php echo $form->error($model,$model->localizeAttribute('content')); ?>
				</td>
			</tr>
		</table>
	</div><!--complex-->

	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
		'buttonType'=>'submit',
		'name'=>'btnSubmit',
		'value'=>'Submit',
		'caption'=>Yii::t('HelpModule.ui','Save'),
	));  ?>

	<?php $this->widget('zii.widgets.jui.CJuiButton', array(
		'buttonType'=>'link',
		'name'=>'btnCancel',
		'value'=>'Cancel',
		'caption'=>Yii::t('HelpModule.ui', 'Cancel'),
		'url'=>!$this->getReturnUrl('/')  ? array('admin') : $this->getReturnUrl('/'),
	)); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->