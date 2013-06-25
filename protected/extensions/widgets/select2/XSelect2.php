<?php

/**
 * XSelect2 class file.
 *
 * Select2 is a jQuery based replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results.
 * This widget is wrapper for ivaynberg jQuery select2 (https://github.com/ivaynberg/select2)
 *
 * Original version by Anggiajuang Patria {@link http://git.io/Mg_a-w}.
 *
 * Changes to original version:
 * - renamed class,
 * - restructured code,
 * - added cssFile property,
 * - dropped selector property,
 * - added text field generation for ajax option.
 *
 * XSelect2 can be used together with {@link XSelect2InitAction} and {@link XSelect2SuggestAction}
 *
 * Examples:
 *
 * Select single (wrapper for dropdown):
 * <pre>
 * $this->widget('ext.widgets.select2.XSelect2', array(
 *     'model'=>$model,
 *     'attribute'=>'country_id',
 *     'data'=>Country::model()->options,
 *     'htmlOptions'=>array(
 *         'style'=>'width:300px',
 *     ),
 * ));
 * </pre>
 *
 * Select multiple (wrapper for listbox, add selection, selected and remove events, limit selections):
 * <pre>
 * $this->widget('ext.widgets.select2.XSelect2', array(
 *     'model'=>$model,
 *     'attribute'=>'countryIds',
 *     'data'=>Country::model()->options,
 *     'options'=>array(
 *         'maximumSelectionSize'=>5,
 *     ),
 *     'htmlOptions'=>array(
 *         'style'=>'width:700px',
 *         'multiple'=>'true',
 *         'class'=>'countries-select'
 *     ),
 *     'events'=>array(
 *         'selected'=>"js:function (element) {
 *             $('[data-country='+element.val+']').hide();
 *         }",
 *         'removed'=>"js:function (element) {
 *             $('[data-country='+element.val+']').show();
 *         }"
 *     ),
 * ));
 *
 * echo CHtml::link('Afganistan', '#', array('data-country'=>1, 'class'=>'btn btn-green country'));
 * echo CHtml::link('Aland Islands', '#', array('data-country'=>2, 'class'=>'btn btn-green country'));
 * echo CHtml::link('Albania', '#', array('data-country'=>3, 'class'=>'btn btn-green country'));
 * echo CHtml::link('Algeria', '#', array('data-country'=>4, 'class'=>'btn btn-green country'));
 * echo CHtml::link('American Samoa', '#', array('data-country'=>5, 'class'=>'btn btn-green country'));
 * echo CHtml::link('Andorra', '#', array('data-country'=>6, 'class'=>'btn btn-green country'));
 *
 * Yii::app()->clientScript->registerScript('select2interact', "
 *     var data=$('.countries-select').select2('val');
 *     $.each(data, function(index, value) {
 *         $('[data-country='+value+']').hide();
 *     });
 *     $('a.country').click(function(e) {
 *         e.preventDefault();
 *         var data=$('.countries-select').select2('val');
 *         if ($.isArray(data) && data.length >= 5) {
 *             alert('Maximum allowed number of drivers is 5');
 *             return false;
 *         }
 *         var id=$(this).attr('data-country');
 *         $('.countries-select').val(data.concat(id)).trigger('change');
 *         $(this).hide();
 *     });
 * ", CClientScript::POS_READY);
 * </pre>
 *
 * Ajax select single (ajax init selection, ajax suggest options, change event load data with ajax):
 * <pre>
 * $this->widget('ext.widgets.select2.XSelect2', array(
 *     'model'=>$model,
 *     'attribute'=>'id',
 *     'options'=>array(
 *         'minimumInputLength'=>2,
 *         'ajax' => array(
 *             'url'=>$this->createUrl('/request/suggestPerson'),
 *             'dataType'=>'json',
 *             'data' => "js: function(term,page) {
 *                 return {q: term};
 *             }",
 *             'results' => "js: function(data,page){
 *                 return {results: data};
 *             }",
 *         ),
 *         'initSelection' => "js:function (element, callback) {
 *             var id=$(element).val();
 *             if (id!=='') {
 *                 $.ajax('".$this->createUrl('/request/initPerson')."', {
 *                     dataType: 'json',
 *                     data: {
 *                         id: id
 *                     }
 *                 }).done(function(data) {callback(data);});
 *             }
 *         }",
 *     ),
 *     'events'=>array(
 *         'change'=>"js:function (element) {
 *             var id=element.val;
 *             if (id!='') {
 *                 $.ajax('".$this->createUrl('/request/listPersonsWithSameFirstname')."', {
 *                     data: {
 *                         id: id
 *                     }
 *                 }).done(function(data) {
 *                     $('#name-list').text(data);
 *                 });
 *             }
 *         }"
 *     ),
 *     'htmlOptions'=>array(
 *         'style'=>'width:300px'
 *     ),
 * ));
 * </pre>

 * Ajax select multiple (ajax init selection, ajax suggest options, format options):
 * <pre>
 * $this->widget('ext.widgets.select2.XSelect2', array(
 *     'model'=>$model,
 *     'attribute'=>'personIds',
 *     'options'=>array(
 *         'minimumInputLength'=>2,
 *         'multiple'=>true,
 *         'ajax' => array(
 *             'url'=>$this->createUrl('/request/suggestPersonGroupCountry'),
 *             'dataType'=>'json',
 *             'data' => "js: function(term,page) {
 *                 return {q: term};
 *             }",
 *             'results' => "js: function(data,page){
 *                 return {results: data};
 *             }",
 *         ),
 *         'formatResult' => "js:function(data){
 *             if (data.type == 'country')
 *                 return '<b>'+data.text+'</b>';
 *             else
 *                 return '&nbsp;'+data.text;
 *         }",
 *         'initSelection' => "js:function (element, callback) {
 *             var id=$(element).val();
 *             if (id!=='') {
 *                 $.ajax('".$this->createUrl('/request/initPerson')."', {
 *                     dataType: 'json',
 *                     data: {
 *                        id: id
 *                     }
 *                 }).done(function(data) {callback(data);});
 *             }
 *         }",
 *     ),
 *     'htmlOptions'=>array(
 *         'style'=>'width:700px',
 *         'data-placeholder'=>Yii::t('ui','Search for person'),
 *     )
 * ));
</pre>

 *
 * @author Anggiajuang Patria <anggiaj@gmail.com>
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 2.0
 */
