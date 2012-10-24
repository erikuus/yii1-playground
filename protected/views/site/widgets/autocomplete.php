<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Autocomplete new');
$this->layout = 'leftbar';
$this->leftPortlets['ptl.WidgetMenu'] = array();

Yii::app()->clientScript->registerCss('autocompleteSize', "
	.ui-autocomplete {
		max-height: 400px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
", 'screen', CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScript('scriptId', "
	function split(val) {
		return val.split(/,\s*/);
	}
	function extractLast(term) {
		return split(term).pop();
	}
", CClientScript::POS_HEAD);

?>


<h2><?php echo Yii::t('ui', 'Autocomplete new'); ?></h2>

<div class="form">

<div class="group">
	<?php echo Yii::t('ui', 'Select single'); ?>
</div>

<?php echo Yii::t('ui','Country'); ?>:
<br />
<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-single',
	'name'=>'country_single',
	'source'=>$this->createUrl('request/suggestCountry'),
	'htmlOptions'=>array(
		'size'=>'40'
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-single',
	'name'=>'country_single',
	'source'=>$this->createUrl('request/suggestCountry'),
	'htmlOptions'=>array(
		'size'=>'40'
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<div class="group">
	<?php echo Yii::t('ui', 'Select multiple'); ?>
</div>

<?php echo Yii::t('ui','Country'); ?>:
<br />
<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-multiple',
	'name'=>'country_multiple',
	'source'=>"js:function(request, response) {
		$.getJSON('".$this->createUrl('request/suggestCountry')."', {
			term: extractLast(request.term)
		}, response);
	}",
	'options'=>array(
		'delay'=>300,
		'minLength'=>2,
		'showAnim'=>'fold',
		'select'=>"js:function(event, ui) {
			var terms = split(this.value);
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push( ui.item.value );
			// add placeholder to get the comma-and-space at the end
			terms.push('');
			this.value = terms.join(', ');
			return false;
		}"
	),
	'htmlOptions'=>array(
		'size'=>'40'
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-multiple',
	'name'=>'country_multiple',
	'source'=>"js:function(request, response) {
		$.getJSON('".$this->createUrl('request/suggestCountry')."', {
			term: extractLast(request.term)
		}, response);
	}",
	'options'=>array(
		'delay'=>300,
		'minLength'=>2,
		'showAnim'=>'fold',
		'select'=>"js:function(event, ui) {
			var terms = split(this.value);
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push( ui.item.value );
			// add placeholder to get the comma-and-space at the end
			terms.push('');
			this.value = terms.join(', ');
			return false;
		}"
	),
	'htmlOptions'=>array(
		'size'=>'40'
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<div class="group">
	<?php echo Yii::t('ui', 'Select in chain'); ?>
</div>

<?php echo Yii::t('ui','Country'); ?>:
<br />
<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-chain',
	'name'=>'country_chain',
	'source'=>$this->createUrl('request/suggestCountry'),
	'options'=>array(
		'delay'=>300,
		'minLength'=>2,
		'showAnim'=>'fold',
		'select'=>"js:function(event, ui) {
			$('#label').val(ui.item.label);
			$('#code').val(ui.item.code);
			$('#call_code').val(ui.item.call_code);
		}"
	),
	'htmlOptions'=>array(
		'size'=>'40'
	),
)); ?>

<br />
<br />

<?php echo Yii::t('ui','These fields will be filled automatically after you select country'); ?>.
<br />
<input id="label" type="text" style="width: 300px; margin-bottom: 5px" />
<br />
<input id="code" type="text" style="width: 300px; margin-bottom: 5px" />
<br />
<input id="call_code" type="text" style="width: 300px; margin-bottom: 5px" />
<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-chain',
	'name'=>'country_chain',
	'source'=>$this->createUrl('request/suggestCountry'),
	'options'=>array(
		'delay'=>300,
		'minLength'=>2,
		'showAnim'=>'fold',
		'select'=>"js:function(event, ui) {
			$('#label').val(ui.item.label);
			$('#code').val(ui.item.code);
			$('#call_code').val(ui.item.call_code);
		}"
	),
	'htmlOptions'=>array(
		'size'=>'40'
	),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/RequestController.php
protected/extensions/actions/XSuggestAction.php
protected/models/Country.php: public function suggest()
</pre></div>

</div><!-- form -->

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://jqueryui.com/demos/autocomplete/">http://jqueryui.com/demos/autocomplete/</a>