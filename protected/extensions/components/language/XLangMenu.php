<?php
/**
 * XLangMenu displays a language menu.
 *
 * XLangMenu depends on and must be used together with XUrlManager.
 *
 * The following minimal example shows how to use XLangMenu:
 * <pre>
 * $this->widget('ext.components.language.XLangMenu', array(
 *     'items'=>array('et'=>'Eesti','en'=>'In English)
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XLangMenu extends CWidget
{
	/**
	 * @var id for the container. Defaults to 'langmenu'.
	 */
	public $id='langmenu';
	/**
	 * @var array list of menu items. Each menu item is specified as an array of name-value pairs.
	 * For example: array('et'=>'EST', 'en'=>'ENG')
	 */
	public $items=array();
	/**
	 * @var boolean whether to encode label
	 */
	public $encodeLabel=true;
	/**
	 * @var boolean whether to hide active language
	 */
	public $hideActive=true;
	/**
	 * @var string separator of menu links
	 */
	public $separator=' | ';

	public function run()
	{
		echo "<div id=\"{$this->id}\">\n";

		$count=1;
		$itemsCount=count($this->items);
		if($this->hideActive===true)
			$itemsCount--;

		$params=$_GET;
		foreach($this->items as $language=>$label)
		{
			if($language!=Yii::app()->language || $this->hideActive===false)
			{
				$params['language']=$language;
				$url=$this->controller->createUrl('', $params);

				if($this->encodeLabel===true)
					$label=CHtml::encode($label);

				echo CHtml::link($label, $url);

				if($count < $itemsCount)
					echo '<span class="sep">'.$this->separator.'</span>';

				$count++;
			}
		}

		echo "\n</div>\n";
	}
}