class XSelect2 extends CInputWidget
{
	/**
	 * @var mixed the CSS file used for the widget. Defaults to null, meaning
	 * using the default CSS file included together with the widget.
	 * If false, no CSS file will be used. Otherwise, the specified CSS file
	 * will be included when using this widget.
	 */
	public $cssFile;
	/**
	 * @var array select2 options
	 */
	public $options=array();
	/**
	 * @var array CHtml::dropDownList $data param
	 */
	public $data=array();
	/**
	 * @var array javascript event handlers
	 */
	public $events=array();
	/**
	 * @var boolean should the items of a multiselect list be sortable using jQuery UI
	 */
	public $sortable=false;

	/**
	 * Initializes the widget.
	 * Publish and register client files
	 */
	public function init()
	{
		list($name, $id)=$this->resolveNameId();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;

		if (isset($this->htmlOptions['placeholder']))
			$this->options['placeholder'] = $this->htmlOptions['placeholder'];

		if (!isset($this->htmlOptions['multiple']))
		{
			$data = array();
			if (isset($this->options['placeholder']))
				$data[] = '';
			$this->data = $data + $this->data;
		}

		$this->registerClientScript();
		$this->registerClientScriptFiles();
	}

	/**
	 * Render widget input.
	 */
	public function run()
	{
		if (isset($this->options['ajax']))
		{
			if ($this->hasModel())
				echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
			else
				echo CHtml::textField($this->name, $this->value, $this->htmlOptions);
		}
		else
		{
			if (isset($this->htmlOptions['multiple']) && $this->htmlOptions['multiple']=='true')
			{
				if($this->hasModel())
					echo CHtml::activeListBox($this->model, $this->attribute, $this->data, $this->htmlOptions);
				else
					echo CHtml::listBox($this->model, $this->attribute, $this->data, $this->htmlOptions);
			}
			else
			{
				if($this->hasModel())
					echo CHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
				else
					echo CHtml::dropDownList($this->name, $this->value, $this->data, $this->htmlOptions);
			}
		}
	}

	/**
	 * Register necessary inline client scripts.
	 */
	protected function registerClientScript()
	{
		$id=$this->htmlOptions['id'];
		$cs=Yii::app()->clientScript;

		// prepare options
		$options = CJavaScript::encode($this->options);

		// prepare events
		// Note that since jquery 1.7 there is a new method on() that can be used instead of bind()
		$events='';
		foreach ($this->events as $event=>$handler)
			$events.=".bind('{$event}', ".CJavaScript::encode($handler).")";

		// prepare sortable
		$sortable=
<<<SCRIPT
	jQuery('#{$id}').select2("container").find("ul.select2-choices").sortable({
		containment: 'parent',
		start: function() { jQuery('#{$id}').select2("onSortStart"); },
		update: function() { jQuery('#{$id}').select2("onSortEnd"); }
	});
SCRIPT;

		// register inline script
		$script="jQuery('#{$id}').select2({$options}){$events};\n";

		if ($this->sortable)
			$script.=$sortable;

		$cs->registerScript(__CLASS__ . '#' . $id, $script, CClientScript::POS_READY);
	}

	/**
	 * Publish and register necessary client script files.
	 */
	protected function registerClientScriptFiles()
	{
		$cs=Yii::app()->clientScript;
		$assets=Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');

		// register css file
		if($this->cssFile===null)
			$cs->registerCssFile($assets.'/select2.css');
		else if($this->cssFile!==false)
			$cs->registerCssFile($this->cssFile);

		// register js files
		if ($this->sortable)
			$cs->registerCoreScript('jquery.ui');

		if (YII_DEBUG)
			$cs->registerScriptFile($assets. '/select2.js');
		else
			$cs->registerScriptFile($assets. '/select2.min.js');
	}
}
