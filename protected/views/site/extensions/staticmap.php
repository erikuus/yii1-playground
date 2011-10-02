<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Static Google Map');
$this->layout = 'leftbar';
$this->leftPortlets['ptl.ExtensionMenu'] = array();
?>

<h2><?php echo Yii::t('ui','Static Google Map');?></h2>

<?php
$this->widget('ext.widgets.google.XGoogleStaticMap',array(
	'center'=>'58.613742,24.929102',
	'alt'=>"Map for location of something", // Alt text for image
	'zoom'=>7, // Google map zoom level
	'width'=>660, // image width
	'height'=>400, // image Height
	'markers'=>array(
		array(
			'style'=>array('color'=>'blue','label'=>'T'),
			'locations'=>array('58.37292,26.71326'),
		),
		array(
			'style'=>array('color'=>'green'),
			'locations'=>array('Tallinn, EST','Viljandi, EST'),
		),
	),
	'paths'=>array(
		array(
			'style'=>array('color'=>'blue','fillcolor'=>'yellow','weight'=>3),
			'locations'=>array('58.59,26.27','58.59,26.89','58.23,26.89','58.23,26.27','58.59,26.27'),
		),
		array(
			'style'=>array('color'=>'red','fillcolor'=>'yellow','weight'=>3),
			'locations'=>array('58.81,26.29','59.27,25.95','59.34,25.32','59.17,24.73','58.91,24.42','58.61,24.91','58.81,26.29'),
		),
	),
	'linkUrl'=>array('site/extensions', 'item'=>'maps'), // Where the image should link
	'linkOptions'=>array('target'=>'_blank'), // HTML options for link tag
	//'imageOptions'=>array('class'=>'map-image'), // HTML options for img tag
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.google.XGoogleStaticMap',array(
	'center'=>'58.613742,24.929102',
	'alt'=>"Map for location of something", // Alt text for image
	'zoom'=>7, // Google map zoom level
	'width'=>660, // image width
	'height'=>400, // image Height
	'markers'=>array(
		array(
			'style'=>array('color'=>'blue','label'=>'T'),
			'locations'=>array('58.37292,26.71326'),
		),
		array(
			'style'=>array('color'=>'green'),
			'locations'=>array('Tallinn, EST','Viljandi, EST'),
		),
	),
	'paths'=>array(
		array(
			'style'=>array('color'=>'red','fillcolor'=>'yellow','weight'=>3),
			'locations'=>array('58.59,26.27','58.59,26.89','58.23,26.89','58.23,26.27','58.59,26.27'),
		),
		array(
			'style'=>array('color'=>'red','fillcolor'=>'yellow','weight'=>3),
			'locations'=>array('58.81,26.29','59.27,25.95','59.34,25.32','59.17,24.73','58.91,24.42','58.61,24.91','58.81,26.29'),
		),
	),
	'linkUrl'=>array('site/extensions', 'item'=>'maps'), // Where the image should link
	'linkOptions'=>array('target'=>'_blank'), // HTML options for link tag
	//'imageOptions'=>array('class'=>'map-image'), // HTML options for img tag
));
<?php $this->endWidget(); ?>
</div>