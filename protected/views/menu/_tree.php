<?php
//$this->widget('CTreeView',array(
//	'id'=>'menu-treeview',
//	'data'=>Menu::model()->getTreeItems(),
//	'collapsed'=>true,
//));
$this->widget('CTreeView',array(
	'id'=>'menu-treeview',
	'url'=>array('fillTree')
));
?>