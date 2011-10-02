&nbsp;
<?php echo Yii::t('ui','Search'); ?>
<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	'name'=>'suggest_hierarchy',
	'source'=>$this->createUrl('suggestHierarchy'),
	'options'=>array(
		'select'=>"js:function(event, ui) {
			window.location.href = '?id='+ui.item.id;
		}"
	),
	'htmlOptions'=>array(
		'class'=>'autocomplete',
		'style'=>'width:200px'
	),
)); ?>