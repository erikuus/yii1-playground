<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'New {$this->modelClass}');\n"; ?>

<?php
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('ui','Manage $label')=>array('admin'),
	Yii::t('ui','New {$this->modelClass}'),
);\n";
?>
?>

<h2><?php echo "<?php echo Yii::t('ui', 'New {$this->modelClass}'); ?>" ; ?></h2>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>