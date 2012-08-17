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
	array('label'=>Yii::t('ui', 'Back'), 'url'=>$this->getReturnUrl(),'visible'=>$this->getReturnUrl()!==null),
	array('label'=>Yii::t('ui', 'Update'),'url'=>$this->createReturnableUrl('update',array('id'=>$model->id)), 'visible'=>!Yii::app()->user->isGuest),
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
						}
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
