<?php $this->beginContent(); ?>

<?php if(Yii::app()->layout=='print'): ?>

	<?php echo $content; ?>

<?php else: ?>

	<div class="container_16">
		<div class="grid_13 alpha">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array('links'=>$this->breadcrumbs)); ?>
			<?php echo $content; ?>
		</div>
		<div class="grid_3 omega">
			<?php foreach($this->rightPortlets as $class=>$properties) $this->widget($class,$properties); ?>
		</div>
	</div>
	<div class="clear"></div>

	<?php endif; ?>

<?php $this->endContent(); ?>