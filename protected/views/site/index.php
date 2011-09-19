<?php $this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui','Home'); ?>

<h2><?php echo Help::item('annotation','title',!Yii::app()->user->isGuest); ?></h2>
<div class="large-text"><?php echo Help::item('annotation','content'); ?></div>