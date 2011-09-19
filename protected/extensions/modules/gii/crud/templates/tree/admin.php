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
	array('label'=>Yii::t('ui', 'New'), 'url'=>$this->createReturnableUrl('create',array('id'=>$model->id))),
	array('label'=>Yii::t('ui', 'Tree'),'url'=>'#','linkOptions'=>array('onclick'=>'$("#tree-dialog").dialog("open");return false;')),
	array('label'=>Yii::t('ui', 'Menu'), 'url'=>array('adminMenu')),
);

Yii::app()->clientScript->registerScript('admin', "
	$('#<?php echo $this->class2id($this->modelClass); ?>-treeview a').live('click',function(){
		var id=$(this).attr('id');
		window.location.href = '?id='+id;
		$('#treeview-dialog').dialog('close');
		return false;
	});
");
?>

<h2><?php echo "<?php echo Yii::t('ui', 'Manage {$this->pluralize($this->class2name($this->modelClass))}'); ?>"; ?></h2>

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

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$dataProvider,
	'hideHeader'=>true,
	'enableSorting'=>false,
	'summaryText'=>false,
	'columns'=>array(
<?php
echo "\t\tarray(\n";
echo "\t\t\t'type'=>'raw',\n";
echo "\t\t\t'value'=>'CHtml::link(CHtml::encode(\"[+]\"), array(\"admin\",\"id\"=>\$data->id))',\n";
echo "\t\t),\n";
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

<?php echo "<?php"; ?> $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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

<?php echo "<?php"; ?> $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
