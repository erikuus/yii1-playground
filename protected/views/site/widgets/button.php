<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Button');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Button');?></h2>

<br />

<?php $this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'submit',
	'name'=>'btnSubmit',
	'value'=>'1',
	'caption'=>'Submit',
	'htmlOptions'=>array('class'=>'ui-button-primary')
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'submit',
	'name'=>'btnSubmit',
	'value'=>'1',
	'caption'=>'Submit',
	'htmlOptions'=>array('class'=>'ui-button-primary')
));
<?php $this->endWidget(); ?>
</div>

<br />

<?php $this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'button',
	'name'=>'btnClick',
	'caption'=>'Click',
	//'options'=>array('icons'=>'js:{primary:"ui-icon-newwin"}'),
	'onclick'=>'js:function(){alert("clicked"); this.blur(); return false;}',
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'button',
	'name'=>'btnClick',
	'caption'=>'Click',
	'onclick'=>'js:function(){alert("clicked"); this.blur(); return false;}',
));
<?php $this->endWidget(); ?>
</div>

<br />

<?php $this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'link',
	'name'=>'btnGo',
	'caption'=>'Go',
	//'options'=>array('icons'=>'js:{secondary:"ui-icon-extlink"}'),
	'url'=>array('site/index'),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.jui.CJuiButton', array(
	'buttonType'=>'link',
	'name'=>'btnGo',
	'caption'=>'Go',
	'url'=>array('site/index'),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3>Täpsem info:</h3>

<a target="_blank" href="http://jqueryui.com/demos/button/">http://jqueryui.com/demos/button/</a>