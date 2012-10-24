<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'List Builder');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','List Builder'); ?></h2>

<div class="form">

<?php  if(Yii::app()->user->hasFlash('saved')): ?>
	<div class="confirmation">
		<?php echo Yii::app()->user->getFlash('saved'); ?>
	</div>
<?php endif;?>

<?php echo CHtml::beginForm($this->createUrl('movePersons')); ?>
<?php $this->widget('ext.widgets.multiselects.XMultiSelects',array(
	'leftTitle'=>'Australia',
	'leftName'=>'Person[australia][]',
	'leftList'=>Person::model()->findUsersByCountry(14),
	'rightTitle'=>'New Zealand',
	'rightName'=>'Person[newzealand][]',
	'rightList'=>Person::model()->findUsersByCountry(158),
	'size'=>20,
	'width'=>'200px',
));?>
<br />
<?php echo CHtml::submitButton(Yii::t('ui', 'Save'), array('class'=>'btn btn-primary')); ?>&nbsp;
<?php echo Yii::t('ui','NB! Access restricted by IP');?>
<?php echo CHtml::endForm(); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.multiselects.XMultiSelects',array(
	'leftTitle'=>'Australia',
	'leftName'=>'Person[australia][]',
	'leftList'=>Person::model()->findUsersByCountry(14),
	'rightTitle'=>'New Zealand',
	'rightName'=>'Person[newzealand][]',
	'rightList'=>Person::model()->findUsersByCountry(158),
	'size'=>20,
	'width'=>'200px',
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/SiteController.php: public function actionMovePersons()
protected/models/Person.php
</pre></div>

</div><!-- form -->