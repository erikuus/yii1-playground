<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Select2');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.ExtensionMenu']=array();

// Set demo value
$model=Person::model()->findbyPk(2400);
$model->countryIds=array(1,2,3);
$model->personIds='1,2,3';
?>

<h2><?php echo Yii::t('ui','Select2'); ?></h2>

<h3>Select single</h3>
<p>wrapper for dropdown</p>
<?php $this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'country_id',
	'data'=>Country::model()->options,
	'htmlOptions'=>array(
		'style'=>'width:300px',
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'country_id',
	'data'=>Country::model()->options,
	'htmlOptions'=>array(
		'style'=>'width:300px',
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3>Select multiple</h3>
<p>wrapper for listbox, add selection, selected and remove events, limit selections</p>
<?php $this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'countryIds',
	'data'=>Country::model()->options,
	'options'=>array(
		'maximumSelectionSize'=>5,
	),
	'htmlOptions'=>array(
		'style'=>'width:700px',
		'multiple'=>'true',
		'class'=>'countries-select'
	),
	'events'=>array(
		'selected'=>"js:function (element) {
			$('[data-country='+element.val+']').hide();
		}",
		'removed'=>"js:function (element) {
			$('[data-country='+element.val+']').show();
		}"
	),
)); ?>

<p>
	<?php echo CHtml::link('Afganistan', '#', array('data-country'=>1, 'class'=>'btn btn-green country'));?>
	<?php echo CHtml::link('Aland Islands', '#', array('data-country'=>2, 'class'=>'btn btn-green country'));?>
	<?php echo CHtml::link('Albania', '#', array('data-country'=>3, 'class'=>'btn btn-green country'));?>
	<?php echo CHtml::link('Algeria', '#', array('data-country'=>4, 'class'=>'btn btn-green country'));?>
	<?php echo CHtml::link('American Samoa', '#', array('data-country'=>5, 'class'=>'btn btn-green country'));?>
	<?php echo CHtml::link('Andorra', '#', array('data-country'=>6, 'class'=>'btn btn-green country'));?>
</p>

<?php Yii::app()->clientScript->registerScript('select2interact', "
	var data=$('.countries-select').select2('val');
	$.each(data, function(index, value) {
		$('[data-country='+value+']').hide();
	});
	$('a.country').click(function(e) {
		e.preventDefault();
		var data=$('.countries-select').select2('val');
		if ($.isArray(data) && data.length >= 5) {
    	    alert('Maximum allowed number of countries is 5');
    	    return false;
        }
		var id=$(this).attr('data-country');
		$('.countries-select').val(data.concat(id)).trigger('change');
		$(this).hide();
	});
", CClientScript::POS_READY);?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'countryIds',
	'data'=>Country::model()->options,
	'options'=>array(
		'maximumSelectionSize'=>5,
	),
	'htmlOptions'=>array(
		'style'=>'width:700px',
		'multiple'=>'true',
		'class'=>'countries-select'
	),
	'events'=>array(
		'selected'=>"js:function (element) {
			$('[data-country='+element.val+']').hide();
		}",
		'removed'=>"js:function (element) {
			$('[data-country='+element.val+']').show();
		}"
	),
)); ?>

echo CHtml::link('Afganistan', '#', array('data-country'=>1, 'class'=>'btn btn-green country'));
echo CHtml::link('Aland Islands', '#', array('data-country'=>2, 'class'=>'btn btn-green country'));
echo CHtml::link('Albania', '#', array('data-country'=>3, 'class'=>'btn btn-green country'));
echo CHtml::link('Algeria', '#', array('data-country'=>4, 'class'=>'btn btn-green country'));
echo CHtml::link('American Samoa', '#', array('data-country'=>5, 'class'=>'btn btn-green country'));
echo CHtml::link('Andorra', '#', array('data-country'=>6, 'class'=>'btn btn-green country'));

