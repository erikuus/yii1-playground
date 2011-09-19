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
	array('label'=>Yii::t('ui', 'Manage'),'url'=>array('admin'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>Yii::t('ui', 'New'),'url'=>$this->createReturnableUrl('create',array('id'=>$model->id)),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>Yii::t('ui', 'Menu'),'url'=>array('indexMenu')),
);
?>

<h2><?php echo "<?php echo Yii::t('ui', '$label'); ?>" ; ?></h2>

<div class="actionMenu">
	<?php echo "<?php"; ?> $this->renderPartial('_jump'); ?>
	<?php echo "<?php"; ?> $this->widget('ext.widgets.amenu.XActionMenu', array(
		'items'=>$this->menu,
		'htmlOptions'=>array('style'=>'display:inline;'),
	)); ?>
</div>

<div class="breadcrumbs">
	<?php echo "<?php"; ?> echo $model->breadcrumbs; ?>
</div><!-- breadcrumbs -->
	
<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'summaryText'=>false,
	'itemView'=>'_view',
)); ?>
