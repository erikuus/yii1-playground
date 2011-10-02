<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Menus');

$this->breadcrumbs=array(
	Yii::t('ui','Menus'),
);

$this->menu=array(
	array('label'=>Yii::t('ui', 'Manage'),'url'=>array('admin'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>Yii::t('ui', 'New'),'url'=>$this->createReturnableUrl('create',array('id'=>$model->id)),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>Yii::t('ui', 'Menu'),'url'=>array('indexMenu')),
);
?>

<h2><?php echo Yii::t('ui', 'Menus'); ?></h2>

<div class="actionBar">
	<?php $this->widget('ext.widgets.amenu.XActionMenu', array(
		'items'=>$this->menu,
	)); ?>
	<?php echo $this->renderPartial('_search'); ?>
</div><!-- actionBar -->

<div class="breadcrumbs">
<?php echo $model->breadcrumbs; ?>
</div><!-- breadcrumbs -->

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'summaryText'=>false,
	'itemView'=>'_view',
)); ?>
