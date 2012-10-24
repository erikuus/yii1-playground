<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Autocomplete old');
$this->layout = 'leftbar';
$this->leftPortlets['ptl.WidgetMenu'] = array();
?>

<h2><?php echo Yii::t('ui', 'Autocomplete old'); ?></h2>

<div class="form">

<div class="group">
	<?php echo Yii::t('ui', 'Select single'); ?>
</div>

<?php echo Yii::t('ui','Country'); ?>:
<br />
<?php $this->widget('CAutoComplete',array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-single',
	'name'=>'country_single',
	'url'=>array('request/legacySuggestCountry'),
	'max'=>100,
	'minChars'=>2,
	'delay'=>300,
	'htmlOptions'=>array('size'=>'40')
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CAutoComplete',array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-single',
	'name'=>'country_single',
	'url'=>array('request/legacySuggestCountry'),
	'max'=>100,
	'minChars'=>2,
	'delay'=>300,
	'htmlOptions'=>array('size'=>'40')
));
<?php $this->endWidget(); ?>
</div>

<br />

<div class="group">
	<?php echo Yii::t('ui', 'Select multiple'); ?>
</div>

<?php echo Yii::t('ui','Countries'); ?>:
<br />
<?php $this->widget('CAutoComplete',array(
	//'model'=>$model,
	//'attribute'=>'name',
	'name'=>'country_multiple',
	'id'=>'country-multiple',
	'url'=>array('request/legacySuggestCountry'),
	'max'=>100,
	'minChars'=>2,
	'delay'=>300,
	'multiple'=>true,
	'textArea'=>true,
	'htmlOptions'=>array('rows'=>'5','cols'=>'50')
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CAutoComplete',array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-multiple',
	'name'=>'country_multiple',
	'url'=>array('request/legacySuggestCountry'),
	'max'=>100,
	'minChars'=>2,
	'delay'=>300,
	'multiple'=>true,
	'textArea'=>true,
	'htmlOptions'=>array('rows'=>'5','cols'=>'50')
));
<?php $this->endWidget(); ?>
</div>

<br />

<div class="group">
	<?php echo Yii::t('ui', 'Select in chain'); ?>
</div>

<?php echo Yii::t('ui','Country'); ?>:
<br />
<?php $this->widget('CAutoComplete',array(
	//'model'=>$model,
	//'attribute'=>'name',
	'name'=>'country_chain',
	'id'=>'country-chain',
	'url'=>array('request/legacySuggestCountry'),
	'max'=>100,
	'minChars'=>2,
	'delay'=>300,
	'htmlOptions'=>array('size'=>'80'),
	'methodChain'=>'
		.result
		(
			function(event,item)
			{
				$("#name").val(item[1]);
				$("#code").val(item[2]);
				$("#call_code").val(item[3]);
			}
		)
	'
));
?>

<br />
<br />

<?php echo Yii::t('ui','These fields will be filled automatically after you select country'); ?>.
<br />
<input id="name" type="text" style="width: 300px; margin-bottom: 5px" />
<br />
<input id="code" type="text" style="width: 300px; margin-bottom: 5px" />
<br />
<input id="call_code" type="text" style="width: 300px; margin-bottom: 5px" />
<br />

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CAutoComplete',array(
	//'model'=>$model,
	//'attribute'=>'name',
	'id'=>'country-chain',
	'name'=>'country_chain',
	'url'=>array('request/legacySuggestCountry'),
	'max'=>100,
	'minChars'=>2,
	'delay'=>300,
	'htmlOptions'=>array('size'=>'80'),
	'methodChain'=>'
		.result
		(
			function(event,item)
			{
				$("#name").val(item[1]);
				$("#code").val(item[2]);
				$("#call_code").val(item[3]);
			}
		)
	'
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/RequestController.php
protected/extensions/actions/XLegacySuggestAction.php
protected/models/Country.php: public function legacySuggest()
</pre></div>

</div><!-- form -->

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank" href="http://docs.jquery.com/Plugins/Autocomplete">http://docs.jquery.com/Plugins/Autocomplete</a>