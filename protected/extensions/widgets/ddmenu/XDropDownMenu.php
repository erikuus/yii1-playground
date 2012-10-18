<?php
/**
 * XDropDownMenu class file.
 *
 * CDropDownMenu is an extension to CMenu that supports Drop-Down Menus using the
 * superfish jquery-plugin.
 *
 * @author Herbert Maschke <thyseus@gmail.com>
 * @link http://www.yiiframework.com/
 */
Yii::import('zii.widgets.CMenu');
class XDropDownMenu extends CMenu
{
	public $cssFile = 'superfish.css';

	public function init()
	{
		parent::init();
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		$this->renderDropDownMenu($this->items);
	}

	protected function renderDropDownMenu($items)
	{
		//This will overwrite the class name provided in htmloptions of the menu by the user
		//$this->htmlOptions = array_merge($this->htmlOptions, array('class' => 'sf-menu'));

		//To account for if the user has provided the class value for htmlOptions of the menu
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions = array_merge($this->htmlOptions, array('class' => 'sf-menu'));
		else
			$this->htmlOptions['class'] .= ' sf-menu'; //attach sf-menu class to the user-provided values

		$this->renderMenu($items);

		$this->registerClientScript();
		echo '<br style="clear:both;" />';
	}

	protected function registerClientScript() {
		$assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendors';
		$baseUrl = Yii::app()->getAssetManager()->publish($assets);

		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerCssFile($baseUrl . '/' . $this->cssFile);
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'superfish.js',CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'hoverIntent.js',CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerScriptFile($baseUrl . '/' . 'CDropDownMenu.js',CClientScript::POS_HEAD);
	}

}
