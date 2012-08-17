<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php if(Yii::app()->user->hasFlash('deleted')): ?>\n"; ?>
<div class="confirmation"><?php echo "<?php echo Yii::app()->user->getFlash('deleted'); ?>"; ?></div>
<?php echo "<?php endif;?>\n"; ?>

<?php echo "<?php if(Yii::app()->user->hasFlash('saved')): ?>\n"; ?>
<div class="confirmation"><?php echo "<?php echo Yii::app()->user->getFlash('saved'); ?>"; ?></div>
<?php echo "<?php endif;?>\n"; ?>

<?php echo "<?php echo  Yii::t('ui', 'n==0#|n==1#The search returned 1 result|n>1#The search returned {c} results', array(\n\t\$dataProvider->totalItemCount, '{c}'=>\$dataProvider->totalItemCount\n)); ?>\n"; ?>

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'ajaxUpdate'=>false,
	'template'=>'{pager}{summary}{items}{pager}',
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";

	if($column->isPrimaryKey)
	{
		echo "\t\tarray(\n";
		echo "\t\t\t'name'=>'".$column->name."',\n";
		echo "\t\t\t'type'=>'raw',\n";
		echo "\t\t\t'value'=>'CHtml::link(\$data->primaryKey, \$this->grid->controller->createReturnableUrl(\"view\",array(\"id\"=>\$data->primaryKey)))',\n";
		echo "\t\t),\n";
	}
	else
		echo "\t\t'".$column->name."',\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update<?php echo $this->modelClass; ?>} {delete<?php echo $this->modelClass; ?>}',
			'buttons'=>array(
				'update<?php echo $this->modelClass; ?>'=>array(
					'label'=>Yii::t('ui','Update'),
					'url'=>'$this->grid->controller->createReturnableUrl("update",array("id"=>$data->primaryKey))',
					'imageUrl'=>XHtml::imageUrl('update.png'),
					'visible'=>'!Yii::app()->user->isGuest',
				),
				'delete<?php echo $this->modelClass; ?>'=>array(
					'label'=>Yii::t('ui','Delete'),
					'url'=>'$this->grid->controller->createReturnableUrl("delete",array("id"=>$data->primaryKey))',
					'imageUrl'=>XHtml::imageUrl('delete.png'),
					'visible'=>'!Yii::app()->user->isGuest',
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
									$.yii.submitForm(this, targetUrl,{});
								}
				           	}
				       });
				       $("#delete-dialog").dialog("open");
				       return false;
					}',
				),
			),
		),
	),
)); ?>

<?php echo "<?php"; ?> $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'delete-dialog',
	'options'=>array(
		'title'=>Yii::t('ui','Confirm'),
		'width'=>400,
		'height'=>150,
		'autoOpen'=>false,
		'modal'=>true,
	)
));
$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>