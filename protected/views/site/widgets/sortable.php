<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Sortable');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();

Yii::app()->clientScript->registerCss('sortable', "
#sortable {list-style-type: none; margin: 0; padding: 0; width: 60%;}
#sortable li {margin: 2px; padding: 4px; border: 1px solid #e3e3e3; background: #f7f7f7}
", 'screen', CClientScript::POS_HEAD);
?>

<h2><?php echo Yii::t('ui','Sortable');?></h2>

<?php $this->widget('zii.widgets.jui.CJuiSortable', array(
	'id'=>'sortable',
	'items'=>array(
		'id1'=>'Item 1',
		'id2'=>'Item 2',
		'id3'=>'Item 3',
	),
	'options'=>array(
		'cursor'=>'n-resize',
	),
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiSortable', array(
	'id'=>'sortable',
	'items'=>array(
		'id1'=>'Item 1',
		'id2'=>'Item 2',
		'id3'=>'Item 3',
	),
	'options'=>array(
		'cursor'=>'n-resize',
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/sortable/">http://jqueryui.com/demos/sortable/</a>