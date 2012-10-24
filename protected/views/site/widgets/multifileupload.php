<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Multiple file upload');
$this->layout='leftbar';
$this->leftPortlets['ptl.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Multiple file upload');?></h2>

<?php echo CHtml::form($this->createUrl('upload'),'post',array('enctype'=>'multipart/form-data')); ?>

<?php $this->widget('CMultiFileUpload',array(
	'name'=>'files',
	'accept'=>'jpg|png',
	'max'=>3,
	'remove'=>Yii::t('ui','Remove'),
	//'denied'=>'', message that is displayed when a file type is not allowed
	//'duplicate'=>'', message that is displayed when a file appears twice
	'htmlOptions'=>array('size'=>25),
)); ?>
<br />
<?php echo CHtml::submitButton(Yii::t('ui', 'Upload')); ?>&nbsp;
<?php echo Yii::t('ui','NB! Access restricted by IP');?>
<?php echo CHtml::endForm(); ?>

<ul>
<?php foreach($this->findFiles() as $filename): ?>
	<li><?php echo CHtml::link($filename, Yii::app()->baseUrl.'/'.Yii::app()->params['uploadDir'].$filename, array('rel'=>'external'));?></li>
<?php endforeach; ?>
</ul>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CMultiFileUpload',array(
	'name'=>'files',
	'accept'=>'jpg|png',
	'max'=>3,
	'remove'=>Yii::t('ui','Remove'),
	//'denied'=>'', message that is displayed when a file type is not allowed
	//'duplicate'=>'', message that is displayed when a file appears twice
	'htmlOptions'=>array('size'=>25),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/SiteController.php: public function actionUpload()
protected/views/site/widgets/multifileupload.php
</pre></div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank"
	href="http://www.fyneworks.com/jquery/multiple-file-upload/">http://www.fyneworks.com/jquery/multiple-file-upload/</a>