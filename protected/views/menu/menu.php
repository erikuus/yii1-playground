<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Menu');

$this->breadcrumbs=array(
	Yii::t('ui','Menus')=>array('index'),
	Yii::t('ui','Menu'),
);
?>

<h2><?php echo Yii::t('ui', 'Menu'); ?></h2>

<?php
$this->widget('zii.widgets.CMenu',array(
	'items'=>Menu::model()->menuItems,
));
?>