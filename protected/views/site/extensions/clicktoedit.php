<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Click to Edit');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();
$model=Content::model()->findbyPk(1);
?>

<h2><?php echo Yii::t('ui','Click to Edit'); ?></h2>

<p><?php echo Yii::t('ui','NB! Access restricted by IP');?></p>

<h3>
<?php $this->widget('ext.widgets.jeditable.XEditableWidget', array(
	'saveurl'=>$this->createUrl('request/saveTitle', array('id'=>$model->id)),
	'model'=>$model,
	'attribute'=>'title',
	'editable'=>$this->isIpMatched(),
	'jeditable_type'=>'text',
	'width'=>'200px',
	'tooltip'=>' Click to edit!',
)); ?>
</h3>

<?php $this->widget('ext.widgets.jeditable.XEditableWidget', array(
	'saveurl'=>$this->createUrl('request/saveContent', array('id'=>$model->id)),
	'loadurl'=>$this->createUrl('request/loadContent', array('id'=>$model->id)),
	'model'=>$model,
	'attribute'=>'content',
	'editable'=>$this->isIpMatched(),
	'markdown'=>true,
	'jeditable_type' => 'textarea',
	'width'=>'100%',
	'height'=>'150px',
	'submit'=>Yii::t('ui','Save'),
	'cancel'=>Yii::t('ui','Cancel'),
	'tooltip'=>'Click to edit!',
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.jeditable.XEditableWidget', array(
	'saveurl'=>$this->createUrl('request/saveTitle', array('id'=>$model->id)),
	'model'=>$model,
	'attribute'=>'title',
	'editable'=>$this->isIpMatched(),
	'jeditable_type'=>'text',
	'width'=>'200px',
	'tooltip'=>' Click to edit!',
));

$this->widget('ext.widgets.jeditable.XEditableWidget', array(
	'saveurl'=>$this->createUrl('request/saveContent', array('id'=>$model->id)),
	'loadurl'=>$this->createUrl('request/loadContent', array('id'=>$model->id)),
	'model'=>$model,
	'attribute'=>'content',
	'editable'=>$this->isIpMatched(),
	'markdown'=>true,
	'jeditable_type' => 'textarea',
	'width'=>'100%',
	'height'=>'150px',
	'submit'=>Yii::t('ui','Save'),
	'cancel'=>Yii::t('ui','Cancel'),
	'tooltip'=>'Click to edit!',
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/RequestController.php
protected/extensions/actions/XEditableAction.php
protected/models/Content.php
</pre></div>

<br />

<h3>Täpsem info:</h3>

<a target="_blank" href="http://www.appelsiini.net/projects/jeditable">http://www.appelsiini.net/projects/jeditable</a>
