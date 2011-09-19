<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="item">

<?php
echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('id')); ?>:</b>\n";
echo "\t<?php echo CHtml::link(CHtml::encode(\$data->id), \$this->createReturnableUrl('view',array('id'=>\$data->id))); ?>\n\t<br />\n\n";
echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('parent_id')); ?>:</b>\n";
echo "\t<?php echo CHtml::link(CHtml::encode(\$data->parent_id), array('index', 'id'=>\$data->id)); ?>\n\t<br />\n\n";

$count=0;
foreach($this->tableSchema->columns as $column)
{
	if($column->name=='id' || $column->name=='parent_id')
		continue;
	if(++$count==7)
		echo "\t<?php /*\n";
	echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";
	echo "\t<?php echo CHtml::encode(\$data->{$column->name}); ?>\n\t<br />\n\n";
}
if($count>=7)
	echo "\t*/ ?>\n";
?>

</div>