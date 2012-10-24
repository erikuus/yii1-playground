<?php
/**
 * XPortlet class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * XPortlet implements a base class for portlets.
 *
 * Each portlet is assumed to be composed by a title and some body content.
 * The title can be specified by setting the {@link title} property
 * while the body content is specified by overriding the {@link renderContent}
 * method.
 *
 * By setting {@link visible} to be false, the portlet can be hidden from display.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: $
 */
class XPortlet extends CWidget
{
	/**
	 * @var mixed the CSS file used for the portlet. Defaults to null, meaning
	 * using the default CSS file included together with the portlet.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this portlet.
	 */
	public $cssFile;
	/**
	 * @var boolean whether the portlet is visible. Defaults to true.
	 */
	public $visible=true;
	/**
	 * @var string the title of the portlet.
	 */
	public $title;
	/**
	 * @var string the CSS width of the portlet.
	 */
	public $width='100%';
	/**
	 * @var string the CSS class for the portlet container. Defaults to 'portlet'.
	 */
	public $cssClass='portlet';
	/**
	 * @var string the CSS class for the portlet header. Defaults to 'header'.
	 */
	public $headerCssClass='header';
	/**
	 * @var string the CSS class for the portlet content. Defaults to 'content'.
	 */
	public $contentCssClass='content';
	/**
	 * @var boolean whether to hide the portlet when the body content is empty. Defaults to true.
	 */
	public $hideOnEmpty=true;

	private $_openTag;

	/**
	 * Initializes the portlet.
	 * This renders the header part of the portlet, if it is visible.
	 */
	public function init()
	{
		if($this->visible)
		{
			ob_start();
			ob_implicit_flush(false);

			$cs=Yii::app()->clientScript;
			if($this->cssFile===null)
			{
				$cssFile=CHtml::asset(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'portlet.css');
				$cs->registerCssFile($cssFile);
			}
			else if($this->cssFile!==false)
				$cs->registerCssFile($this->cssFile);

			echo "<div class=\"{$this->cssClass}\" style=\"width:{$this->width}\">\n";
			if($this->title!==null)
				echo "<div class=\"{$this->headerCssClass}\">".$this->title."</div>\n";
			echo "<div class=\"{$this->contentCssClass}\">\n";

			$this->_openTag=ob_get_contents();
			ob_clean();
		}
	}

	/**
	 * Finishes rendering the portlet.
	 * This renders the body part of the portlet, if it is visible.
	 */
	public function run()
	{
		if($this->visible)
		{
			$this->renderContent();

			$content=ob_get_clean();
			if($this->hideOnEmpty&&trim($content)==='')
				return;
			echo $this->_openTag;

			echo $content;
			echo "</div><!-- {$this->contentCssClass} -->\n";
			echo "</div><!-- {$this->cssClass} -->";
		}
	}

	/**
	 * Renders the body part of the portlet.
	 * Child classes should override this method to provide customized body content.
	 */
	protected function renderContent()
	{
	}
}