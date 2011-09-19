<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Toggle content');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','Toggle content');?></h2>

<p><?php echo Yii::t('ui','Not really an extension, but simple jquery trick based on HTML layout.'); ?></p>

<div class="tpanel">
<div class="toggle">Toggle</div>
	<div>
		<?php $this->beginWidget('CTextHighlighter',array('language'=>'HTML')); ?>
		<div class="tpanel">
			<div class="toggle">Toggle</div>
			<div>Content</div>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
js/common.js
</pre></div>