<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Menu {$this->modelClass}');\n"; ?>

<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('ui','$label')=>array('index'),
	Yii::t('ui','Menu'),
);\n";
?>
?>

<h2><?php echo "<?php echo Yii::t('ui', 'Menu {$this->modelClass}'); ?>" ; ?></h2>

<?php echo "<?php\n"; ?>
$this->widget('zii.widgets.CMenu',array(
	'items'=><?php echo $this->modelClass; ?>::model()->menuItems,
));

?>