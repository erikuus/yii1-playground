<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Lang menu');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','Lang menu');?></h2>

<h3><?php echo Yii::t('ui','Ex 1: Text-only');?></h3>

<?php $this->widget('ext.components.language.XLangMenu', array(
	'items'=>array('et'=>'Eesti','en'=>'In English'),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.components.language.XLangMenu', array(
	'items'=>array('et'=>'Eesti','en'=>'In English'),
));
<?php $this->endWidget(); ?>
</div>

<br /><br />

<h3><?php echo Yii::t('ui','Ex 2: Text-only & show active');?></h3>

<?php $this->widget('ext.components.language.XLangMenu', array(
	'items'=>array('et'=>'Eesti','en'=>'In English'),
	'hideActive'=>false,
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.components.language.XLangMenu', array(
	'items'=>array('et'=>'Eesti','en'=>'In English'),
	'hideActive'=>false,
));
<?php $this->endWidget(); ?>
</div>

<br /><br />

<h3><?php echo Yii::t('ui','Ex 3: Icons before');?></h3>

<?php $this->widget('ext.components.language.XLangMenu', array(
	'encodeLabel'=>false,
	'items'=>array(
		'et'=>XHtml::imageLabel('et.png','Eesti'),
		'en'=>XHtml::imageLabel('en.png','In English')
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.components.language.XLangMenu', array(
	'encodeLabel'=>false,
	'items'=>array(
		'et'=>XHtml::imageLabel('et.png','Eesti'),
		'en'=>XHtml::imageLabel('en.png','In English')
	),
));
<?php $this->endWidget(); ?>
</div>

<br /><br />

<h3><?php echo Yii::t('ui','Ex 4: Icons after & show active');?></h3>

<?php $this->widget('ext.components.language.XLangMenu', array(
	'encodeLabel'=>false,
	'hideActive'=>false,
	'items'=>array(
		'et'=>XHtml::imageLabel('et.png','Eesti',true),
		'en'=>XHtml::imageLabel('en.png','In English',true)
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.components.language.XLangMenu', array(
	'encodeLabel'=>false,
	'hideActive'=>false,
	'items'=>array(
		'et'=>XHtml::imageLabel('et.png','Eesti',true),
		'en'=>XHtml::imageLabel('en.png','In English',true)
	),
));
<?php $this->endWidget(); ?>
</div>