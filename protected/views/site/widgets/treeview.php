<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Tree view');
$this->layout = 'leftbar';
$this->leftPortlets['application.portlets.WidgetMenu'] = array();

$cs=Yii::app()->clientScript;
$cs->registerScript('menuTreeClick', "
	jQuery('#menu-treeview a').click(function() {
		alert('Node #'+this.id+' was clicked!');
		return false;
	});
");
$cs->registerScript('unitTreeClick', "
	jQuery('#unit-treeview a').live('click',function(){
	   jQuery.ajax({
		   url:'".$this->createUrl('request/treePath')."',
		   data:{'id':this.id},
		   cache:false,
		   success:function(data){alert(data);},
		   error:function(){alert('Error!');}
	   });
	   return false;
	});
");
?>

<h2><?php echo Yii::t('ui','Tree view');?></h2>

<h3><?php echo Yii::t('ui','Tree from Database');?></h3>

<div id="treecontrol">
	<a href="#"><?php echo Yii::t('ui','Collapse All');?></a> |
	<a href="#"><?php echo Yii::t('ui','Expand All');?></a>
</div>

<?php
$this->widget('CTreeView',array(
	'id'=>'menu-treeview',
	'data'=>Menu::model()->getTreeItems(),
	'control'=>'#treecontrol',
	'animated'=>'fast',
	'collapsed'=>true,
	'htmlOptions'=>array(
		'class'=>'filetree'
	)
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CTreeView',array(
	'id'=>'menu-treeview',
	'data'=>Menu::model()->getTreeItems(),
	'control'=>'#treecontrol',
	'animated'=>'fast',
	'collapsed'=>true,
	'htmlOptions'=>array(
		'class'=>'filetree'
	)
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/models/Menu.php: public function behaviors()
protected/extensions/behaviors/XTreeBehavior: public function getTreeItems()
</pre></div>

<br />

<h3><?php echo Yii::t('ui','Tree Ajax from Database');?></h3>

<?php
$this->widget('CTreeView',array(
	'id'=>'unit-treeview',
	'url'=>array('request/fillTree'),
	'htmlOptions'=>array(
		'class'=>'treeview-red'
	)
));
?>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('CTreeView',array(
	'id'=>'unit-treeview',
	'url'=>array('request/fillTree'),
	'htmlOptions'=>array(
		'class'=>'treeview-red'
	)
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
protected/controllers/RequestController.php
protected/extensions/actions/XFillTreeAction
protected/models/Menu.php: public function behaviors()
protected/extensions/behaviors/XTreeBehavior: public function fillTree()
</pre></div>

<br />

<h3><?php echo Yii::t('ui','Read more'); ?></h3>

<a target="_blank"
	href="http://bassistance.de/jquery-plugins/jquery-plugin-treeview/">http://bassistance.de/jquery-plugins/jquery-plugin-treeview/</a>