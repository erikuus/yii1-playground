<?php
/**
 * XAjaxEchoAction
 *
 * This action echos attribute value
 *
 * The following shows how to use XAjaxEchoAction action.
 *
 * First set up the action on RequestController actions() method:
 * <pre>
 * return array(
 *     'displayTitle'=>array(
 *         'class'=>'ext.actions.XAjaxEchoAction',
 *         'modelName'=>'Content',
 *         'attributeName'=>'title',
 *     ),
 * );
 * </pre>
 *
 * And then in the view:
 * <pre>
 * echo CHtml::ajaxLink(Yii::t('ui','Display title'), array('request/displayTitle','id'=>1),array('update'=>'#titleDiv')));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XAjaxEchoAction extends CAction
{
	/**
	 * @var string name of the model class.
	 */
	public $modelName;
	/**
	 * @var string name of the model attribute.
	 */
	public $attributeName;

	/**
	 * Runs the action.
	 */
	public function run()
	{
		if(isset($_GET['id']))
		{
			$model=$this->getModel()->findByPk($_GET['id']);
			if(isset($_GET['lang']))
				echo $model->{$this->attributeName.'_'.$_GET['lang']};
			else
				echo $model->{$this->attributeName};
		}
	}

	/**
	 * @return CActiveRecord
	 */
	protected function getModel()
	{
		return CActiveRecord::model($this->modelName);
	}
}