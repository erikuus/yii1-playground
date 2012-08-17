<?php echo "<?php\n"; ?>

$this->widget('CTreeView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-treeview',
	'url'=>array('fillTree')
));

//For small tree you can use CTreeView with prepared data
//$this->widget('CTreeView',array(
//	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-treeview',
//	'data'=><?php echo $this->modelClass; ?>::model()->getTreeItems(),
//	'collapsed'=>true,
//));
?>