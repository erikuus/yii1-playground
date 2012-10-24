<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Action menu');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','Action menu');?></h2>

<?php $this->widget('ext.widgets.amenu.XActionMenu', array(
	'htmlOptions'=>array('class'=>'actionMenu'),
	'items'=>array(
		array('label'=>Yii::t('ui','Home'), 'url'=>array('/site/index')),
		array('label'=>Yii::t('ui','Widgets'), 'url'=>array('/person/index')),
		array('label'=>Yii::t('ui', 'Extensions'), 'url'=>array('/site/extension','view'=>'dropdownmenu')),
		array('label'=>Yii::t('ui', 'Hello'), 'url'=>'#', 'linkOptions'=>array('onclick'=>'alert("Hello!");')),
		array('label'=>Yii::t('ui', 'Login'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
		array('label'=>Yii::t('ui', 'Logout'), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.amenu.XActionMenu', array(
	'htmlOptions'=>array('class'=>'actionBar'),
	'items'=>array(
		array('label'=>Yii::t('ui','Home'), 'url'=>array('/site/index')),
		array('label'=>Yii::t('ui','Widgets'), 'url'=>array('/person/index')),
		array('label'=>Yii::t('ui', 'Extensions'), 'url'=>array('/site/extension','view'=>'dropdownmenu')),
		array('label'=>Yii::t('ui', 'Hello'), 'url'=>'#', 'linkOptions'=>array('onclick'=>'alert("Hello!");')),
		array('label'=>Yii::t('ui', 'Login'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
		array('label'=>Yii::t('ui', 'Logout'), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
	),
));
<?php $this->endWidget(); ?>
</div>