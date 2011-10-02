<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui','Helps') .' - '.Yii::t('ui', 'Imported functions');
$this->layout='leftbar';
$this->leftPortlets['ptl.ModuleMenu']=array();
?>

<h2><?php echo Yii::t('ui','Helps') .' - '.Yii::t('ui', 'Imported functions');?></h2>

<h3><?php echo Yii::t('ui','Display text');?></h3>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
echo Help::item('annotation','title');
echo Help::item('annotation','content');
<?php $this->endWidget(); ?>

<?php echo Help::item('annotation','title'); ?><br>
<?php echo Help::item('annotation','content'); ?>

<h3 style="margin-top:30px"><?php echo Yii::t('ui','Popup text (for xwebapp sceleton only)');?></h3>

<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
echo CHtml::link(
	Yii::t('ui','Explain something'),
	array('/help/default/view','code'=>'explain_something'),
	array('class'=>'openhelp')
);
echo XHtml::imageLink(
	'hint.png',
	array('/help/default/view','code'=>'explain_something_else'),
	array('class'=>'openhelp','title'=>Yii::t('ui','Help'))
);
<?php $this->endWidget(); ?>

<?php echo CHtml::link(
	Yii::t('ui','Help'),
	array('/help/default/view','code'=>'explain_something'),
	array('class'=>'openhelp')
); ?>

<?php echo XHtml::imageLink(
	'hint.png',
	array('/help/default/view','code'=>'explain_something_else'),
	array('class'=>'openhelp','title'=>Yii::t('ui','Help'))
); ?>