<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Charts');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui', 'Charts'); ?></h2>
<h3><?php echo Yii::t('ui', 'Pie Chart'); ?></h3>

<?php
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'pie',
	'title'=>'Browser market 2008',
	'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	'size'=>array(400,300), // width and height of the chart image
	'color'=>array('6f8a09', '3285ce','dddddd'), // if there are fewer color than slices, then colors are interpolated.
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'pie',
	'title'=>'Browser market 2008',
	'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	'size'=>array(400,300), // width and height of the chart image
	'color'=>array('6f8a09', '3285ce','dddddd'), // if there are fewer color than slices, then colors are interpolated.
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui', 'Vertical Bar Chart'); ?></h3>

<?php
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'bar-vertical',
	'title'=>'Browser market January  2008',
	'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	'size'=>array(400,260),
	'barsSize'=>array('a'), // automatically resize bars to fit the space available
	'color'=>array('3285ce'),
	'axes'=>array('x','y'), // axes to show
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'bar-vertical',
	'title'=>'Browser market January  2008',
	'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	'size'=>array(400,260),
	'barsSize'=>array('a'), // automatically resize bars to fit the space available
	'color'=>array('3285ce'),
	'axes'=>array('x','y'), // axes to show
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui', 'Horizontal Bar Chart'); ?></h3>

<?php
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'bar-horizontal',
	'title'=>'Browser market February  2008',
	'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	'size'=>array(400,200),
	'barsSize'=>array('a'),
	'color'=>array('3285ce'),
	'axes'=>array(
		'x'=>array(0,20,40,60,80,100),
		'y'=>array('Opera','Safari','Mozilla','Firefox','IE5','IE6','IE7'),
	),
));
?>

<div class="tpanel">
<div class="toggle">
<?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'bar-horizontal',
	'title'=>'Browser market February  2008',
	'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	'size'=>array(400,200),
	'barsSize'=>array('a'),
	'color'=>array('3285ce'),
	'axes'=>array(
		'x'=>array(0,20,40,60,80,100),
		'y'=>array('Opera','Safari','Mozilla','Firefox','IE5','IE6','IE7'),
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui', 'Vertical Grouped Bar Chart'); ?></h3>

<?php
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'bar-vertical',
	'title'=>'Browser market 2008',
	'data'=>array(
		'February 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
		'January 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	),
	'size'=>array(550,300),
	'color'=>array('c93404','3285ce'),
	'axes'=>array('x','y'),
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'bar-vertical',
	'title'=>'Browser market 2008',
	'data'=>array(
		'February 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
		'January 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	),
	'size'=>array(550,300),
	'color'=>array('c93404','3285ce'),
	'axes'=>array('x','y'),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui', 'Vertical Stacked Bar Chart'); ?></h3>

<?php
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'stacked-bar-vertical',
	'title'=>'Browser market 2008',
	'data'=>array(
		'February 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
		'January 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	),
	'size'=>array(500,200),
	'barsSize'=>array(40,10), // bar width and space between bars
	'color'=>array('6f8a09', '3285ce'),
	'axes'=>array('x','y'),
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'stacked-bar-vertical',
	'title'=>'Browser market 2008',
	'data'=>array(
		'February 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
		'January 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
	),
	'size'=>array(500,200),
	'barsSize'=>array(40,10), // bar width and space between bars
	'color'=>array('6f8a09', '3285ce'),
	'axes'=>array('x','y'),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui', 'Line Chart'); ?></h3>

<?php
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'line',
	'title'=>'Browser market 2008',
	'data'=> array(
		'2007'=>array('Jan'=>61.0,'Feb'=>51.2,'Mar'=>61.8,'Apr'=>42.9,'May'=>33.7,'June'=>34.0,'July'=>34.5,'August'=>34.9,'Sept'=>45.4,'Oct'=>46.0,'Nov'=>46.3,'Dec'=>46.3),
		'2006'=>array('Jan'=>35.0,'Feb'=>34.5,'Mar'=>44.5,'Apr'=>32.9,'May'=>22.9,'June'=>25.5,'July'=>25.5,'August'=>24.9,'Sept'=>37.3,'Oct'=>37.3,'Nov'=>39.9,'Dec'=>39.9),
		'2005'=>array('Jan'=>15.0,'Feb'=>14.5,'Mar'=>24.5,'Apr'=>22.9,'May'=>12.9,'June'=>15.5,'July'=>15.5,'August'=>14.9,'Sept'=>17.3,'Oct'=>27.3,'Nov'=>29.9,'Dec'=>29.9)
	),
	'size'=>array(550,200),
	'color'=>array('c93404','6f8a09','3285ce'),
	'fill'=>array('f8d4c8','d4e1a5'),
	'gridSize'=>array(9,20), // x-axis and y-axis step of the grid
	'gridStyle'=>'light', // optional: light or solid
	'axes'=>array('x','y'),
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleChart',array(
	'type'=>'line',
	'title'=>'Browser market 2008',
	'data'=> array(
		'2007'=>array('Jan'=>61.0,'Feb'=>51.2,'Mar'=>61.8,'Apr'=>42.9,'May'=>33.7,'June'=>34.0,'July'=>34.5,'August'=>34.9,'Sept'=>45.4,'Oct'=>46.0,'Nov'=>46.3,'Dec'=>46.3),
		'2006'=>array('Jan'=>35.0,'Feb'=>34.5,'Mar'=>44.5,'Apr'=>32.9,'May'=>22.9,'June'=>25.5,'July'=>25.5,'August'=>24.9,'Sept'=>37.3,'Oct'=>37.3,'Nov'=>39.9,'Dec'=>39.9),
		'2005'=>array('Jan'=>15.0,'Feb'=>14.5,'Mar'=>24.5,'Apr'=>22.9,'May'=>12.9,'June'=>15.5,'July'=>15.5,'August'=>14.9,'Sept'=>17.3,'Oct'=>27.3,'Nov'=>29.9,'Dec'=>29.9)
	),
	'size'=>array(550,200),
	'color'=>array('c93404','6f8a09','3285ce'),
	'fill'=>array('f8d4c8','d4e1a5'),
	'gridSize'=>array(9,20), // x-axis and y-axis step of the grid
	'gridStyle'=>'light', // optional: light or solid
	'axes'=>array('x','y'),
));
<?php $this->endWidget(); ?>
</div>