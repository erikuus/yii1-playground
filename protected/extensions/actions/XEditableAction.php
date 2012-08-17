<?php
/**
 * XEditableAction
 *
 * This action updates and returns data for XEditableWidget widget
 *
 * The following shows how to use XEditableAction action.
 *
 * First set up the action on RequestController actions() method:
 * <pre>
 * return array(
 *     'clickToEdit'=>array(
 *         'class'=>'ext.actions.XEditableAction',
 *     ),
 * );
 * </pre>
 *
 * And then set up widget:
 * <pre>
 * $this->widget('ext.widgets.jeditable.XEditableWidget',array(
 *     'saveurl'=>$this->createUrl('request/clickToEdit',array('id'=>$model->id)),
 *     'model'=>$model,
 *     'attribute'=>'title',
 *     'jeditable_type'=>'text',
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XEditableAction extends CAction
{
	/**
	 * @var boolean whether to use markdown parser on response. Defaults to false.
	 */
	public $markdown=false;

	public function run()
	{
		if(isset($_GET['id'], $_POST['attribute']) && isset($_POST['value']))
		{
			$modelName=$this->getModelName($_POST['attribute']);
			$attributeName=$this->getAttributeName($_POST['attribute']);
			$model=CActiveRecord::model($modelName)->findbyPk($_GET['id']);
			$model->{$attributeName}=$_POST['value'];
			if($model->update($attributeName))
				$this->renderResponse($model->{$attributeName});
			else
				throw new CException('Error on update');

		}
	}

	/**
	 * Render response value
	 * @param string value to render
	 */
	protected function renderResponse($value)
	{
		if($this->markdown)
		{
			$parser=new CMarkdownParser();
			echo $parser->transform($value);
		}
		else
			echo $value;
	}

	/**
	 * @param string modelName_attributeName
	 * @return CActiveRecord
	 */
	protected function getModelName($model_attribute)
	{
		$p=strpos($model_attribute, '_');
		return substr($model_attribute,0,$p);
	}

	/**
	 * @param string modelName_attributeName
	 * @return attribute name
	 */
	protected function getAttributeName($model_attribute)
	{
		$p=strpos($model_attribute, '_');
		return substr($model_attribute,$p+1);
	}
}