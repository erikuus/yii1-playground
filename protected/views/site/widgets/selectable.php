<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Selectable');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();

Yii::app()->clientScript->registerCss('selectable',"
#selectable {list-style-type: none; margin: 0; padding: 0; width: 60%;}
#selectable li {margin: 2px; padding: 4px; border: 1px solid #e3e3e3; background: #f7f7f7}
#selectable .ui-selecting { border: 1px solid #fad42e; }
#selectable .ui-selected { border: 1px solid #fad42e; background: #fcefa1;}
#select-result {margin: 0 0 10px 2px; }
", 'screen', CClientScript::POS_HEAD);
?>

<h2><?php echo Yii::t('ui','Selectable'); ?></h2>

<div id="select-result">none</div>

<?php
$this->widget('zii.widgets.jui.CJuiSelectable',array(
	'id'=>'selectable',
	'items'=>array(
		'id1'=>'Item 1',
		'id2'=>'Item 2',
		'id3'=>'Item 3'
	),
	'options'=>array(
		'stop'=>'js: function(event,ui){
			var result = $("#select-result").empty();
			$(".ui-selected", this).each(function(){
				var index = $("#selectable li").index(this);
				result.append(" #" + (index + 1));
			});
		}'
	)
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiSelectable',array(
	'id'=>'selectable',
	'items'=>array(
		'id1'=>'Item 1',
		'id2'=>'Item 2',
		'id3'=>'Item 3'
	),
	'options'=>array(
		'stop'=>'js: function(event,ui){
			var result = $("#select-result").empty();
			$(".ui-selected", this).each(function(){
				var index = $("#selectable li").index(this);
				result.append(" #" + (index + 1));
			});
		}'
	)
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/selectable/">http://jqueryui.com/demos/selectable/</a>