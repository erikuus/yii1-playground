<div class="simple">
	<?php echo CHtml::activeLabelEx($model,"firstname"); ?>
	<?php echo CHtml::activeTextField($model,"[$index]firstname"); ?>
	<?php echo CHtml::error($model,"[$index]firstname"); ?>
</div>

<div class="simple">
	<?php echo CHtml::activeLabelEx($model,"lastname"); ?>
	<?php echo CHtml::activeTextField($model,"[$index]lastname"); ?>
	<?php echo CHtml::error($model,"[$index]lastname"); ?>
</div>

<div class="simple">
	<?php echo CHtml::activeLabelEx($model,"eyecolor_code"); ?>
	<?php echo CHtml::activeDropDownList($model,"[$index]eyecolor_code", Lookup::items('eyecolor')); ?>
	<?php echo CHtml::error($model,"[$index]eyecolor_code"); ?>
</div>