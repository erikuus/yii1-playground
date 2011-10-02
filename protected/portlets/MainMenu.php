<?php
class MainMenu extends CWidget
{
	public function run()
	{
		$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array(
					'label'=>Yii::t('ui', 'Home'),
					'url'=>array('/site/index'),
				),
				array(
					'label'=>Yii::t('ui', 'Widgets'),
					'url'=>array('/person/index'),
					'active'=>$this->isMenuItemActive(array(
						'site'=>array('widget'),
						'person'=>array('index','admin','view','update','create'),
					)),
				),
				array(
					'label'=>Yii::t('ui', 'Extensions'),
					'url'=>array('/site/extension','view'=>'dropdownmenu'),
					'active'=>$this->isMenuItemActive(array(
						'site'=>array('extension'),
						'person'=>array('alpha','batch'),
					)),
				),
				array(
					'label'=>Yii::t('ui', 'Modules'),
					'url'=>array('/lookup/default'),
					'active'=>$this->isMenuItemActive(array(
						'lookup/default'=>array('*'),
						'help/default'=>array('*'),
						'site'=>array('module'),
					)),
				),
				array(
					'label'=>Yii::t('ui', 'Contact'),
					'url'=>array('/site/contact')
				),
				array(
					'label'=>Yii::t('ui', 'Login'),
					'url'=>array('/site/login'),
					'visible'=>Yii::app()->user->isGuest,
				),
				array(
					'label'=>Yii::t('ui', 'Logout').' - '.Yii::app()->user->name,
					'url'=>array('/site/logout'),
					'visible'=>!Yii::app()->user->isGuest,
				),
			),
		));
	}

	/**
	 * Checks whether a menu item is active.
	 * This is done by checking if the currently requested URL matches given pattern of the menu item
	 * @param array the pattern to be checked ('controller'=>array('action1','action2') or 'controller'=>array('*'))
	 * @return boolean whether the menu item is active
	 */
	protected function isMenuItemActive($pattern)
	{
		$route=$this->controller->getRoute();
		foreach($pattern as $controller=>$actions)
		{
			foreach($actions as $action)
			{
				if($action=='*' && $this->controller->uniqueID==$controller)
				   return true;
				elseif($route==$controller.'/'.$action)
				   return true;
			}
		}
		return false;
	}
}
?>