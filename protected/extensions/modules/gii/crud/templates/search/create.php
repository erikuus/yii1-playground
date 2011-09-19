<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'New {$this->modelClass}');\n"; ?>

<?php
echo "\$this->breadcrumbs=array(
	Yii::t('ui','Search Results')=>\$this->getReturnUrl(),
	Yii::t('ui','New {$this->modelClass}'),
);\n";
?>
?>

<h2><?php echo "<?php echo Yii::t('ui', 'New {$this->modelClass}'); ?>" ; ?></h2>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>