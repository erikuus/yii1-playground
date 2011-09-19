<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Manage {$this->pluralize($this->class2name($this->modelClass))}');\n"; ?>

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('ui', 'Manage {$this->pluralize($this->class2name($this->modelClass))}'),
);\n";
?>
?>

<h2><?php echo "<?php echo Yii::t('ui', 'Manage {$this->pluralize($this->class2name($this->modelClass))}'); ?>"; ?></h2>

<div class="actionMenu">
<?php echo "<?php echo CHtml::link(Yii::t('ui', 'New'),array('create')); ?>\n"; ?>
</div>

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
	echo "\t\t'".$column->name."',\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'$this->grid->controller->createReturnableUrl("update",array("id"=>$data->primaryKey))',
			'deleteButtonUrl'=>'$this->grid->controller->createReturnableUrl("delete",array("id"=>$data->primaryKey))',
			'deleteConfirmation'=>Yii::t('ui','Are you sure to delete this item?'),
		),
	),
)); ?>
