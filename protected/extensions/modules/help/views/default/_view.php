<h2>
	<?php echo $model->{'title_'.Yii::app()->language}; ?>
	<?php echo $this->getEditLink($model->id); ?>
</h2>
<?php echo $model->{'content_'.Yii::app()->language}; ?>