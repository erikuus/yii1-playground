<?php
/**
 * XAlphaLinkPager class file.
 *
 * Strongly based on Qiang Xues {@link CLinkPager} from yiiframework.
 *
 * @author Jascha Koch
 * @license http://www.yiiframework.com/license/
 * @version 1.2
 */
class XAlphaLinkPager extends CBasePager
{
	const CSS_ALL_PAGE='all';
	const CSS_INTERNAL_PAGE='page';
	const CSS_HIDDEN_PAGE='hidden';
	const CSS_SELECTED_PAGE='selected';

	/**
	 * @var string the text label for the 'SHOW ALL'-button. Defaults to 'All'.
	 */
	public $allPageLabel;
	/**
	 * @var bool show the 'SHOW All'-button. Defaults to true.
	 */
	public $showAllPage=true;
	/**
	 * @var string the text label for the 'SHOW NUMERIC'-button. Defaults to '0-9'.
	 */
	public $numPageLabel;
	/**
	 * @var bool show the 'SHOW NUMERIC'-button. Defaults to false.
	 */
	public $showNumPage=false;
	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to letter: '.
	 */
	public $header;
	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer='';
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile;
	/**
	 * @var array HTML attributes for the pager container tag.
	 */
	public $htmlOptions=array();

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->allPageLabel===null)
			$this->allPageLabel=Yii::t('ui','All');
		if($this->numPageLabel===null)
			$this->numPageLabel=Yii::t('ui','0-9');
		if($this->header===null)
			$this->header=Yii::t('ui','Go to letter: ');

		if(!isset($this->htmlOptions['id']))
			$this->htmlOptions['id']=$this->getId();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='alphaPager';
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		$this->registerClientScript();
		echo $this->header;
		echo CHtml::tag('ul',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
	}

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		$buttons=array();
		$labels_comp = $labels = $this->pages->getCharSet();
		$activeLabels_comp = $activeLabels = $this->pages->getActiveCharSet();
		$labelCount = count($labels);
		$currentPage=$this->getCurrentPage(false);

		// show-all page
		if($this->showAllPage)
			$buttons[]=$this->createPageButton($this->allPageLabel,-1,self::CSS_ALL_PAGE,!count($activeLabels)>0,-1==$currentPage);

		// show-numeric page
		if($this->showNumPage)
			$buttons[]=$this->createPageButton($this->numPageLabel,0,self::CSS_ALL_PAGE,!$this->pages->activeNumbers,0==$currentPage);

		if($this->pages->forceCaseInsensitive===true){
			// convert all labels (characters) to lower case for case insensitive comparison
			$labels_comp = array_map('mb_strtolower',$labels);
			$activeLabels_comp = array_map('mb_strtolower',$activeLabels);
		}

		// internal pages
		for($i=0;$i<$labelCount;++$i)
			$buttons[]=$this->createPageButton($labels[$i],$i+1,self::CSS_INTERNAL_PAGE,!in_array($labels_comp[$i],$activeLabels_comp),$i+1==$currentPage);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string the text label for the button
	 * @param string the page letter
	 * @param string the CSS class for the page button. This could be 'page' or 'all'.
	 * @param boolean whether this page button is visible
	 * @param boolean whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
	}

	/**
	 * Registers the needed client scripts (mainly CSS file).
	 */
	public function registerClientScript()
	{
		if($this->cssFile!==false)
			self::registerCssFile($this->cssFile);
	}

	/**
	 * Registers the needed CSS file.
	 * @param string the CSS URL. If null, a default CSS URL will be used.
	 */
	public static function registerCssFile($url=null)
	{
		if($url===null)
			$url=CHtml::asset(dirname(__FILE__).'/alphapager.css');
		Yii::app()->getClientScript()->registerCssFile($url);
	}
}
?>