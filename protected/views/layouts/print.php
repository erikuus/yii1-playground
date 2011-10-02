<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<link rel="stylesheet" type="text/css" href="<?php echo XHtml::cssUrl('main.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo XHtml::cssUrl('form.css'); ?>" />
<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('yii');
$cs->registerScriptFile(XHtml::jsUrl('common.js'), CClientScript::POS_HEAD);
?>
<title><?php echo $this->pageTitle; ?></title>
</head>

<body style="background: white;">

	<div id="page" style="width: 625px">

		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->

	</div><!-- page -->

</body>
</html>