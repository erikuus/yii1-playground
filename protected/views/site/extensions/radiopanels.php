<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Radio panels');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','Radio panels');?></h2>

<p><?php echo Yii::t('ui','Not really an extension, but simple jquery trick based on HTML layout.'); ?></p>

<div class="form">
	<div class="rpanel">
		<input id="datum_type_0" value="0" type="radio" name="datum_type" />
		<label for="datum_type_0"><?php echo Yii::t('ui','Date');?></label>
		<span class="rpanelContent">
			<input id="datum_date" name="datum_date]" type="text" value="" />
		</span>
	</div>
	<div class="rpanel">
		<input id="datum_type_1" value="1" type="radio" name="datum_type" />
		<label for="datum_type_1"><?php echo Yii::t('ui','Year');?></label>
		<span class="rpanelContent">
			<input size="4" maxlength="4" name="datum_year" id="datum_year" type="text" value="" />
		</span>
	</div>
	<div class="rpanel">
		<input id="datum_type_2" value="2" type="radio" name="datum_type" />
		<label for="datum_type_2"><?php echo Yii::t('ui','Century');?></label>
		<span class="rpanelContent">
			<input size="2" maxlength="2" name="datum_century]" id="datum_century" type="text" value="" />
		</span>
	</div>
	<div class="rpanel">
		<input id="datum_type_3" value="3" checked="checked" type="radio" name="datum_type" />
		<label for="datum_type_3"><?php echo Yii::t('ui','Year range');?></label>
		<span class="rpanelContent">
			<input size="4" maxlength="4" name="datum_year_start" id="datum_year_start" type="text" value="1850" /> -
			<input size="4" maxlength="4" name="datum_year_end" id="datum_year_end" type="text" value="1860" />
		</span>
	</div>
	<div class="rpanel">
		<input id="datum_type_4" value="4" type="radio" name="datum_type" />
		<label for="datum_type_4"><?php echo Yii::t('ui','Century range');?></label>
		<span class="rpanelContent">
			<input size="2" maxlength="2" name="datum_century_start" id="datum_century_start" type="text" value="" /> -
			<input size="2" maxlength="2" name="datum_century_end" id="datum_century_end" type="text" value="" />
		</span>
	</div>
</div><!-- yiiForm -->

<div class="tpanel">
	<div class="toggle"><?php echo Yii::t('ui','View code');?></div>
	<div>
		<?php $this->beginWidget('CTextHighlighter',array('language'=>'HTML')); ?>
		<div class="rpanel">
			<input type="radio"><label>Label</label>
			<span class="rpanelContent">
			...
			</span>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
js/common.js
</pre></div>