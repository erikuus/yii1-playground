<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui','Form design') .' - '.Yii::t('ui', 'Complex dynamic rows');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();

$cs=Yii::app()->clientScript;
$cs->registerScriptFile(XHtml::jsUrl('jquery.calculation.min.js'), CClientScript::POS_HEAD);
$cs->registerScriptFile(XHtml::jsUrl('jquery.format.js'), CClientScript::POS_HEAD);
$cs->registerScriptFile(XHtml::jsUrl('template.js'), CClientScript::POS_HEAD);

// Demo objects
$model=new DummyForm;
$persons=array();
?>

<h2><?php echo Yii::t('ui','Form design') . ' - ' . Yii::t('ui','Complex dynamic rows'); ?></h2>

<p><?php echo Yii::t('ui','Not really an extension, but simple jquery trick based on HTML layout.'); ?></p>

<div class="form" style="width: 720px">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'design-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p><?php echo Yii::t('ui', 'Fields with {mark} are required',
	array('{mark}'=>'<span class="required">*</span>')); ?></p>

	<div class="complex">
		<span class="label">
			<?php echo Yii::t('ui', 'Persons'); ?>
		</span>
		<div class="panel">
			<table class="templateFrame grid" cellspacing="0">
				<thead class="templateHead">
					<tr >
						<td>
							<?php echo $form->labelEx(Person::model(),'firstname');?>
						</td>
						<td>
							<?php echo $form->labelEx(Person::model(),'lastname');?>
						</td>
						<td colspan="2">
							<?php echo $form->labelEx(Person::model(),'eyecolor_code');?>
						</td>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="4">
							<div class="add"><?php echo Yii::t('ui','New');?></div>
							<textarea class="template" rows="0" cols="0">
								<tr class="templateContent">
									<td>
										<?php echo CHtml::textField('Person[{0}][firstname]','',array('style'=>'width:100px')); ?>
									</td>
									<td>
										<?php echo CHtml::textField('Person[{0}][lastname]','',array('style'=>'width:100px')); ?>
									</td>
									<td>
										<?php echo CHtml::dropDownList('Person[{0}][eyecolor_code]','',Lookup::items('eyecolor'),array('style'=>'width:100px','prompt'=>'')); ?>
									</td>
									<td>
										<input type="hidden" class="rowIndex" value="{0}" />
										<div class="remove"><?php echo Yii::t('ui','Remove');?></div>
									</td>
								</tr>
							</textarea>
						</td>
					</tr>
				</tfoot>
				<tbody class="templateTarget">
				<?php foreach($persons as $i=>$person): ?>
					<tr class="templateContent">
						<td>
							<?php echo $form->textField($person,"[$i]firstname",array('style'=>'width:100px')); ?>
						</td>
						<td>
							<?php echo $form->textField($person,"[$i]lastname",array('style'=>'width:100px')); ?>
						</td>
						<td>
							<?php echo $form->dropDownList($person,"[$i]eyecolor_code",Lookup::items('eyecolor'),array('style'=>'width:100px','prompt'=>'')); ?>
						</td>
						<td>
							<input type="hidden" class="rowIndex" value="<?php echo $i;?>" />
							<div class="remove"><?php echo Yii::t('ui','Remove');?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div><!--panel-->
	</div><!--complex-->
	<div class="action">
		<?php echo CHtml::submitButton(Yii::t('ui','Submit')); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<pre><?php if(isset($_POST) && $_POST!==array()) print_r($_POST);?></pre>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
	<div class="complex">
		<span class="label">
			<?php echo '<?php'; ?> echo Yii::t('ui', 'Persons'); ?>
		</span>
		<div class="panel">
			<table class="templateFrame grid" cellspacing="0">
				<thead class="templateHead">
					<tr>
						<td>
							<?php echo '<?php'; ?> echo $form->labelEx(Person::model(),'firstname');?>
						</td>
						<td>
							<?php echo '<?php'; ?> echo $form->labelEx(Person::model(),'lastname');?>
						</td>
						<td colspan="2">
							<?php echo '<?php'; ?> echo $form->labelEx(Person::model(),'eyecolor_code');?>
						</td>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="4">
							<div class="add"><?php echo '<?php'; ?> echo Yii::t('ui','New');?></div>
							<textarea class="template" rows="0" cols="0">
								<tr class="templateContent">
									<td>
										<?php echo '<?php'; ?> echo CHtml::textField('Person[{0}][firstname]','',array('style'=>'width:100px')); ?>
									</td>
									<td>
										<?php echo '<?php'; ?> echo CHtml::textField('Person[{0}][lastname]','',array('style'=>'width:100px')); ?>
									</td>
									<td>
										<?php echo '<?php'; ?> echo CHtml::dropDownList('Person[{0}][eyecolor_code]','',Lookup::items('eyecolor'),array('style'=>'width:100px','prompt'=>'')); ?>
									</td>
									<td>
										<div class="remove"><?php echo '<?php'; ?> echo Yii::t('ui','Remove');?></div>
										<input type="hidden" class="rowIndex" value="{0}" />
									</td>
								</tr>
							</textarea>
						</td>
					</tr>
				</tfoot>
				<tbody class="templateTarget">
				<?php echo '<?php'; ?> foreach($persons as $i=>$person): ?>
					<tr class="templateContent">
						<td>
							<?php echo '<?php'; ?> echo $form->textField($person,"[$i]firstname",array('style'=>'width:100px')); ?>
						</td>
						<td>
							<?php echo '<?php'; ?> echo $form->textField($person,"[$i]lastname",array('style'=>'width:100px')); ?>
						</td>
						<td>
							<?php echo '<?php'; ?> echo $form->dropDownList($person,"[$i]eyecolor_code",Lookup::items('eyecolor'),array('style'=>'width:100px','prompt'=>'')); ?>
						</td>
						<td>
							<div class="remove"><?php echo '<?php'; ?> echo Yii::t('ui','Remove');?>
						</td>
					</tr>
				<?php echo '<?php'; ?> endforeach; ?>
				</tbody>
			</table>
		</div><!--panel-->
	</div><!--complex-->
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
js/jquery.format.js
js/template.js
</pre></div>