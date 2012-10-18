<div class="item">

	<h3><?php echo CHtml::link($data->fullname,$this->createReturnableUrl('view',array('id'=>$data->id)));?></h3>

	<b><?php echo CHtml::encode($data->getAttributeLabel('birthyear')); ?>:</b>
	<?php echo CHtml::encode($data->birthyear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo Yii::app()->format->formatEmail($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('webpage')); ?>:</b>
	<?php echo Yii::app()->format->formatUrl($data->webpage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country_id')); ?>:</b>
	<?php echo CHtml::encode($data->country->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eyecolor_code')); ?>:</b>
	<?php echo Lookup::item('eyecolor',$data->eyecolor_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registered')); ?>:</b>
	<?php echo CHtml::encode($data->registered); ?>
	<br />

</div>