<?php
if(!Yii::app()->request->isAjaxRequest)
{
	$cs=Yii::app()->clientScript;
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('yii');
	$cs->registerScriptFile(XHtml::jsUrl('common.js'), CClientScript::POS_HEAD);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<link rel="shortcut icon" href="<?php echo XHtml::imageUrl('favicon.ico'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo XHtml::cssUrl('960.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo XHtml::cssUrl('main.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo XHtml::cssUrl('form.css'); ?>" />

<title><?php echo $this->pageTitle; ?></title>
</head>

<body>

<div class="page">
	<div id="header">

		<div id="menubar">
			<?php $this->widget('ext.components.language.XLangMenu', array(
				'encodeLabel'=>false,
				'items'=>array(
					'et'=>XHtml::imageLabel('et.png','Eesti',true),
					'en'=>XHtml::imageLabel('en.png','In English',true)
				),
			)); ?>
		</div><!-- menubar -->

		<div id="logo">
			<?php echo XHtml::imageLabel('blocks.gif', Yii::app()->name);?>
		</div><!-- logo -->

	</div><!-- header -->
</div><!-- page -->

<div id="mainmenu">
	<div class="page">
		<?php $this->widget('ptl.MainMenu'); ?>
	</div>
</div>

<div class="page">
	<div id="content">
		<?php if(empty($this->layout)): ?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?>
		<!-- breadcrumbs -->
		<?php endif; ?>

		<?php echo $content; ?>
	</div><!-- content -->

	<div id="footer">
		<?php echo 'Copyright &copy; '.date('Y').' Erik Uus'; ?>
	</div><!-- footer -->

</div><!-- page -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'help-dialog',
	'options'=>array(
		'title'=>Yii::t('ui','Help'),
		'width'=>600,
		'height'=>400,
		'autoOpen'=>false,
		'modal'=>true,
	),
));
$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->widget('ext.widgets.google.XGoogleAnalytics', array(
	'visible'=>Yii::app()->params['googleAnalytics'] && !$this->isIpMatched(),
	'tracker'=>Yii::app()->params['googleAnalyticsTracker'],
)); ?>

</body>
</html>