<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Manage Persons');

$this->breadcrumbs=array(
	Yii::t('ui','Persons'),
);
?>

<h2><?php echo Yii::t('ui', 'Manage Persons'); ?></h2>

<div class="actionBar">
<?php echo CHtml::link(Yii::t('ui', 'New'),array('create')); ?>
</div> <!-- actionBar -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'person-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'htmlOptions'=>array('style'=>'width:740px'),
	'pager'=>array(
		'maxButtonCount'=>'7',
	),
	'columns'=>array(
		/*
		'id',
		'email:email',
		'webpage:url',
		'registered',
		*/
		array(
			'name'=>'lastname',
			'type'=>'raw',
			'value'=>'CHtml::link($data->lastname, $this->grid->controller->createReturnableUrl("view",array("id"=>$data->id)))',
			'filter'=>$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model'=>$model,
				'attribute'=>'lastname',
				'source'=>$this->createUrl('request/suggestLastname'),
				'options'=>array(
					'focus'=>"js:function(event, ui) {
						$('#".CHtml::activeId($model,'lastname')."').val(ui.item.value);
					}",
					'select'=>"js:function(event, ui) {
						$.fn.yiiGridView.update('person-grid', {
							data: $('#person-grid .filters input, #person-grid .filters select').serialize()
						});
					}"
				),
			),true),
		),
		'firstname',
		'birthyear',
		array(
			'name'=>'country_id',
			'value'=>'$data->country->name',
			'filter'=>Country::model()->options,
		),
		array(
			'name'=>'eyecolor_code',
			'value'=>'Lookup::item("eyecolor",$data->eyecolor_code)',
			'filter'=>Lookup::items('eyecolor'),
		),
		array(
			'class'=>'CLinkColumn',
			'header'=>Yii::t('ui','Email'),
			'imageUrl'=>XHtml::imageUrl('email.png'),
			'labelExpression'=>'$data->email',
			'urlExpression'=>'"mailto://".$data->email',
			'htmlOptions'=>array('style'=>'text-align:center'),
		),
		array(
			'class'=>'CButtonColumn',
			'viewButtonUrl'=>'$this->grid->controller->createReturnableUrl("view",array("id"=>$data->id))',
			'updateButtonUrl'=>'$this->grid->controller->createReturnableUrl("update",array("id"=>$data->id))',
			'deleteButtonUrl'=>'$this->grid->controller->createReturnableUrl("delete",array("id"=>$data->id))',
			'deleteConfirmation'=>Yii::t('ui','Are you sure to delete this item?'),
		),
	),
	'afterAjaxUpdate'=>"function(){
		jQuery('#".CHtml::activeId($model,'lastname')."').autocomplete({
			'delay':300,
			'minLength':2,
			'source':'".$this->createUrl('request/suggestLastname')."',
			'focus':function(event, ui) {
				$('#".CHtml::activeId($model,'lastname')."').val(ui.item.value);
			},
			'select':function(event, ui) {
				$.fn.yiiGridView.update('person-grid', {
					data: $('#person-grid .filters input, #person-grid .filters select').serialize()
				});
			}
		});
	}",
)); ?>

<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'person-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'htmlOptions'=>array('style'=>'width:740px'),
	'pager'=>array(
		'maxButtonCount'=>'7',
	),
	'columns'=>array(
		/*
		'id',
		'email:email',
		'webpage:url',
		'registered',
		*/
		array(
			'name'=>'lastname',
			'type'=>'raw',
			'value'=>'CHtml::link($data->lastname, $this->grid->controller->createReturnableUrl("view",array("id"=>$data->id)))',
			'filter'=>$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'model'=>$model,
				'attribute'=>'lastname',
				'source'=>$this->createUrl('request/suggestLastname'),
				'options'=>array(
					'focus'=>"js:function(event, ui) {
						$('#".CHtml::activeId($model,'lastname')."').val(ui.item.value);
					}",
					'select'=>"js:function(event, ui) {
						$.fn.yiiGridView.update('person-grid', {
							data: $('#person-grid .filters input, #person-grid .filters select').serialize()
						});
					}"
				),
			),true),
		),
		'firstname',
		'birthyear',
		array(
			'name'=>'country_id',
			'value'=>'$data->country->name',
			'filter'=>Country::model()->options,
		),
		array(
			'name'=>'eyecolor_code',
			'value'=>'Lookup::item("eyecolor",$data->eyecolor_code)',
			'filter'=>Lookup::items('eyecolor'),
		),
		array(
			'class'=>'CLinkColumn',
			'header'=>Yii::t('ui','Email'),
			'imageUrl'=>XHtml::imageUrl('email.png'),
			'labelExpression'=>'$data->email',
			'urlExpression'=>'"mailto://".$data->email',
			'htmlOptions'=>array('style'=>'text-align:center'),
		),
		array(
			'class'=>'CButtonColumn',
			'viewButtonUrl'=>'$this->grid->controller->createReturnableUrl("view",array("id"=>$data->id))',
			'updateButtonUrl'=>'$this->grid->controller->createReturnableUrl("update",array("id"=>$data->id))',
			'deleteButtonUrl'=>'$this->grid->controller->createReturnableUrl("delete",array("id"=>$data->id))',
			'deleteConfirmation'=>Yii::t('ui','Are you sure to delete this item?'),
		),
	),
	'afterAjaxUpdate'=>"function(){
		jQuery('#".CHtml::activeId($model,'lastname')."').autocomplete({
			'delay':300,
			'minLength':2,
			'source':'".$this->createUrl('request/suggestLastname')."',
			'focus':function(event, ui) {
				$('#".CHtml::activeId($model,'lastname')."').val(ui.item.value);
			},
			'select':function(event, ui) {
				$.fn.yiiGridView.update('person-grid', {
					data: $('#person-grid .filters input, #person-grid .filters select').serialize()
				});
			}
		});
	}",
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/PersonController.php: public function actionAdmin()
protected/models/Person.php
</pre></div>
