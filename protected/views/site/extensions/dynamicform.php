<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Dynamic Form');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.ExtensionMenu']=array();

$model=new Person;
//$model->selectOption=Person::SELECT_COUNTRY;
$model2=new Person2;
$model2->selectOption=Person::SELECT_EYECOLOR;
?>

<h2><?php echo Yii::t('ui','Dynamic Form');?></h2>

<h3><?php echo Yii::t('ui','Checkbox panels'); ?></h3>

<div class="form" style="width:auto">

<?php $form=$this->beginWidget('ext.widgets.form.XDynamicForm', array(
	'id'=>'dynamic-form-checkbox'
)); ?>

	<?php $checkBox=$form->explodeCheckBoxList($model, 'selectOption', $model->selectOptions);?>
	<div class="complex">
		<span class="label">
			<?php echo Yii::t('ui','Select'); ?>
		</span>
		<div class="panel">
			<?php $form->beginDynamicArea($checkBox[Person::SELECT_COUNTRY])?>
				<div class="complex">
					<span class="label">
						<?php echo Yii::t('ui','Country'); ?>
					</span>
					<div class="panel">
						<?php echo $form->DropDownList($model,'country_id',Country::model()->options,array('prompt'=>''));?>
						<?php echo $form->error($model,'country_id'); ?>
					</div>
				</div>
			<?php $form->endDynamicArea()?>
			<?php $form->beginDynamicArea($checkBox[Person::SELECT_EYECOLOR])?>
				<div class="complex">
					<span class="label">
						<?php echo Yii::t('ui','Eyecolor'); ?>
					</span>
					<div class="panel">
						<?php echo $form->radioButtonList($model,'eyecolor_code',Lookup::items('eyecolor')); ?>
						<?php echo $form->error($model,'eyecolor_code'); ?>
					</div>
				</div>
			<?php $form->endDynamicArea()?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<br />

<h3><?php echo Yii::t('ui','Radio panels'); ?></h3>

<div class="form" style="width:auto">

<?php $form=$this->beginWidget('ext.widgets.form.XDynamicForm', array(
	'id'=>'dynamic-form-radio',
	'containerCssClass'=>'xpanel',
	'contentCssClass'=>'xpanelContent'
)); ?>

	<?php $radioButton=$form->explodeRadioButtonList($model2, 'selectOption', $model->selectOptions);?>

	<div class="complex">
		<span class="label">
			<?php echo Yii::t('ui','Select'); ?>
		</span>
		<div class="panel">
			<?php $form->beginDynamicArea($radioButton[Person::SELECT_COUNTRY])?>
				<?php echo $form->DropDownList($model2,'country_id',Country::model()->options,array('prompt'=>''));?>
				<?php echo $form->error($model2,'country_id'); ?>
			<?php $form->endDynamicArea()?>
			<?php $form->beginDynamicArea($radioButton[Person::SELECT_EYECOLOR])?>
				<div class="complex">
					<span class="label">
						<?php echo Yii::t('ui','Eyecolor'); ?>
					</span>
					<div class="panel">
						<?php echo $form->radioButtonList($model2,'eyecolor_code',Lookup::items('eyecolor')); ?>
						<?php echo $form->error($model2,'eyecolor_code'); ?>
					</div>
				</div>
			<?php $form->endDynamicArea()?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<br />

<h3><?php echo Yii::t('ui','Dropdown panels'); ?></h3>

<div class="form" style="width:auto">

<?php $form=$this->beginWidget('ext.widgets.form.XDynamicForm', array(
	'id'=>'dynamic-form-dropdown',
	'enableRadioToggle'=>false,
	'enableChecboxToggle'=>false
)); ?>

	<div class="action">
		<?php echo $form->DynamicDropDownList($model2, 'selectOption', $model->selectOptions);?>
	</div>

	<?php $form->beginDynamicAreaDDL($model2, 'selectOption', Person::SELECT_COUNTRY); ?>
	<div class="complex">
		<span class="label">
			<?php echo Yii::t('ui','Country'); ?>
		</span>
		<div class="panel">
			<?php echo $form->DropDownList($model,'country_id',Country::model()->options, array('prompt'=>''));?>
			<?php echo $form->error($model,'country_id'); ?>
		</div>
	</div>
	<?php $form->endDynamicAreaDDL(); ?>

	<?php $form->beginDynamicAreaDDL($model2, 'selectOption', Person::SELECT_EYECOLOR); ?>
	<div class="complex">
		<span class="label">
			<?php echo Yii::t('ui','Eyecolor'); ?>
		</span>
		<div class="panel">
			<?php echo $form->radioButtonList($model2,'eyecolor_code', Lookup::items('eyecolor')); ?>
			<?php echo $form->error($model2,'eyecolor_code'); ?>
		</div>
	</div>
	<?php $form->endDynamicAreaDDL(); ?>


<?php $this->endWidget(); ?>

</div><!-- form -->

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
/protected/extensions/widgets/form/XDynamicForm.php
</pre></div>