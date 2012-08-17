<?php
/**
 * XActionMenu displays an one-level menu.
 *
 * XActionMenu is simplified version of CMenu.
 * XActionMenu dispalys menu items separated by separator.
 *
 * The following example shows how to use XActionMenu:
 * <pre>
 * $this->widget('ext.widgets.amenu.XActionMenu', array(
 *     'items'=>array(
 *         array('label'=>'Home', 'url'=>array('site/index')),
 *         array('label'=>'Products', 'url'=>array('product/index'), 'linkOptions'=>array('onclick'=>'alert();')),
 *         array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
 *     ),
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.1
 */
class XActionMenu extends CWidget
{
	/**
	 * @var array list of menu items. Each menu item is specified as an array of name-value pairs.
	 * Possible option names include the following:
	 * <ul>
	 * <li>label: string, required, specifies the menu item label. When {@link encodeLabel} is true, the label
	 * will be HTML-encoded.</li>
	 * <li>url: string or array, optional, specifies the URL of the menu item. It is passed to {@link CHtml::normalizeUrl}
	 * to generate a valid URL. If this is not set, the menu item will be rendered as a span text.</li>
	 * <li>visible: boolean, optional, whether this menu item is visible. Defaults to true.
	 * This can be used to control the visibility of menu items based on user permissions.</li>
	 * <li>template: string, optional, the template used to render this menu item.
	 * In this template, the token "{menu}" will be replaced with the corresponding menu link or text.
	 * Please see {@link itemTemplate} for more details. This option has been available since version 1.1.1.</li>
	 * <li>linkOptions: array, optional, additional HTML attributes to be rendered for the link or span tag of the menu item.</li>
	 * </ul>
	 */
	public $items=array();
	/**
	 * @var string the template used to render an individual menu item. In this template,
	 * the token "{menu}" will be replaced with the corresponding menu link or text.
	 * If this property is not set, each menu will be rendered without any decoration.
	 * This property will be overridden by the 'template' option set in individual menu items via {@items}.
	 */
	public $itemTemplate;
	/**
	 * @var boolean whether the widget is visible. Defaults to true.
	 */
	public $visible=true;
	/**
	 * @var boolean whether the labels for menu items should be HTML-encoded. Defaults to true.
	 */
	public $encodeLabel=true;
	/**
	 * @var string the menu's root container tag name. Defaults 'div'.
	 * If this property is set to null, no container is used.
	 */
	public $containerTag='div';
	/**
	 * @var array HTML attributes for the menu's root container tag
	 */
	public $htmlOptions=array('class'=>'actionMenu');
	/**
	 * @var string separator of menu links
	 */
	public $separator='<span class="sep"> | </span>';

	/**
	 * Initializes the menu widget.
	 * This method mainly normalizes the {@link items} property.
	 * If this method is overridden, make sure the parent implementation is invoked.
	 */
	public function init()
	{
		if($this->visible)
		{
			$this->htmlOptions['id']=$this->getId();
			$this->items=$this->normalizeItems($this->items);
		}
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		if($this->visible)
			$this->renderMenu($this->items);
	}

	/**
	 * Renders the menu items.
	 * @param array menu items. Each menu item will be an array with at least two elements: 'label' and 'url'.
	 * It may have optional elements: 'visible','linkOptions', 'template'.
	 */
	protected function renderMenu($items)
	{
		if(count($items))
		{
			if($this->containerTag)
				echo CHtml::openTag($this->containerTag,$this->htmlOptions)."\n";
			$this->renderMenuItems($items);
			if($this->containerTag)
				echo CHtml::closeTag($this->containerTag);
		}
	}

	/**
	 * Recursively renders the menu items.
	 * @param array the menu items to be rendered recursively
	 */
	protected function renderMenuItems($items)
	{
		$count=1;
		foreach($items as $item)
		{
			if(isset($item['url']))
				$menu=CHtml::link($item['label'],$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
			else
				$menu=CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			if($count < count($items))
				echo $this->separator;
			$count++;
		}
	}

	/**
	 * Normalizes the items property.
	 * @param array the items to be normalized.
	 * @return array the normalized menu items
	 */
	protected function normalizeItems($items)
	{
		foreach($items as $i=>$item)
		{
			if(isset($item['visible']) && !$item['visible'])
			{
				unset($items[$i]);
				continue;
			}
			if($this->encodeLabel)
				$items[$i]['label']=CHtml::encode($item['label']);
		}
		return array_values($items);
	}
}