<?php $this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Login'); ?>

<h1><?php echo Yii::t('ui', 'Login'); ?></h1>

<div class="form" style="width: 400px;">

<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($form); ?>

	<div class="simple">
		<?php echo CHtml::activeLabel($form,'username'); ?>
		<?php echo CHtml::activeTextField($form,'username') ?>
	</div>

	<div class="simple">
		<?php echo CHtml::activeLabel($form,'password'); ?>
		<?php echo CHtml::activePasswordField($form,'password') ?>
	</div>

	<div class="action">
		<?php echo CHtml::activeCheckBox($form,'rememberMe'); ?>
		<?php echo CHtml::activeLabel($form,'rememberMe'); ?>
	</div>

	<div class="action">
		<?php echo CHtml::submitButton(Yii::t('ui', 'Login')); ?>
	</div>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->