<?php
class ModuleMenu extends XPortlet
{
	public $title='Modules';

	public function getMenuData()
	{
		return array(
			array('label'=>Yii::t('ui','Classificators'),'url'=>array('/lookup/default/index'),'items'=>array(
				array('label'=>Yii::t('ui','Configuration'),'url'=>array('/site/module', 'view'=>'lookup_config'),'linkOptions'=>array('style'=>'color:green')),
				array('label'=>Yii::t('ui','Imported functions'),'url'=>array('/site/module', 'view'=>'lookup_import'),'linkOptions'=>array('style'=>'color:green')),
			)),
			array('label'=>Yii::t('ui','Helps'),'url'=>array('/help/default/admin'),'items'=>array(
				array('label'=>Yii::t('ui','Configuration'),'url'=>array('/site/module', 'view'=>'help_config'),'linkOptions'=>array('style'=>'color:green')),
				array('label'=>Yii::t('ui','Imported functions'),'url'=>array('/site/module', 'view'=>'help_import'),'linkOptions'=>array('style'=>'color:green')),
			)),
		);
	}

	protected function renderContent()
	{
		$this->widget('zii.widgets.CMenu', array(
			'encodeLabel'=>false,
			'items'=>$this->getMenuData(),
		));
	}
}