<?php
/**
 * XHeditor wrapper class file for Yii framework.
 * Creates xhEditor {@link http://xheditor.com/} WYSIWYG editor.
 * Supports skins, different languages, model->attribute use,
 * configurable panel elements.
 * @author Robert Campbell <waprave@gmail.com>
 * @author Evgeny Lexunin <lexunin@gmail.com>
 * @link http://xheditor.com/
 * @link http://www.yiiframework.com/
 * @since 1.0
 */

/**
 * Changed list of configurable attributes
 * Added upLinkUrl,upLinkExt,upImgUrl,upImgExt,upFlashUrl,upFlashExt,upMediaUrl,upMediaExt,plugins
 * @author Erik Uus <erik.uus@gmail.com>
 */

/*
Usage:

$this->widget('ext.widgets.xheditor.XHeditor',array(
	'language'=>'en', // en, zh-cn, zh-tw, ru
	'config'=>array(
		'id'=>'xh1',
		'name'=>'xh',
		'skin'=>'o2007silver', // default, nostyle, o2007blue, o2007silver, vista
		'tools'=>'mini', // mini, simple, mfull, full or from XHeditor::$_tools, tool names are case sensitive
		'width'=>'100%',
		//see XHeditor::$_configurableAttributes for more
	),
	'contentValue'=>'Enter your text here', // default value displayed in textarea/wysiwyg editor field
	'htmlOptions'=>array('rows'=>5, 'cols'=>10), // to be applied to textarea
));

Usage with a model:

$this->widget('ext.widgets.xheditor.XHeditor',array(
	'model'=>$modelInstance,
	'modelAttribute'=>'attribute',
	'showModelAttributeValue'=>false, // defaults to true, displays the value of $modelInstance->attribute in the textarea
	'config'=>array(
		'tools'=>'full', // mini, simple, mfull, full or from XHeditor::$_tools
		'width'=>'300',
	),
));
*/

class XHeditor extends CWidget
{
	/**
	 * @var array The options for the widget.
	 */
	public $config = array();

	/**
	 * An instance of the model that the field belongs to.
	 * @var CModel or its childs.
	 */
	public $model;

	/**
	 * @var string The attribute of the model instance.
	 */
	public $modelAttribute;

	/**
	 * Determines whether or not the value of the model
	 * attribute should be displayed in the textarea.
	 * @var boolean
	 */
	public $showModelAttributeValue = true;

	/**
	 * The language that the widget will be displayed in.
	 * Available languages set at {@see self::$_languages}.
	 * @var string
	 */
	public $language;

	/**
	 * @var boolean Try to select language based on application settings.
	 */
	public $language_detect=true;

	/**
	 * The value to be displayed in the textarea.
	 * Precedence is given to {$this->model}->{$this->modelAttribute} if set.
	 * @var string
	 */
	public $contentValue;

	/**
	 * @var array Html attributes to be applied to the textarea.
	 */
	public $htmlOptions = array();

	/**
	 * Comma separated list of attributes that can be
	 * passed to $this->config as array keys.
	 * @var string
	 */
	private $_configurableAttributes = 'id,name,layerShadow,tools,skin,showBlocktag,internalScript,internalStyle,width,height,loadCSS,fullscreen,beforeSetSource,beforeGetSource,focus,blur,forcePtag,upLinkUrl,upLinkExt,upImgUrl,upImgExt,upFlashUrl,upFlashExt,upMediaUrl,upMediaExt,plugins';

	/**
	 * Comma separated list of attributes that can be
	 * passed to $this->config['tools'] as array keys.
	 * @var string
	 */
	private $_tools = 'Cut,Copy,Paste,Pastetext,|,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Align,List,Outdent,Indent,Link,Unlink,Anchor,Img,Flash,Media,Hr,Emot,Table,Source,Preview,Print,Fullscreen,/';

	/**
	 * @var array of languages that can be used by the widget {@see self::$language}.
	 */
	private $_languages = array('en','zh-cn','zh-tw','ru');

	/**
	 * @var array Default tools presets.
	 */
	private $_tools_preset=array('mini','simple','mfull','full');

	/**
	 * @var string XHeditor version.
	 */
	private $_XHeditor_version='1.1.12';

	/**
	 * @var string Pattern of script filename.
	 */
	private $_filename_pattern='xheditor-{version}-{language}.min.js';

	/**
	 * @var string To store the base url of the assets for the widget.
	 */
	private $_baseUrl;

	/**
	 * @var string Stores the markup to be rendered/displayed (textarea).
	 */
	private $_field;

