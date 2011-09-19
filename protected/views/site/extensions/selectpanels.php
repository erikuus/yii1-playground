<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Select panels');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','Select panels'); ?></h2>

<p><?php echo Yii::t('ui','Not really an extension, but simple jquery trick based on HTML layout.'); ?></p>

<div class="form">
	<div class="spanel">
		<?php echo CHtml::dropDownList('id1', '', array('-1'=>Yii::t('ui','-add-'))+Country::model()->options); ?> 
		<span class="spanelContent">     
			<?php echo CHtml::textField('name1','',array('size'=>30,'maxlength'=>128)); ?>
		</span>
	</div>
	<br />
	<div class="spanel">
		<?php echo CHtml::dropDownList('id2', '', array('-1'=>Yii::t('ui','-add-'))+Country::model()->options, array('prompt'=>''));?> 
		<span class="spanelContent">     
			<?php echo CHtml::textField('name2','',array('size'=>30,'maxlength'=>128)); ?>
		</span>
	</div>
</div><!-- yiiForm -->

<div class="tpanel">
	<div class="toggle"><?php echo Yii::t('ui','View code');?></div>
	<div>
		<?php $this->beginWidget('CTextHighlighter',array('language'=>'HTML')); ?>
		<div class="spanel">
			<select>
				<option value="-1">-add-</option>
				<option value="1">A</option>
			</select>
			<span class="spanelContent">
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