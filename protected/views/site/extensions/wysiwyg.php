<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'WYSIWYG Editor');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','WYSIWYG Editor'); ?></h2>

<?php $model=Content::model()->findbyPk(1); ?>

<?php $this->widget('ext.widgets.xheditor.XHeditor',array(
	'model'=>$model,
	'modelAttribute'=>'content',
	'config'=>array(
		'id'=>'xheditor_1',
		'tools'=>'mfull', // mini, simple, mfull, full or from XHeditor::$_tools, tool names are case sensitive
		'skin'=>'default', // default, nostyle, o2007blue, o2007silver, vista
		'width'=>'740px',
		'height'=>'400px',
		'loadCSS'=>XHtml::cssUrl('editor.css'),
		'upLinkUrl'=>$this->createUrl('request/uploadFile'),
		'upLinkExt'=>'zip,rar,txt,pdf',
		'upImgUrl'=>$this->createUrl('request/uploadFile'),
		'upImgExt'=>'jpg,jpeg,gif,png',
	),
)); ?>



<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.xheditor.XHeditor',array(
	'model'=>$model,
	'modelAttribute'=>'content',
	'config'=>array(
		'id'=>'xheditor_1',
		'tools'=>'mfull', // mini, simple, mfull, full or from XHeditor::$_tools, tool names are case sensitive
		'skin'=>'default', // default, nostyle, o2007blue, o2007silver, vista
		'width'=>'740px',
		'height'=>'400px',
		'loadCSS'=>XHtml::cssUrl('editor.css'),
		'upLinkUrl'=>$this->createUrl('request/uploadFile'),// <?php echo Yii::t('ui','NB! Access restricted by IP');?>
		'upLinkExt'=>'zip,rar,txt,pdf',
		'upImgUrl'=>$this->createUrl('request/uploadFile'), // <?php echo Yii::t('ui','NB! Access restricted by IP');?>
		'upImgExt'=>'jpg,jpeg,gif,png',
	),
));
<?php $this->endWidget(); ?>
</div>