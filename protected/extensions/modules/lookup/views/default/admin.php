<?php
$this->pageTitle=Yii::app()->name. ' - ' . Yii::t('LookupModule.ui','Lookup Names');
$this->breadcrumbs=array(
	Yii::t('LookupModule.ui','Lookup Names')=>array('index'),
	Yii::t('ui',XHtml::labelize($model->type)),
);
?>

<h2><?php echo Yii::t('ui',XHtml::labelize($model->type)); ?></h2>

<?php echo CHtml::link(Yii::t('LookupModule.ui', 'New'), $this->createReturnableUrl('create',array('type'=>$model->type)));?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lookup-grid',
	'dataProvider'=>$model->search(),
	'enableSorting'=>false,
	'columns'=>array(
		array(
			'name'=>'code',
			'visible'=>Yii::app()->user->name=='admin',
		),
		array(
			'header'=>Yii::t('LookupModule.ui', 'Name Et'),
			'name'=>'name_et',
		),
		array(
			'header'=>Yii::t('LookupModule.ui', 'Name En'),
			'name'=>'name_en',
		),
		array(
			'name'=>'position',
			'visible'=>Yii::app()->user->name=='admin',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{up} {down} {update} {delete}',
			'updateButtonUrl'=>'$this->grid->controller->createReturnableUrl("update",array("id"=>$data->id))',
			'deleteButtonUrl'=>'$this->grid->controller->createReturnableUrl("delete",array("id"=>$data->id))',
			'deleteConfirmation'=>Yii::t('LookupModule.ui','Are you sure to delete this item?'),
			'buttons'=>array(
				'delete'=>array(
					'visible'=>'Yii::app()->user->name=="admin"',
				),
				'up'=>array(
					'label'=>Yii::t('LookupModule.ui','Move up'),
					'url'=>'array("move","move"=>"up","id"=>$data->id)',
					'imageUrl'=>$this->getModule()->baseScriptUrl.'/images/up.png',
					'click'=>'function() {
						$.fn.yiiGridView.update("lookup-grid", {
							type:"POST",
							url:$(this).attr("href"),
							success:function() {
								$.fn.yiiGridView.update("lookup-grid");
							}
						});
						return false;
					}',
				'visible'=>'$data->position > 1 ? true : false',
			),
			'down'=>array(
				'label'=>Yii::t('LookupModule.ui','Move down'),
				'url'=>'array("move","move"=>"down","id"=>$data->id)',
				'imageUrl'=>$this->getModule()->baseScriptUrl.'/images/down.png',
				'click'=>'function() {
						$.fn.yiiGridView.update("lookup-grid", {
							type:"POST",
							url:$(this).attr("href"),
							success:function() {
								$.fn.yiiGridView.update("lookup-grid");
							}
						});
						return false;
					}',
				'visible'=>'$this->grid->dataProvider->itemCount > $data->position ? true : false',
			),
		),
		),
	),
)); ?>