	/**
	 * @var array of default values for widget properties.
	 */
	private $_defaults = array(
		'language'=>'en',
		'config'=>array(
			'width'=>350,
			'height'=>150,
		),
		'htmlOptions'=>array(
			'rows'=>1,
			'cols'=>1,
		),
	);

	/**
	 * Merges the specified attributes with default values.
	 * Preference is given to the specified values.
	 */
	public function setDefaults()
	{
		$this->config = array_merge($this->_defaults['config'], $this->config);
		$this->htmlOptions = array_merge($this->_defaults['htmlOptions'], $this->htmlOptions);
	}

	/**
	 * Prepares widget to be used by setting necessary
	 * configurations, publishing assets and registering
	 * necessary javascripts and css to be rendered.
	 */
	public function init()
	{
		$this->setDefaults();
		$config = $this->cleanConfig();
		$language = $this->cleanLanguage();
		$model = $this->model;
		$modelAttribute = $this->modelAttribute;

		// self::$model and self::$modelAttribute are specified
		if(isset($model, $modelAttribute))
		{
			if(empty($config['id']))
				$config['id'] = $this->htmlOptions['id'] = CHtml::activeId($model, $modelAttribute);
			if(empty($config['name']))
				$config['name'] = CHtml::activeName($model, $modelAttribute);
			if($this->showModelAttributeValue===true)
			{
				$modelAttributeValue = $model->{$modelAttribute};
				$this->contentValue = !empty($modelAttributeValue) ? $modelAttributeValue : null;
			}
		}else{
			//if name and id attributes are not specified in self::$config, generate them
			if(empty($config['id']))
				$config['id'] = 'xheditor_' . rand(1, 1000);
			if(empty($config['name']))
				$config['name'] = 'xheditor';
		}

		if(empty($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $config['id'];

		$this->_field = CHtml::textArea($config['name'],$this->contentValue,$this->htmlOptions);

		// publish assets
		$assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'xheditor';
		$this->_baseUrl = Yii::app()->getAssetManager()->publish($assets,true,-1,YII_DEBUG);

		// register css and js to be rendered
		$script_filename=str_replace(array('{version}','{language}'), array($this->_XHeditor_version,$language), $this->_filename_pattern);
		Yii::app()->clientScript->registerCss($config['id'],'#'.$config['id'].' {width:'.$config['width'].';height:'.$config['height'].';}');
		Yii::app()->clientScript->registerScriptFile($this->_baseUrl .'/'.$script_filename);
		Yii::app()->clientScript->registerScript($config['id'],'$("#'.$config['id'].'").xheditor('.CJavaScript::encode($config).');');
	}

	/**
	 * Checks specified language existence at {@see self::$_languages} array.
	 * If not found, try to detect language if {@see self::$language_detect} is true,
	 * or set it to default.
	 * @return string Language ID
	 */
	public function cleanLanguage()
	{
		if (($this->language) && in_array($this->language, $this->_languages)) return $this->language;
		elseif ($this->language_detect)
		{
			$lang=str_replace('_', '-', Yii::app()->language);
			return (in_array($lang, $this->_languages)) ? $lang : $this->_defaults['language'];
		}
		return $this->_defaults['language'];
	}

	/**
	 * Ensures that only tools that are specified by self::$_tools
	 * are used by the widget.
	 * @param string $toolsParam String of comma separated tools.
	 * @return string Comma separated validated tools for JS script.
	 */
	public function cleanTools($toolsParam = null)
	{
		if($toolsParam===null)
			return $toolsParam;
		$_validTools = explode(',', $this->_tools);
		$_configuredTools = explode(',', $toolsParam);
		$_tools = array();
		foreach($_configuredTools as $tool)
		{
			// if default tool preset is specified in
			// $this->config['tools'], then the tool will be used.
			if(in_array($tool,$this->_tools_preset))
				return $tool;

			if(in_array($tool, $_validTools))
				$_tools[] = $tool;
		}
		return implode(',', $_tools);
	}

	/**
	 * Ensures that only valid configuration values
	 * are used by the widget. Valid attributes are
	 * stored in {@see self::$_configurableAttributes}
	 * @return array
	 */
	public function cleanConfig()
	{
		$config = array();
		$configurableAttributes = explode(',', $this->_configurableAttributes);
		foreach($this->config as $key => $val)
		{
			if(in_array($key, $configurableAttributes))
			{
				if($key==='tools')
				{
					$tools = $this->cleanTools($this->config[$key]);
					// If no valid tools were specified, do not add tools
					// to the config so xheditor default tools will be used
					if(empty($tools))
						continue;
				}
				$config[$key] = $val;
			}
		}
		return $config;
	}

	/**
	 * Displays the textarea field
	 */
	public function run()
	{
		echo $this->_field;
	}
}