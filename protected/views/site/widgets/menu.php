<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Multilevel menu');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.WidgetMenu']=array();
?>

<h2><?php echo Yii::t('ui','Multilevel menu'); ?></h2>

<h3><?php echo Yii::t('ui','Static items'); ?></h3>

<?php $this->widget('zii.widgets.CMenu', array(
	'items'=>array(
		array('label'=>Yii::t('ui','Home'), 'url'=>array('/site/index')),
		array('label'=>Yii::t('ui','Data Widgets'), 'items'=>array(
			array('label'=>Yii::t('ui','Tree view'), 'url'=>array('/site/widget', 'view'=>'treeview')),
			array('label'=>Yii::t('ui','Multilevel menu'), 'url'=>array('/site/widget', 'view'=>'menu')),
			array('label'=>Yii::t('ui','Breadcrumbs'), 'url'=>array('/site/widget', 'view'=>'breadcrumbs')),
		)),
		array('label'=>Yii::t('ui','Form Widgets'), 'items'=>array(
			array('label'=>Yii::t('ui','Masked textfield'), 'url'=>array('/site/widget', 'view'=>'maskedtextfield')),
			array('label'=>Yii::t('ui','Datepicker'), 'url'=>array('/site/widget', 'view'=>'datepicker')),
			array('label'=>Yii::t('ui','Star rating'), 'url'=>array('/site/widget', 'view'=>'starrating')),
		)),
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.CMenu', array(
	'items'=>array(
		array('label'=>Yii::t('ui','Home'), 'url'=>array('/site/index')),
		array('label'=>Yii::t('ui','Data Widgets'), 'items'=>array(
			array('label'=>Yii::t('ui','Tree view'), 'url'=>array('/site/widget', 'view'=>'treeview')),
			array('label'=>Yii::t('ui','Multilevel menu'), 'url'=>array('/site/widget', 'view'=>'menu')),
			array('label'=>Yii::t('ui','Breadcrumbs'), 'url'=>array('/site/widget', 'view'=>'breadcrumbs')),
		)),
		array('label'=>Yii::t('ui','Form Widgets'), 'items'=>array(
			array('label'=>Yii::t('ui','Masked textfield'), 'url'=>array('/site/widget', 'view'=>'maskedtextfield')),
			array('label'=>Yii::t('ui','Datepicker'), 'url'=>array('/site/widget', 'view'=>'datepicker')),
			array('label'=>Yii::t('ui','Star rating'), 'url'=>array('/site/widget', 'view'=>'starrating')),
		)),
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Items from database'); ?></h3>

<?php
$this->widget('zii.widgets.CMenu',array(
	'items'=>Menu::model()->getMenuItems(),
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('zii.widgets.CMenu',array(
	'items'=>Menu::model()->getMenuItems(),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/models/Menu.php: public function behaviors()
protected/extensions/behaviors/XTreeBehavior: public function getMenuItems()
</pre></div>