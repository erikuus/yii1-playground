<?php
/**
 * XDynamicForm class file.
 *
 * XDynamicForm (1) enables to use select element so that some content is shown/hidden
 * depending on selected value (2) enables to use checkbox and radio button lists so that
 * when a checkbox or radio button is checked/unchecked some contentnext to checkbox or
 * radio button is shown/hidden
 *
 * Examples
 *
 * For example, let us assume, we have model Person where there is 'martial_status' property
 * and martial status options defined as follows:
 *
 * <pre>
 * class Person extends CActiveRecord
 * {
 *     const MARITAL_STATUS_SINGLE=0;
 *     const MARITAL_STATUS_MARRIED=1;
 *     const MARITAL_STATUS_DIVORCED=2;
 *     const MARITAL_STATUS_WIDOWED=3;
 *
 *     public function getMartialStatusOptions()
 *     {
 *         return array(
 *             self::MARITAL_STATUS_SINGLE=>'Single',
 *             self::MARITAL_STATUS_MARRIED=>'Married',
 *             self::MARITAL_STATUS_DIVORCED=>'Divorced',
 *             self::MARITAL_STATUS_WIDOWED=>'Widowed'
 *         );
 *     }
 * }
 * <pre>
 *
 * Now we can use XDynamicForm as follows:
 *
 * 1) dropdown list
 *
 * <pre>
 * <?php $form=$this->beginWidget('ext.widgets.form.XDynamicForm', array('id'=>'dynamic-form')); ?>
 *
 *     <?php echo $form->DynamicDropDownList($model,'martial_status',Person::model()->martialStatusOptions);?>
 *
 *     <?php $form->beginDynamicAreaDDL($model, 'martial_status', Person::MARITAL_STATUS_SINGLE]); ?>
 *         <!-- This content is displayed only when 'single' option is selected from dropdown.
 *         We can put here form elements that make sense to single people only. -->
 *     <?php $form->endDynamicAreaDDL(); ?>
 *
 *     <?php $form->beginDynamicAreaDDL($model, 'martial_status', Person::MARITAL_STATUS_MARRIED); ?>
 *         <!-- This content is displayed only when 'married' option is selected from dropdown.
 *         We can put here form elements that make sense to married people only. -->
 *     <?php $form->endDynamicAreaDDL(); ?>
 *
 *     <?php $form->beginDynamicAreaDDL($model, 'martial_status', array(Person::MARITAL_STATUS_DIVORCED, Person::MARITAL_STATUS_WIDOWED)); ?>
 *         <!-- This content is displayed only when 'divorced' or 'widowed' option is selected from dropdown.
 *         We can put here form elements that make sense to divorced or widowed people only. -->
 *     <?php $form->endDynamicAreaDDL(); ?>
 *
 * <?php $this->endWidget(); ?>
 * <pre>
 *
 * 2) checkbox or radio button list
 *
 * <pre>
 * <?php $form=$this->beginWidget('ext.widgets.form.XDynamicForm', array('id'=>'dynamic-form')); ?>
 *
 *     <?php $checkBox=$form->explodeCheckBoxList($model, 'martial_status', $model->martialStatusOptions); ?>
 *
 *     <?php $form->beginDynamicArea($checkBox[Person::MARITAL_STATUS_SINGLE]); ?>
 *         <!-- This content is displayed only when 'single' checkbox is checked.
 *         We can put here form elements that make sense to single people only. -->
 *     <?php $form->endDynamicArea(); ?>
 *
 *     <?php $form->beginDynamicArea($checkBox[Person::MARITAL_STATUS_MARRIED]); ?>
 *         <!-- This content is displayed only when 'married' checkbox is checked.
 *         We can put here form elements that make sense to married people only. -->
 *     <?php $form->endDynamicArea(); ?>
 *
 *     <!-- In case we do not need dynamic area for 'divorced' and 'widowed' we use static area instead  -->
 *     <?php $form->staticArea($checkBox[Person::MARITAL_STATUS_DIVORCED]); ?>
 *     <?php $form->staticArea($checkBox[Person::MARITAL_STATUS_WIDOWED]); ?>
 *
 * <?php $this->endWidget(); ?>
 * <pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0
 */
