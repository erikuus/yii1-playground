<?php
/**
 * XAlphaListPager class file.
 *
 * Strongly based on Qiang Xues {@link CListPager} from yiiframework.
 *
 * @author Jascha Koch
 * @license http://www.yiiframework.com/license/
 * @version 1.2
 */
class XAlphaListPager extends CBasePager
{
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
	 * @var string the text displayed as a prompt option in the dropdown list. Defaults to null, meaning no prompt.
	 */
	public $promptText;
	/**
	 * @var string the format string used to generate page selection text.
	 * The sprintf function will be used to perform the formatting.
	 */
	public $pageTextFormat;
	/**
	 * @var string the text shown before page buttons. Defaults to 'Go to letter: '.
	 */
	public $header;
	/**
	 * @var string the text shown after page buttons.
	 */
	public $footer='';
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
		if($this->promptText!==null)
			$this->htmlOptions['prompt']=$this->promptText;
		if(!isset($this->htmlOptions['onchange']))
			$this->htmlOptions['onchange']="if(this.value!='') {window.location=this.value;};";
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$labels_comp = $labels = $this->pages->getCharSet();
		$activeLabels_comp = $activeLabels = $this->pages->getActiveCharSet();
		$labelCount = count($labels);
		$currentPage=$this->getCurrentPage(false);

		if($labelCount<=1)
			return;
		$pages=array();
		$disabledOptions=array();

		if($this->pages->forceCaseInsensitive===true){
			// convert all labels (characters) to lower case for case insensitive comparison
			$labels_comp = array_map('mb_strtolower',$labels);
			$activeLabels_comp = array_map('mb_strtolower',$activeLabels);
		}

		if($this->showAllPage){
			$pages[$this->createPageUrl(-1)]=$this->allPageLabel;
			if(!count($activeLabels)>0)
				$disabledOptions[$this->createPageUrl(-1)] = array('disabled'=>true);
		}

		if($this->showNumPage){
			$pages[$this->createPageUrl(0)]=$this->numPageLabel;
			if(!$this->pages->activeNumbers)
				$disabledOptions[$this->createPageUrl(0)] = array('disabled'=>true);
		}

		for($i=0;$i<$labelCount;++$i)
		{
			$pages[$this->createPageUrl($i+1)]=$this->generatePageText($labels[$i]);
			if(!in_array($labels_comp[$i],$activeLabels_comp))
				$disabledOptions[$this->createPageUrl($i+1)] = array('disabled'=>true);
		}

		if(!empty($disabledOptions))
			$this->htmlOptions['options'] = array_merge((array)$this->htmlOptions['options'],$disabledOptions);

		$selection=$this->createPageUrl($currentPage);
		echo $this->header;
		echo CHtml::dropDownList($this->getId(),$selection,$pages,$this->htmlOptions);
		echo $this->footer;
	}

	/**
	 * Generates the list option for the specified page number.
	 * You may override this method to customize the option display.
	 * @param string page character
	 * @return string the list option for the page character
	 */
	protected function generatePageText($label)
	{
		if($this->pageTextFormat!==null)
			return sprintf($this->pageTextFormat,$label);
		else
			return $label;
	}
}
?>