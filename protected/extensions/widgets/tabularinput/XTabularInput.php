<?php
/**
 * XTabularInput
 *
 * Widget to handle variable number of form inputs.
 *
 * XTabularInput can be used together with {@link XTabularInputAction}
 *
 * BASIC EXAMPLE
 * minimal configuration, no style
 *
 * Widget:
 *
 * <pre>
 * $this->widget('ext.widgets.tabularinput.XTabularInput',array(
 *     'models'=>$persons,
 *     'inputView'=>'_tabularInput',
 *     'inputUrl'=>$this->createUrl('request/addTabularInputs'),
 *     'removeTemplate'=>'<div class="action">{link}</div>',
 *     'addTemplate'=>'<div class="action">{link}</div>',
 * ));
 * </pre>
 *
 * Partial view _tabularInput:
 *
 * <div class="simple">
 *    <?php echo CHtml::activeLabelEx($model,"[$index]firstname"); ?>
 *    <?php echo CHtml::activeTextField($model,"[$index]firstname"); ?>
 *    <?php echo CHtml::error($model,"[$index]firstname"); ?>
 * </div>
 * <div class="simple">
 *    <?php echo CHtml::activeLabelEx($model,"[$index]lastname"); ?>
 *    <?php echo CHtml::activeTextField($model,"[$index]lastname"); ?>
 *    <?php echo CHtml::error($model,"[$index]lastname"); ?>
 * </div>
 *
 * Action defined in controller {@see XTabularInputAction}:
 *
 * <pre>
 * public function actions()
 * {
 *     return array(
 *         'addTabularInputs'=>array(
 *             'class'=>'ext.actions.XTabularInputAction',
 *             'modelName'=>'Person',
 *             'viewName'=>'/person/_tabularInput',
 *         ),
 *     );
 * }
 * </pre>
 *
 * ADVANCED EXAMPLE
 * tabular inputs configured into table layout, buttons styled
 *
 * Widget:
 *
 * <pre>
 * $this->widget('ext.widgets.tabularinput.XTabularInput',array(
 *     'models'=>$persons2,
 *     'containerTagName'=>'table',
 *     'headerTagName'=>'thead',
 *     'header'=>'
 *         <tr>
 *             <td>'.CHtml::activeLabelEX(Person::model(),'firstname').'</td>
 *             <td>'.CHtml::activeLabelEX(Person::model(),'lastname').'</td>
 *             <td>'.CHtml::activeLabelEX(Person::model(),'eyecolor_code').'</td>
 *             <td></td>
 *         </tr>
 *     ',
 *     'inputContainerTagName'=>'tbody',
 *     'inputTagName'=>'tr',
 *     'inputView'=>'extensions/_tabularInputAsTable',
 *     'inputUrl'=>$this->createUrl('request/addTabularInputsAsTable'),
 *     'addTemplate'=>'<tbody><tr><td colspan="3">{link}</td></tr></tbody>',
 *     'addLabel'=>Yii::t('ui','Add new row'),
 *     'addHtmlOptions'=>array('class'=>'blue pill full-width'),
 *     'removeTemplate'=>'<td>{link}</td>',
 *     'removeLabel'=>Yii::t('ui','Delete'),
 *     'removeHtmlOptions'=>array('class'=>'red pill'),
 * ));
 * </pre>
 *
 * Partial view _tabularInputAsTable:
 *
 * <td>
 *    <?php echo CHtml::activeTextField($model,"[$index]firstname"); ?>
 *    <?php echo CHtml::error($model,"[$index]firstname"); ?>
 * </td>
 * <td>
 *    <?php echo CHtml::activeTextField($model,"[$index]lastname"); ?>
 *    <?php echo CHtml::error($model,"[$index]lastname"); ?>
 * </td>
 *
 * Action defined in controller {@see XTabularInputAction}:
 *
 * <pre>
 * public function actions()
 * {
 *     return array(
 *         'addTabularInputsAsTable'=>array(
 *             'class'=>'ext.actions.XTabularInputAction',
 *             'modelName'=>'Person',
 *             'viewName'=>'/site/extensions/_tabularInputAsTable',
 *         ),
 *     );
 * }
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XTabularInput extends CWidget
{
	/**
	 * @var array models for tabular input.
	 */
	public $models=array();
	/**
	 * @var string the view used for rendering each tabular input.
	 */
	public $inputView;
	/**
	 * @var string the url to action that (partial)renders tabular input.
	 *
	 * Example:
	 *
	 * public function actionField($index)
	 * {
	 *     $model=new Task;
	 *     $this->renderPartial('_field', array('model'=>$model,'index'=>$index));
	 * }
	 */
	public $inputUrl;
	/**
	 * @var string the text or html of header.
	 */
	public $header;
	/**
	 * @var string the template used to render remove link. In this template,
	 * the token "{link}" will be replaced with the corresponding link.
	 */
	public $removeTemplate;
	/**
	 * @var string the template used to render add link. In this template,
	 * the token "{link}" will be replaced with the corresponding link.
	 */
	public $addTemplate;
	/**
	 * @var string the text of the link that removes inputs. Defaults to 'Add'.
	 */
	public $removeLabel='Remove';
	/**
	 * @var string the text of the link that adds inputs. Defaults to 'Add'.
	 */
	public $addLabel='Add';
	/**
	 * @var string the HTML tag name for the widget container. Defaults to 'div'.
	 */
	public $containerTagName='div';
	/**
	 * @var string the HTML tag name for the container of all tabular inputs. Defaults to 'div'.
	 */
	public $inputContainerTagName='div';
	/**
	 * @var string the HTML tag name for the container of all tabular inputs. Defaults to 'div'.
	 */
	public $headerTagName='div';
	/**
	 * @var string the HTML tag name for the container of tabular input. Defaults to 'div'.
	 */
	public $inputTagName='div';
	/**
	 * @var array HTML attributes for widget container
	 */
	public $containerHtmlOptions=array();
	/**
	 * @var array HTML attributes for container that holds all inputs
	 */
	public $inputContainerHtmlOptions=array();
	/**
	 * @var array HTML attributes for tabular inputs header
	 */
	public $headerHtmlOptions=array();
	/**
	 * @var array HTML attributes for the container of tabular input
	 */
	public $inputHtmlOptions=array();
	/**
	 * @var array HTML attributes for the link that adds inputs.
	 */
	public $addHtmlOptions=array();
	/**
	 * @var array HTML attributes for the link that removes inputs.
	 */
	public $removeHtmlOptions=array();
	/**
	 * Default CSS class for the widget container.
	 */
	public $containerCssClass='tabular-container';
	/**
	 * Default CSS class for container that holds all inputs.
	 */
	public $inputContainerCssClass='tabular-input-container';
	/**
	 * Default CSS class for the tabular input.
	 */
	public $inputCssClass='tabular-input';
	/**
	 * Default CSS class for the hidden elements that hold variable inputs indexes.
	 */
	public $indexCssClass='tabular-input-index';
	/**
	 * Default CSS class for the tabular inputs header.
	 */
	public $headerCssClass='tabular-header';
	/**
	 * Default CSS class for the element that removes inputs.
	 */
	public $removeCssClass='tabular-input-remove';
	/**
	 * Default CSS class for the element that adds inputs.
	 */
	public $addCssClass='tabular-input-add';

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		if(isset($this->containerHtmlOptions['id']))
			$this->id=$this->containerHtmlOptions['id'];
		else
			$this->containerHtmlOptions['id']=$this->id;

		if(!isset($this->containerHtmlOptions['class']))
			$this->containerHtmlOptions=array_merge($this->containerHtmlOptions, array('class'=>$this->containerCssClass));
		else
			$this->containerHtmlOptions['class'].=' '.$this->containerCssClass;

		if(!isset($this->inputContainerHtmlOptions['class']))
			$this->inputContainerHtmlOptions=array_merge($this->inputContainerHtmlOptions, array('class'=>$this->inputContainerCssClass));
		else
			$this->inputContainerHtmlOptions['class'].=' '.$this->inputContainerCssClass;

		if(!isset($this->headerHtmlOptions['class']))
			$this->headerHtmlOptions = array_merge($this->headerHtmlOptions, array('class'=>$this->headerCssClass));
		else
			$this->headerHtmlOptions['class'].=' '.$this->headerCssClass;

		if(!isset($this->inputHtmlOptions['class']))
			$this->inputHtmlOptions=array_merge($this->inputHtmlOptions, array('class'=>$this->inputCssClass));
		else
			$this->inputHtmlOptions['class'].=' '.$this->inputCssClass;

		if(!isset($this->removeHtmlOptions['class']))
			$this->removeHtmlOptions=array_merge($this->removeHtmlOptions, array('class'=>$this->removeCssClass));
		else
			$this->removeHtmlOptions['class'].=' '.$this->removeCssClass;

		if(!isset($this->addHtmlOptions['class']))
			$this->addHtmlOptions=array_merge($this->addHtmlOptions, array('class'=>$this->addCssClass));
		else
			$this->addHtmlOptions['class'].=' '.$this->addCssClass;
			
		if($this->models===array())
			$this->headerHtmlOptions=array_merge($this->headerHtmlOptions, array('style'=>'display:none'));			
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$this->registerClientScript();
		echo CHtml::openTag($this->containerTagName, $this->containerHtmlOptions);
		if($this->header)
			echo CHtml::tag($this->headerTagName, $this->headerHtmlOptions, $this->header);
		echo CHtml::openTag($this->inputContainerTagName, $this->inputContainerHtmlOptions);
		$this->renderContent();
		echo CHtml::closeTag($this->inputContainerTagName);
		echo $this->getAddLink();
		echo CHtml::closeTag($this->containerTagName);
	}

	/**
	 * Publish and register necessary client scripts.
	 */
	protected function registerClientScript()
	{
		// register core script
		$cs=Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');

		// publish and register assets file
		$assets=Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
		$cs->registerScriptFile($assets.'/jquery.calculation.min.js', CClientScript::POS_HEAD);

		// define values to be used inside script
		$openInputTag=CHtml::openTag($this->inputTagName, $this->inputHtmlOptions);
		$closeInputTag=CHtml::closeTag($this->inputTagName);

		// register inline javascript
		$script =
<<<SCRIPT
	$("#{$this->id} .{$this->addCssClass}").click(function(event){
		event.preventDefault();
		var input = $(this).parents(".{$this->containerCssClass}:first").children(".{$this->inputContainerCssClass}");
		var index = input.find(".{$this->indexCssClass}").length>0 ? input.find(".{$this->indexCssClass}").max()+1 : 0;
		$.ajax({
			success: function(html){
				input.append('{$openInputTag}'+html+'{$this->getRemoveLinkAndIndexInput("'+index+'")}{$closeInputTag}');
				input.siblings('.{$this->headerCssClass}').show();
			},
			type: 'get',
			url: this.href,
			data: {
				index: index
			},
			cache: false,
			dataType: 'html'
		});
	});
	$("#{$this->id} .{$this->removeCssClass}").live("click", function(event) {
		event.preventDefault();
		$(this).parents(".{$this->inputCssClass}:first").remove();
		$('.{$this->inputContainerCssClass}').filter(function(){return $.trim($(this).text())==='' && $(this).children().length == 0}).siblings('.{$this->headerCssClass}').hide();
	});
SCRIPT;

		$cs->registerScript(__CLASS__.'#'.$this->id, $script, CClientScript::POS_READY);
	}

	/**
	 * Renders the body part of the widget.
	 */
	protected function renderContent()
	{
		foreach($this->models as $index=>$model)
		{
			echo CHtml::openTag($this->inputTagName, $this->inputHtmlOptions);
			$this->controller->renderPartial($this->inputView, array('model'=>$model, 'index'=>$index));
			echo $this->getRemoveLinkAndIndexInput($index);
			echo CHtml::closeTag($this->inputTagName);
		}
	}

	/**
	 * Get the the link that adds tabular input.
	 */
	protected function getAddLink()
	{
		$addLink=CHtml::link($this->addLabel, $this->inputUrl, $this->addHtmlOptions);
		if($this->addTemplate)
			$addLink=strtr($this->addTemplate, array('{link}'=>$addLink));
		return $addLink;
	}

	/**
	 * Get the the link that removes tabular input and hidden index input field
	 * @param mixed tabular input index.
	 */
	protected function getRemoveLinkAndIndexInput($index)
	{
		$removeLink=CHtml::link($this->removeLabel, '#', $this->removeHtmlOptions).'<input type="hidden" class="'.$this->indexCssClass.'" value="'.$index.'" />';
		if($this->removeTemplate)
			$removeLink=strtr($this->removeTemplate, array('{link}'=>$removeLink));
		return $removeLink;
	}
}