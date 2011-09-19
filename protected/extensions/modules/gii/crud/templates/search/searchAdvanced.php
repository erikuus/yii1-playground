<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php \n\$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Search Results');\n"; ?>

<?php
echo "\$this->breadcrumbs=array(
	Yii::t('ui','Advanced Search')=>\$this->createUrl('site/searchAdvanced',\$_GET),
	Yii::t('ui','Search Results'),
);\n";
?>
?>

<h2><?php echo "<?php echo Yii::t('ui', 'Search Results'); ?>"; ?></h2>

<?php echo "<?php echo \$this->renderPartial('_grid', array('dataProvider'=>\$dataProvider)); ?>"; ?>