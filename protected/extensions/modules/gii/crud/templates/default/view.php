<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'View {$this->modelClass}');\n"; ?>

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('ui','$label')=>array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('ui', 'List'), 'url'=>array('index')),
	array('label'=>Yii::t('ui', 'New'), 'url'=>array('create')),
	array('label'=>Yii::t('ui', 'Update'), 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>Yii::t('ui', 'Delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>Yii::t('ui','Are you sure to delete this item?'))),
	array('label'=>Yii::t('ui', 'Manage'), 'url'=>array('admin')),
);
?>

<h2><?php echo "<?php echo Yii::t('ui', 'View {$this->modelClass}'); ?>" ; ?></h2>

<?php echo "<?php"; ?> $this->widget('ext.widgets.amenu.XActionMenu', array(
	'items'=>$this->menu,
)); ?>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
