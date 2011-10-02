<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Star rating');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Star rating');?></h2>
<h3><?php echo Yii::t('ui','Form input');?></h3>

<?php $this->widget('CStarRating',array(
	//'model'=>$model,
	//'attribute'=>'',
	'name'=>'rating1',
	'value'=>3,
)); ?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CStarRating',array(
	//'model'=>$model,
	//'attribute'=>'rating',
	'name'=>'rating1',
	'value'=>3,
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read only');?></h3>

<?php $this->widget('CStarRating',array(
	'name'=>'rating2',
	'value'=>5,
	'readOnly'=>true,
)); ?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CStarRating',array(
	'name'=>'rating2',
	'value'=>5,
	'readOnly'=>true,
));
<?php $this->endWidget(); ?>
</div>