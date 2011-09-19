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
	Yii::t('ui','$label')=>array('index'),
	Yii::t('ui','Manage'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('ui', 'List'), 'url'=>array('index')),
	array('label'=>Yii::t('ui', 'New'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<h2><?php echo "<?php echo Yii::t('ui', 'Manage {$this->pluralize($this->class2name($this->modelClass))}'); ?>"; ?></h2>

<?php echo "<?php"; ?> $this->widget('ext.widgets.amenu.XActionMenu', array(
	'items'=>$this->menu,
)); ?>


<div class="tpanel">
	<div class="toggle"><?php echo "<?php echo Yii::t('ui', 'Search'); ?>"; ?></div>
	<div class="search-form">	
	<?php echo "<?php \$this->renderPartial('_search',array(
		'model'=>\$model,
	)); ?>\n"; ?>
	</div>
</div><!-- tpanel -->

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
			'deleteConfirmation'=>Yii::t('ui','Are you sure to delete this item?'),
		),
	),
)); ?>
