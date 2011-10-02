<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Dropdown menu');
$this->layout='leftbar';
$this->leftPortlets['ptl.ExtensionMenu']=array();
?>

<h2><?php echo Yii::t('ui','Dropdown menu');?></h2>
<h3><?php echo Yii::t('ui','Static items');?></h3>

<?php $this->widget('ext.widgets.ddmenu.XDropDownMenu', array(
	'items'=>array(
		array('label'=>'Home', 'url'=>array('site/index')),
		array('label'=>'Data Widgets','url'=>'#','items'=>array(
			array('label'=>'List view', 'url'=>array('/person/index')),
			array('label'=>'Grid view', 'url'=>array('/person/admin')),
			array('label'=>'Detail view', 'url'=>array('/person/view', 'id'=>1)),
			array('label'=>'Tree view', 'url'=>array('/site/widget', 'view'=>'treeview')),
			array('label'=>'Multilevel menu', 'url'=>array('/site/widget', 'view'=>'menu')),
			array('label'=>'Breadcrumbs', 'url'=>array('/site/widget', 'view'=>'breadcrumbs')),
		)),
		array('label'=>'Form Widgets','url'=>'#','items'=>array(
			array('label'=>'Autocomplete', 'url'=>array('/site/widget', 'view'=>'autocomplete')),
			array('label'=>'Masked textfield', 'url'=>array('/site/widget', 'view'=>'maskedtextfield')),
			array('label'=>'Multiple file upload', 'url'=>array('/site/widget', 'view'=>'multifileupload')),
			array('label'=>'Datepicker', 'url'=>array('/site/widget', 'view'=>'datepicker')),
			array('label'=>'Star rating', 'url'=>array('/site/widget', 'view'=>'starrating')),
		)),
	),
)); ?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.ddmenu.XDropDownMenu', array(
	'items'=>array(
		array('label'=>'Home', 'url'=>array('site/index')),
		array('label'=>'Data Widgets','url'=>'#','items'=>array(
			array('label'=>'List view', 'url'=>array('/person/index')),
			array('label'=>'Grid view', 'url'=>array('/person/admin')),
			array('label'=>'Detail view', 'url'=>array('/person/view', 'id'=>3)),
			array('label'=>'Tree view', 'url'=>array('/site/widget', 'view'=>'treeview')),
			array('label'=>'Multilevel menu', 'url'=>array('/site/widget', 'view'=>'menu')),
			array('label'=>'Breadcrumbs', 'url'=>array('/site/widget', 'view'=>'breadcrumbs')),
		)),
		array('label'=>'Form Widgets','url'=>'#','items'=>array(
			array('label'=>'Autocomplete', 'url'=>array('/site/widget', 'view'=>'autocomplete')),
			array('label'=>'Masked textfield', 'url'=>array('/site/widget', 'view'=>'maskedtextfield')),
			array('label'=>'Multiple file upload', 'url'=>array('/site/widget', 'view'=>'multifileupload')),
			array('label'=>'Datepicker', 'url'=>array('/site/widget', 'view'=>'datepicker')),
			array('label'=>'Star rating', 'url'=>array('/site/widget', 'view'=>'starrating')),
		)),
	),
));
<?php $this->endWidget(); ?>
</div>

<br />

<h3><?php echo Yii::t('ui','Items from database');?></h3>

<?php
$this->widget('ext.widgets.ddmenu.XDropDownMenu', array(
	'items'=>Menu::model()->getMenuItems(27, false),
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.ddmenu.XDropDownMenu', array(
	'items'=>Menu::model()->getMenuItems(27, false),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/models/Menu.php
protected/extensions/behaviors/XTreeBehavior
</pre></div>
