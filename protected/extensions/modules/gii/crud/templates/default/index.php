<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', '{$this->pluralize($this->class2name($this->modelClass))}');\n"; ?>

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('ui','$label'),
);\n";
?>

$this->menu=array(
	array('label'=>Yii::t('ui', 'New'), 'url'=>array('create')),
	array('label'=>Yii::t('ui', 'Manage'), 'url'=>array('admin')),
);
?>

<h2><?php echo "<?php echo Yii::t('ui', '$label'); ?>" ; ?></h2>

<?php echo "<?php"; ?> $this->widget('ext.widgets.amenu.XActionMenu', array(
	'items'=>$this->menu,
)); ?>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