Yii::app()->clientScript->registerScript('select2interact', "
	var data=$('.countries-select').select2('val');
	$.each(data, function(index, value) {
		$('[data-country='+value+']').hide();
	});
	$('a.country').click(function(e) {
		e.preventDefault();
		var data=$('.countries-select').select2('val');
		if ($.isArray(data) && data.length >= 5) {
    	    alert('Maximum allowed number of countries is 5');
    	    return false;
        }
		var id=$(this).attr('data-country');
		$('.countries-select').val(data.concat(id)).trigger('change');
		$(this).hide();
	});
", CClientScript::POS_READY);
<?php $this->endWidget(); ?>
</div>

<br />

<h3>Ajax select single</h3>
<p>ajax init selection, ajax suggest options, change event load data with ajax</p>
<?php $this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'id',
	'options'=>array(
		'minimumInputLength'=>2,
		'ajax' => array(
			'url'=>$this->createUrl('/request/suggestPerson'),
			'dataType'=>'json',
			'data' => "js: function(term,page) {
				return {q: term};
			}",
			'results' => "js: function(data,page){
				return {results: data};
			}",
		),
		'initSelection' => "js:function (element, callback) {
			var id=$(element).val();
			if (id!=='') {
				$.ajax('".$this->createUrl('/request/initPerson')."', {
					dataType: 'json',
					data: {
						id: id
					}
				}).done(function(data) {callback(data);});
			}
		}",
	),
	'events'=>array(
		'change'=>"js:function (element) {
			var id=element.val;
			if (id!='') {
				$.ajax('".$this->createUrl('/request/listPersonsWithSameFirstname')."', {
					data: {
						id: id
					}
				}).done(function(data) {
					$('#name-list').text(data);
				});
			}
		}"
	),
	'htmlOptions'=>array(
		'style'=>'width:300px'
	),
)); ?>

<div id="name-list" style="margin-top: 10px"></div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'id',
	'options'=>array(
		'minimumInputLength'=>2,
		'ajax' => array(
			'url'=>$this->createUrl('/request/suggestPerson'),
			'dataType'=>'json',
			'data' => "js: function(term,page) {
				return {q: term};
			}",
			'results' => "js: function(data,page){
				return {results: data};
			}",
		),
		'initSelection' => "js:function (element, callback) {
			var id=$(element).val();
			if (id!=='') {
				$.ajax('".$this->createUrl('/request/initPerson')."', {
					dataType: 'json',
					data: {
						id: id
					}
				}).done(function(data) {callback(data);});
			}
		}",
	),
	'events'=>array(
		'change'=>"js:function (element) {
			var id=element.val;
			if (id!='') {
				$.ajax('".$this->createUrl('/request/listPersonsWithSameFirstname')."', {
					data: {
						id: id
					}
				}).done(function(data) {
					$('#name-list').text(data);
				});
			}
		}"
	),
	'htmlOptions'=>array(
		'style'=>'width:300px'
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3>Ajax select multiple</h3>
<p>ajax init selection, ajax suggest options, format options</p>
<?php $this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'personIds',
	'options'=>array(
		'minimumInputLength'=>2,
		'multiple'=>true,
		'ajax' => array(
			'url'=>$this->createUrl('/request/suggestPersonGroupCountry'),
			'dataType'=>'json',
			'data' => "js: function(term,page) {
				return {q: term};
			}",
			'results' => "js: function(data,page){
				return {results: data};
			}",
		),
		'formatResult' => "js:function(data){
			if (data.type == 'country')
				return '<b>'+data.text+'</b>';
			else
				return '&nbsp;'+data.text;
		}",
		'initSelection' => "js:function (element, callback) {
			var id=$(element).val();
			if (id!=='') {
				$.ajax('".$this->createUrl('/request/initPerson')."', {
					dataType: 'json',
					data: {
						id: id
					}
				}).done(function(data) {callback(data);});
			}
		}",
	),
	'htmlOptions'=>array(
		'style'=>'width:700px',
		'data-placeholder'=>Yii::t('ui','Search for person'),
	)
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.select2.XSelect2', array(
	'model'=>$model,
	'attribute'=>'personIds',
	'options'=>array(
		'minimumInputLength'=>2,
		'multiple'=>true,
		'ajax' => array(
			'url'=>$this->createUrl('/request/suggestPersonGroupCountry'),
			'dataType'=>'json',
			'data' => "js: function(term,page) {
				return {q: term};
			}",
			'results' => "js: function(data,page){
				return {results: data};
			}",
		),
		'formatResult' => "js:function(data){
			if (data.type == 'country')
				return '<b>'+data.text+'</b>';
			else
				return '&nbsp;'+data.text;
		}",
		'initSelection' => "js:function (element, callback) {
			var id=$(element).val();
			if (id!=='') {
				$.ajax('".$this->createUrl('/request/initPerson')."', {
					dataType: 'json',
					data: {
						id: id
					}
				}).done(function(data) {callback(data);});
			}
		}",
	),
	'htmlOptions'=>array(
		'style'=>'width:700px',
		'data-placeholder'=>Yii::t('ui','Search for person'),
	)
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
/protected/controllers/RequestController.php
/protected/extensions/actions/XSelect2InitAction.php
/protected/extensions/actions/XSelect2SuggestAction.php
/protected/models/Person.php
</pre></div>