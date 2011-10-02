<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Manage Menus');

Yii::app()->clientScript->registerScript('admin', "
	$('#menu-treeview a').live('click',function(){
		var id=$(this).attr('id');
		window.location.href = '?id='+id;
		$('#treeview-dialog').dialog('close');
		return false;
	});
");

$this->breadcrumbs=array(
	Yii::t('ui','Menus')=>array('index'),
	Yii::t('ui','Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('ui', 'New'), 'url'=>$this->createReturnableUrl('create',array('id'=>$model->id))),
	array('label'=>Yii::t('ui', 'Tree'),'url'=>'#','linkOptions'=>array('onclick'=>'$("#tree-dialog").dialog("open");return false;')),
	array('label'=>Yii::t('ui', 'Menu'),'url'=>array('adminMenu')),
);
?>

<h2><?php echo Yii::t('ui', 'Manage Menus'); ?></h2>

<div class="actionBar">
	<?php $this->widget('ext.widgets.amenu.XActionMenu', array(
		'items'=>$this->menu,
	)); ?>
	<?php echo $this->renderPartial('_search'); ?>
</div><!-- actionBar -->

<div class="breadcrumbs">
<?php echo $model->breadcrumbs; ?>
</div><!-- breadcrumbs -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'menu-grid',
	'dataProvider'=>$dataProvider,
	'hideHeader'=>true,
	'enableSorting'=>false,
	'summaryText'=>false,
	'columns'=>array(
		'id',
		array(
			'type'=>'raw',
			'name'=>'parent_id',
			'value'=>'CHtml::link(CHtml::encode($data->parent_id), array("admin","id"=>$data->id))',
		),
		'label',
		'position',
		array(
			'class'=>'CButtonColumn',
			'viewButtonUrl'=>'$this->grid->controller->createReturnableUrl("view",array("id"=>$data->id))',
			'updateButtonUrl'=>'$this->grid->controller->createReturnableUrl("update",array("id"=>$data->id))',
			'template'=>'{view} {update} {deleteAdvanced} {deleteSimple}',
			'buttons'=>array(
				'deleteAdvanced'=>array(
					'label'=>Yii::t('ui','Delete'),
					'url'=>'$this->grid->controller->createReturnableUrl("delete",array("id"=>$data->id))',
					'imageUrl'=>XHtml::imageUrl('delete.png'),
					'visible'=>'Yii::app()->user->name=="admin" && $data->childCount>0',
					'click'=>'function() {
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
						return false;
					}',
				),
				'deleteSimple'=>array(
					'label'=>Yii::t('ui','Delete'),
					'url'=>'$this->grid->controller->createReturnableUrl("delete",array("id"=>$data->id))',
					'imageUrl'=>XHtml::imageUrl('delete.png'),
					'visible'=>'Yii::app()->user->name=="admin"  && $data->childCount==0',
					'click'=>'function() {
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
								}
							}
						});
						$("#delete-dialog").dialog("open");
						return false;
					}',
				),
			)
		),
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

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'tree-dialog',
	'options'=>array(
		'title'=>Yii::t('ui','Select form hierarchy'),
		'width'=>500,
		'height'=>300,
		'autoOpen'=>false,
		'modal'=>true,
	)
));
	echo $this->renderPartial('_tree');
$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
