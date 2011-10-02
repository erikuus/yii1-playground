<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'View Menu');

$this->breadcrumbs=array(
	Yii::t('ui','Menus')=>array('index'),
	$model->id,
);

$this->menu=array(
	array(
		'label'=>Yii::t('ui', 'Back'),
		'url'=>$this->getReturnUrl(),
		'visible'=>$this->getReturnUrl()!==null
	),
	array(
		'label'=>Yii::t('ui', 'Update'),
		'url'=>$this->createReturnableUrl('update',array('id'=>$model->id)),
		'visible'=>!Yii::app()->user->isGuest
	),
	array(
		'label'=>Yii::t('ui', 'Delete'),
		'url'=>array('delete','id'=>$model->id),
		'visible'=>Yii::app()->user->name=='admin' && $model->childCount==0,
		'linkOptions'=>array(
			'onclick'=>'
				var targetUrl = $(this).attr("href");
				$("#delete-dialog").dialog({
					open : function(){
						$(this).text("'.Yii::t('ui','Are you sure to delete this item?').'");
					},
					buttons : {
						"'.Yii::t('ui','Cancel').'": function() {
							$(this).dialog("close");
						},
						"'.Yii::t('ui','Yes').'": function() {
							$.yii.submitForm(this, targetUrl+"&command=delete",{});
						},
					}
			});
			$("#delete-dialog").dialog("open");
			return false;'
		)
	),
	array(
		'label'=>Yii::t('ui', 'Delete'),
		'url'=>array('delete','id'=>$model->id),
		'visible'=>Yii::app()->user->name=='admin' && $model->childCount>0,
		'linkOptions'=>array(
			'onclick'=>'
				var targetUrl = $(this).attr("href");
				$("#delete-dialog").dialog({
					open : function(){
						$(this).text("'.Yii::t('ui','Are you sure to delete this item and its subitems?').'");
					},
					buttons : {
						"'.Yii::t('ui','Cancel').'": function() {
							$(this).dialog("close");
						},
						"'.Yii::t('ui','Yes').'": function() {
							$.yii.submitForm(this, targetUrl+"&command=withChildren",{});
						},
						"'.Yii::t('ui','No, delete this item only').'": function() {
							$.yii.submitForm(this, targetUrl+"&command=keepChildren",{});
						}
					}
			});
			$("#delete-dialog").dialog("open");
			return false;'
		)
	),
);
?>

<h2><?php echo Yii::t('ui', 'View Menu'); ?></h2>

<div class="actionBar">
	<?php $this->widget('ext.widgets.amenu.XActionMenu', array(
		'items'=>$this->menu,
	)); ?>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'label',
		'position',
	),
)); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'delete-dialog',
	'options'=>array(
		'title'=>Yii::t('ui','Delete'),
		'width'=>400,
		'height'=>150,
		'autoOpen'=>false,
		'modal'=>true,
	)
));
$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>