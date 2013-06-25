<?php
class ExtensionMenu extends XPortlet
{
	public $title='Extensions';

	public function getMenuData()
	{
		return array(
			array('label'=>'Data Extensions', 'items'=>array(
				array('label'=>Yii::t('ui','Dropdown menu'), 'url'=>array('/site/extension', 'view'=>'dropdownmenu')),
				array('label'=>Yii::t('ui','Action menu'), 'url'=>array('/site/extension', 'view'=>'actionmenu')),
				array('label'=>Yii::t('ui','Lang menu'), 'url'=>array('/site/extension', 'view'=>'langmenu')),
				array('label'=>Yii::t('ui','Batch menu'), 'url'=>array('/person/batch')),
				array('label'=>Yii::t('ui','Static map'), 'url'=>array('/site/extension', 'view'=>'staticmap')),
				array('label'=>Yii::t('ui','Charts'), 'url'=>array('/site/extension', 'view'=>'charts')),
				array('label'=>Yii::t('ui','Alpha pagination'), 'url'=>array('/person/alpha')),
			)),
			array('label'=>'Form Extensions', 'items'=>array(
				array('label'=>Yii::t('ui','WYSIWYG editor'), 'url'=>array('/site/extension', 'view'=>'wysiwyg')),
				array('label'=>Yii::t('ui','List builder'), 'url'=>array('/site/extension', 'view'=>'listbuilder')),
				array('label'=>Yii::t('ui','Input map'), 'url'=>array('/site/extension', 'view'=>'inputmap')),
				array('label'=>Yii::t('ui','Select2'), 'url'=>array('/site/extension', 'view'=>'select2')),
			)),
		);
	}

	protected function renderContent()
	{
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->getMenuData(),
		));
	}
}