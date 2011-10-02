<?php
/**
 * XMultiSelects class file
 *
 * This widget is used to transfer options between two select filed
 *
 * Usage
 * <pre>
 * $this->widget('ext.widgets.multiselects.XMultiSelects',array(
 *     'leftTitle'=>'Australia',
 *     'leftName'=>'Person[australia][]',
 *     'leftList'=>Person::model()->findUsersByCountry(14),
 *     'rightTitle'=>'New Zealand',
 *     'rightName'=>'Person[newzealand][]',
 *     'rightList'=>Person::model()->findUsersByCountry(158),
 *     'size'=>20,
 *     'width'=>'200px',
 * ));
 * </pre>
 */
class XMultiSelects extends CWidget
{
	/**
	 * The label for the left mutiple select
	 * option
	 * @var string
	 */
	public $leftTitle;
	/**
	 * The label for the right mutiple select
	 * option
	 * @var string
	 */
	public $rightTitle;
	/**
	 * The name for the left mutiple select
	 * require
	 * @var string
	 */
	public $leftName;
	/**
	 * The name for the right mutiple select
	 * require
	 * @var string
	 */
	public $rightName;
	/**
	 * data for generating the left list options
	 * require
	 * @var array
	 */
	public $leftList;
	/**
	 * data for generating the right list options
	 * require
	 * @var array
	 */
	public $rightList;
	/**
	 * The size for the multiple selects.
	 * option
	 * @var integer
	 */
	public $size=15;

	/**
	 * The width for the multiple selects.
	 * option
	 * @var string
	 */
	public $width;

	/**
	 * register clientside widget files
	 */
	protected function registerClientScript()
	{
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/jquery.multiselects.js'));
	}

	/**
	 * Initializes the widget
	 */
	public function init()
	{
		if(!isset($this->leftName))
		{
			throw new CHttpException(500,'"leftName" have to be set!');
		}
		if(!isset($this->rightName))
		{
			throw new CHttpException(500,'"rightName" have to be set!');
		}
		if(!isset($this->leftList))
		{
			throw new CHttpException(500,'"leftList" have to be set!');
		}
		if(!isset($this->rightList))
		{
			throw new CHttpException(500,'"rightList" have to be set!');
		}
	}

	/**
	 * Run the widget
	 */
	public function run()
	{
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
		echo "<tr>\n";
		echo "<td>\n";
		if(isset($this->leftTitle))
		{
			echo "<label for=\"leftTitle\">{$this->leftTitle}</label><br />\n";
		}
		echo "<select name=\"{$this->leftName}\" id=\"select_left\" multiple=\"multiple\" size=\"{$this->size}\" style=\"width:{$this->width}\">\n";
		foreach($this->leftList as $value=>$label)
		{
			echo "<option value=\"{$value}\">{$label}</option>\n";
		}
		echo "</select></td>\n";

		echo "<td style=\"width:60px; text-align:center; vertical-align:middle\">\n";
		echo "<input type=\"button\" style=\"width:40px\" id=\"options_left\" value=\"&lt;\" /><br /><br />\n";
		echo "<input type=\"button\" style=\"width:40px\" id=\"options_right\" value=\"&gt;\" /><br /><br />\n";
		echo "<input type=\"button\" style=\"width:40px\" id=\"options_left_all\" value=\"&lt;&lt;\" /><br /><br />\n";
		echo "<input type=\"button\" style=\"width:40px\" id=\"options_right_all\" value=\"&gt;&gt;\" /><br /><br /></td>\n";

		echo "<td>\n";
		if(isset($this->rightTitle))
		{
			echo "<label for=\"rightTitle\">{$this->rightTitle}</label><br />\n";
		}
		echo "<select name=\"{$this->rightName}\" id=\"select_right\" multiple=\"multiple\" size=\"{$this->size}\" style=\"width:{$this->width}\">\n";
		foreach($this->rightList as $value=>$label)
		{
			echo "<option value=\"{$value}\">{$label}</option>\n";
		}
		echo "</select></td>\n";
		echo "</tr></table>\n";

		$this->registerClientScript();

		echo "<script type=\"text/javascript\"><!--\n";
		echo "\$(function() {\n";
		echo "\$(\"#select_left\").multiSelect(\"#select_right\", {trigger: \"#options_right\"});\n";
		echo "\$(\"#select_right\").multiSelect(\"#select_left\", {trigger: \"#options_left\"});\n";
		echo "\$(\"#select_left\").multiSelect(\"#select_right\", {allTrigger:\"#options_right_all\"});\n";
		echo "\$(\"#select_right\").multiSelect(\"#select_left\", {allTrigger:\"#options_left_all\"});\n";
		echo "});\n";
		echo "// --></script>\n";
		parent::init();
	}

	protected function renderContent()
	{
	}
}