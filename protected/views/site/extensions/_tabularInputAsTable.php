<td>
	<?php echo CHtml::activeTextField($model,"[$index]firstname"); ?>
	<?php echo CHtml::error($model,"[$index]firstname"); ?>
</td>
<td>
	<?php $this->widget('ext.widgets.autocomplete.XJuiAutoComplete', array(
		'model'=>$model,
		'attribute'=>"[$index]lastname",
		'source'=>$this->createUrl('request/suggestLastname'),

	)); ?>
	<?php echo CHtml::error($model,"[$index]lastname"); ?>
</td>
<td>
	<?php echo CHtml::activeDropDownList($model,"[$index]eyecolor_code", Lookup::items('eyecolor')); ?>
	<?php echo CHtml::error($model,"[$index]eyecolor_code"); ?>
</td>