class XDynamicForm extends CActiveForm
{
	/**
	 * @var string CSS class for container that holds checkbox/radiobutton
	 * and the sibling tag that is shown only when checkbox/radiobutton is selected.
	 * Defaults to 'dynamic-container'
	 */
	public $containerCssClass='dynamic-container';
	/**
	 * @var string CSS class for the tag that is shown only when sibling checkbox/radiobutton is selected or
	 * Defaults to 'dynamic-content'
	 */
	public $contentCssClass='dynamic-content';
	/**
	 * @var boolean whether to enable radiobutton to toggle dynamic area
	 * Defaults to true
	 */
	public $enableRadioToggle=true;
	/**
	 * @var boolean whether to enable checkbox to toggle dynamic area
	 * Defaults to true
	 */
	public $enableChecboxToggle=true;

	/**
	 * Registers clientscripts for radio and checkbox if needed
	 */
	public function init()
	{
		if($this->enableRadioToggle)
			$this->registerRadioClientScript();

		if($this->enableChecboxToggle)
			$this->registerCheckboxClientScript();

		parent::init();
	}

	/**
	 * Renders a dropdown list for a model attribute and registers clientscript
	 * needed to show/hide areas depending on selected option of dropdown list
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data data for generating the list options (value=>display)
	 * @param array $htmlOptions additional HTML attributes.
	 * @return string the generated drop down list
	 */
	public function DynamicDropDownList($model, $attribute, $data, $htmlOptions=array())
	{
		$id=CHtml::activeId($model, $attribute);

		$script =
<<<SCRIPT
		var selected=$('#{$id}').val();
		$('.{$id}').hide();
		$('.{$id}.selected_'+selected).show();
		$('#{$id}').live('change', function(){
			var selected=$(this).val();
			$('.{$id}').hide();
			$('.{$id}.selected_'+selected).show();
		});
SCRIPT;
		Yii::app()->clientScript->registerScript(__CLASS__.'#dropdown#'.$this->id, $script, CClientScript::POS_READY);

		return CHtml::activeDropDownList($model, $attribute, $data, $htmlOptions);
	}

	/**
	 * Generates open HTML element of dynamic area for select.
	 * @param string $input radiobutton or checkbox HTML
	 * @param array $containerOptions the container tag attributes.
	 * @param array $contentOptions the content tag attributes.
	 */
	public function beginDynamicAreaDDL($model, $attribute, $selected, $options=array())
	{
		if(is_array($selected))
			$selected = implode(' selected_',$selected);

		$cssClass = CHtml::activeId($model, $attribute).' selected_'.$selected;

		if(isset($options['class']))
			$options['class'].=' '.$cssClass;
		else
			$options = array_merge($options, array('class'=>$cssClass));

		echo CHtml::openTag('div', $options);
	}

	/**
	 * Renders close HTML element of dynamic area for select.
	 */
	public function endDynamicAreaDDL()
	{
		echo '</div>';
	}

	/**
	 * Explodes radioButtonList into array
	 * enabling to render buttons separately ($radio[0], $radio[1], etc)
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data value-label pairs used to generate the radio button list
	 * @param string $class css class nam.
	 * @return array of radio buttons
	 */
	public function explodeRadioButtonList($model, $attribute, $data, $class=null)
	{
		$radioButtons=explode('|',$this->radioButtonList($model, $attribute, $data, array(
			'template'=>'{input}{label}',
			'separator'=>'|',
			'class'=>$class
		)));

		$dataKeys=array_keys($data);
		$indexRadioButtons=array();
		foreach ($radioButtons as $i=>$radioButton) {
			$index=$dataKeys[$i];
			$indexRadioButtons[$index]=$radioButton;
		}
		return $indexRadioButtons;
	}

