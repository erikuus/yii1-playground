<?php
/**
 * XEditableWidget class file.
 *
 * This widget encapsulates the [Jeditable](http://www.appelsiini.net/projects/jeditable)
 * library in a CInputWidget, so the widget can be used in CForm definitions and views.
 *
 * The saveurl parameter expected by Jeditable (the first parameter to the editable call)
 * defaults to $_SERVER['REQUEST_URI'] if not provided in the config of the widget.
 *
 * Three Jeditable parameters have changed names to avoid collision with CInputWidget attributes:
 * id renamed to jeditable_id
 * name renamed to jeditable_name
 * type renamed to jeditable_type
 *
 * The jeditable_id parameter which contains the id defaults to 'attribute' so as not to collide
 * with the $_GET parameter, which usually decides which record you're editing.
 *
 * See the following code examples:
 * In a form definition:
 * <pre>
 *     return array(
 *       'name'=>array(
 *         'type'=>'application.extensions.ds.jeditable.DsJEditableWidget',
 *         'jeditable_type'=>'text'
 *       )
 *     );
 * </pre>
 * In a view:
 * <pre>
 *     $this->widget('application.extensions.ds.jeditable.DsJEditableWidget', array(
 *       'jeditable_type' => 'text'
 *     ))
 * </pre>
 *
 * Further documentation and examples of usage can be found at the [Jeditable home page]
 * (http://www.appelsiini.net/projects/jeditable). Remember to use jeditable_id, jeditable_name
 * and jeditable_type wherever it uses id, name or type in the examples. 
 */
class XEditableWidget extends CInputWidget
{		
	/**
	 * @var the URL the editable content is saved to
	 */
	public $saveurl=null;
	/**
	 * @var method to use when submitting edited content.
	 */	
	public $method='POST';
	/**
	 * @var method to use when submitting edited content.
	 * Function is called after form has been submitted.
	 * Callback function receives two parameters.
	 * Value contains submitted form content.
	 * Settings contain all plugin settings.
	 * Inside function this refers to the original element.
	 */
	public $callback=null;
	/**
	 * @var name of the submitted parameter which contains edited content.
	 */		
	public $jeditable_name='value';
	/**
	 * @var name of the submitted parameter which contains id.
	 */		
	public $jeditable_id='attribute';
	/**
	 * @var extra parameters when submitting content.
	 * Can be either a hash or function returning a hash.
	 */		
	public $submitdata=null;
	/**
	 * @var input type to use. Default input types are text, textarea or select.
	 */		
	public $jeditable_type='text';
	/**
	 * @var number of rows if using textarea.
	 */		
	public $rows=null;
	/**
	 * @var number of columns if using textarea.
	 */		
	public $cols=null;
	/**
	 * @var height of the input element in pixels.
	 * Can also be set to none.
	 */		
	public $height='auto';
	/**
	 * @var width of the input element in pixels.
	 * Can also be set to none.
	 */		
	public $width='auto';
	/**
	 * @var load content of the element from an external URL.
	 */		
	public $loadurl=null;
	/**
	 * @var request type to use when using loadurl.
	 */		
	public $loadtype='GET';
	/**
	 * @var extra parameters to add to request when using loadurl.
	 */		
	public $loaddata=null;
	/**
	 * @var form data passed as parameter. Can be either a string or function returning a string.
	 */	
	public $data=null;
	/**
	 * @var name of the submit button
	 */		
	public $submit=null;
	/**
	 * @var name of the cancel button
	 */		
	public $cancel=null;
	/**
	 * @var text of the tooltip
	 */		
	public $tooltip=null;
	/**
	 * @var saving indicator
	 */		
	public $indicator=null;
	/**
	 * @var boolean whether the content is editable. Defaults to true.
	 */
	public $editable=true;
	/**
	 * @var boolean whether to use CMarkdown parser on response. Defaults to false.
	 */
	public $markdown=false;
	/**
	 * @var boolean whether to use CMarkdown safeTransform method. Defaults to false.
	 * This method calls the transform() method to convert markdown content into HTML content. 
	 * It then uses CHtmlPurifier to purify the HTML content to avoid XSS attacks.
	 * Note: since HTML Purifier is a big package, its performance is not very good.
	 */
	public $safeTransform=false;

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		if($this->editable)
		{
			list($name,$id)=$this->resolveNameID();
			if(!isset($this->htmlOptions['id']))
				$this->htmlOptions['id']=$id;
			if(!isset($this->htmlOptions['name']))
				$this->htmlOptions['name']=$name;
	
			$this->registerClientScript();
			$this->renderContent();
		}
		else
			$this->renderContent();		
	}

	/**
	 * Render content
	 */   
	protected function renderContent()
	{
		if($this->hasModel())
			echo CHtml::tag('div',$this->htmlOptions,$this->prepareContent($this->model->{$this->attribute}));
		else
			echo CHtml::tag('div',$this->htmlOptions,$this->prepareContent($this->value));
	}

	/**
	 * Prepare content
	 * @return string content
	 */   
	protected function prepareContent($value)
	{
		if($this->markdown)
		{
			$parser=new CMarkdownParser();
			return $this->safeTransform ? $parser->safeTransform($value) : $parser->transform($value);
		}
		else
			return CHtml::encode($value);
	}
	
	/**
	 * Registers necessary client scripts.
	 */
	protected function registerClientScript()
	{
		$id=empty($this->htmlOptions['id']) ? $this->id : $this->htmlOptions['id'];
		$saveurl=empty($this->saveurl) ? $_SERVER['REQUEST_URI'] : $this->saveurl;
		$miOptions=$this->getClientOptions();
		$options=$miOptions!==array() ? ','.CJavaScript::encode($miOptions) : '';
		$js="jQuery(\"#{$id}\").editable(\"{$saveurl}\"{$options});";

		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/jquery.jeditable.mini.js'));
		$cs->registerScript('EditableInputElement#'.$id,$js);
	}

	/**
	 * @return array the options for the text field
	 */
	protected function getClientOptions()
	{
		$options=array();

		foreach(array('method','submitdata','rows','cols','height','width','loadurl','loadtype','loaddata','data','submit','cancel','tooltip','indicator') as $property)
		{
			$this->$property===null or $options[$property]=$this->$property;
		}

		$options['id']=$this->jeditable_id;
		$options['name']=$this->jeditable_name;
		$options['type']=$this->jeditable_type;

		if(is_string($this->callback))
		{
			if(strncmp($this->callback,'js:',3))
				$options['callback']='js:'.$this->callback;
			else
				$options['callback']=$this->callback;
		}

		return $options;
	}
}
