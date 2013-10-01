<?php
$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('ui', 'Tabular Inputs');
$this->layout='leftbar';
$this->leftPortlets['application.portlets.ExtensionMenu']=array();

// set demo value
$persons=array(
	Person::model()->findbyPk(1),
	Person::model()->findbyPk(2)
);
$persons2=array(
	Person2::model()->findbyPk(1),
	Person2::model()->findbyPk(2),
	Person2::model()->findbyPk(3),
	Person2::model()->findbyPk(4)
);
?>

<h2><?php echo Yii::t('ui','Tabular Inputs'); ?></h2>

<h3>Basic Example</h3>
<p>minimal configuration, no style</p>

<div class="form">
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput',array(
		'models'=>$persons,
		'inputView'=>'extensions/_tabularInput',
		'inputUrl'=>$this->createUrl('request/addTabularInputs'),
		'removeTemplate'=>'<div class="action">{link}</div>',
		'addTemplate'=>'<div class="action">{link}</div>',
	));	?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.tabularinput.XTabularInput',array(
	'models'=>$persons,
	'inputView'=>'extensions/_tabularInput',
	'inputUrl'=>$this->createUrl('request/addTabularInputs'),
	'removeTemplate'=>'<div class="action">{link}</div>',
	'addTemplate'=>'<div class="action">{link}</div>',
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
/protected/extensions/widgets/tabularinput/XTabularInput.php
/protected/views/site/extensions/_tabularInput.php
/protected/controllers/RequestController.php
/protected/extensions/actions/XTabularInputAction.php
</pre></div>

<br />

<h3>Advanced Example</h3>
<p>tabular inputs configured into table layout, buttons styled, autocomplete widget used in dynamic rows</p>

<div class="form">
	<?php $this->widget('ext.widgets.tabularinput.XTabularInput',array(
		'models'=>$persons2,
		'containerTagName'=>'table',
		'headerTagName'=>'thead',
		'header'=>'
			<tr>
				<td>'.CHtml::activeLabelEX(Person::model(),'firstname').'</td>
				<td>'.CHtml::activeLabelEX(Person::model(),'lastname').'</td>
				<td>'.CHtml::activeLabelEX(Person::model(),'eyecolor_code').'</td>
				<td></td>
			</tr>
		',
		'inputContainerTagName'=>'tbody',
		'inputTagName'=>'tr',
		'inputView'=>'extensions/_tabularInputAsTable',
		'inputUrl'=>$this->createUrl('request/addTabularInputsAsTable'),
		'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
		'addLabel'=>Yii::t('ui','Add new row'),
		'addHtmlOptions'=>array('class'=>'blue pill full-width'),
		'removeTemplate'=>'<td>{link}</td>',
		'removeLabel'=>Yii::t('ui','Delete'),
		'removeHtmlOptions'=>array('class'=>'red pill'),
	));	?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','View code'); ?></div>
<?php $this->beginWidget('CTextHighlighter',array('language'=>'PHP')); ?>
$this->widget('ext.widgets.tabularinput.XTabularInput',array(
	'models'=>$persons2,
	'containerTagName'=>'table',
	'headerTagName'=>'thead',
	'header'=>'
		<tr>
			<td>'.CHtml::activeLabelEX(Person::model(),'firstname').'</td>
			<td>'.CHtml::activeLabelEX(Person::model(),'lastname').'</td>
			<td>'.CHtml::activeLabelEX(Person::model(),'eyecolor_code').'</td>
			<td></td>
		</tr>
	',
	'inputContainerTagName'=>'tbody',
	'inputTagName'=>'tr',
	'inputView'=>'extensions/_tabularInputAsTable',
	'inputUrl'=>$this->createUrl('request/addTabularInputsAsTable'),
	'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
	'addLabel'=>Yii::t('ui','Add new row'),
	'addHtmlOptions'=>array('class'=>'blue pill full-width'),
	'removeTemplate'=>'<td>{link}</td>',
	'removeLabel'=>Yii::t('ui','Delete'),
	'removeHtmlOptions'=>array('class'=>'red pill'),
));
<?php $this->endWidget(); ?>
</div>

<div class="tpanel">
<div class="toggle"><?php echo Yii::t('ui','Browse code'); ?></div>
<pre>
/protected/extensions/widgets/tabularinput/XTabularInput.php
/protected/views/site/extensions/_tabularInputAsTable.php
/protected/controllers/RequestController.php
/protected/extensions/actions/XTabularInputAction.php
</pre></div>

<br />