	/**
	 * Explodes checkBoxList into array
	 * enabling to render boxes separately ($box[0], $box[1], etc)
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data value-label pairs used to generate the check box list
	 * @param string $class css class name
	 * @return array of check boxes
	 */
	public function explodeCheckBoxList($model, $attribute, $data, $class=null)
	{
		$checkBoxes=explode('|',$this->checkBoxList($model, $attribute, $data, array(
			'template'=>'{input}{label}',
			'separator'=>'|',
			'class'=>$class
		)));

		$dataKeys=array_keys($data);
		$indexCheckBoxes=array();
		foreach ($checkBoxes as $i=>$checkBox) {
			$index=$dataKeys[$i];
			$indexCheckBoxes[$index]=$checkBox;
		}
		return $indexCheckBoxes;
	}

	/**
	 * Generates open HTML elements of dynamic area for checkbox or radio.
	 * @param string $input radiobutton or checkbox HTML
	 * @param array $containerOptions the container tag attributes.
	 * @param array $contentOptions the content tag attributes.
	 */
	public function beginDynamicArea($input, $containerOptions=array(), $contentOptions=array())
	{
		if(isset($containerOptions['class']))
			$containerOptions['class'].=' '.$this->containerCssClass;
		else
			$containerOptions = array_merge($containerOptions, array('class'=>$this->containerCssClass));

		if(isset($contentOptions['class']))
			$contentOptions['class'].=' '.$this->contentCssClass;
		else
			$contentOptions = array_merge($contentOptions, array('class'=>$this->contentCssClass));

		echo CHtml::openTag('div', $containerOptions);
			echo $input;
			echo CHtml::openTag('div', $contentOptions);
	}

	/**
	 * Renders close HTML elements of dynamic area for checkbox or radio.
	 */
	public function endDynamicArea()
	{
			echo '</div>';
		echo '</div>';
	}

	/**
	 * Generates static area for checkbox or radio with no toggle content.
	 * @param string $input radiobutton or checkbox HTML
	 * @param array $htmlOptions the tag attributes.
	 */
	public function staticArea($input, $htmlOptions=array())
	{
		if(isset($htmlOptions['class']))
			$htmlOptions['class'].=' '.$this->containerCssClass;
		else
			$htmlOptions = array_merge($htmlOptions, array('class'=>$this->containerCssClass));

		echo CHtml::tag('div', $htmlOptions, $input);
	}

	/**
	 * Register client script for radio
	 */
	protected function registerRadioClientScript()
	{
		$script =
<<<SCRIPT
	$('#{$this->id} .{$this->containerCssClass} :radio:not(:checked)').siblings('.{$this->contentCssClass}').hide();
	$('#{$this->id} .{$this->containerCssClass} :radio').live('click',function() {
		$('.{$this->contentCssClass}', $(this).parents('div:first')).css('display', this.checked ? 'block':'none');
		$('#{$this->id} .{$this->containerCssClass} :radio:not(:checked)').siblings('.{$this->contentCssClass}').hide();
	});
SCRIPT;
		Yii::app()->clientScript->registerScript(__CLASS__.'#radio#'.$this->id, $script, CClientScript::POS_READY);
	}

	/**
	 * Register client script for checkbox
	 */
	protected function registerCheckboxClientScript()
	{
		$script =
<<<SCRIPT
	$('#{$this->id} .{$this->containerCssClass} :checkbox:not(:checked)').siblings('.{$this->contentCssClass}').hide();
	$('#{$this->id} .{$this->containerCssClass} :checkbox').live('click',function() {
		$('.{$this->contentCssClass}', $(this).parents('div:first')).css('display', this.checked ? 'block':'none');
	});
SCRIPT;
		Yii::app()->clientScript->registerScript(__CLASS__.'#checkbox#'.$this->id, $script, CClientScript::POS_READY);
	}
}