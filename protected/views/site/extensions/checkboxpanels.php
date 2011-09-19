<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Checkbox panels');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.ExtensionMenu']=array();
$model=Person::model()->findbyPk(1);
?>

<h2><?php echo Yii::t('ui','Checkbox panels');?></h2>

<p><?php echo Yii::t('ui','Not really an extension, but simple jquery trick based on HTML layout.'); ?></p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'person-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p><?php echo Yii::t('ui', 'Fields with {mark} are required', 
	array('{mark}'=>'<span class="required">*</span>')); ?>
	</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="cpanel">
	
		<?php echo CHtml::checkBox('g1', true, array('id'=>'group1')); ?>
		<?php echo CHtml::label(Yii::t('ui','Group A'),'group1'); ?>
	
		<div class="cpanelContent">

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

		</div><!-- cpanelContent -->

	</div><!-- cpanel -->

	<div class="cpanel">
	
		<?php echo CHtml::checkBox('g2', false, array('id'=>'group2')); ?>
		<?php echo CHtml::label(Yii::t('ui','Group B'),'group2'); ?>
		
		<div class="cpanelContent">

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
	
		</div><!-- cpanelContent -->

	</div><!-- cpanel -->

	<div class="action">
		<?php //echo CHtml::submitButton($model->isNewRecord ? Yii::t('ui', 'Create') : Yii::t('ui','Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="tpanel">
	<div class="toggle"><?php echo Yii::t('ui','View code');?></div>
	<div>
		<?php $this->beginWidget('CTextHighlighter',array('language'=>'HTML')); ?>
		<div class="cpanel">
			<input type="checkbox"><label>Label</label>
			<div class="cpanelContent">
			...
			</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
js/common.js
</pre></div>
