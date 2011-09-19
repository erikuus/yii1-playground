<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Update {$this->modelClass}');\n"; ?>

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('ui','$label')=>array('index'),
	\$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	Yii::t('ui','Update'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('ui', 'List'), 'url'=>array('index')),
	array('label'=>Yii::t('ui', 'New'), 'url'=>array('create')),
	array('label'=>Yii::t('ui', 'View'), 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label'=>Yii::t('ui', 'Manage'), 'url'=>array('admin')),
);
?>

<h2><?php echo "<?php echo Yii::t('ui', 'Update {$this->modelClass}'); ?>" ; ?></h2>

<?php echo "<?php"; ?> $this->widget('ext.widgets.amenu.XActionMenu', array(
	'items'=>$this->menu,
)); ?>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>