<?php
/**
 * XTabularInputAction action
 *
 * This action (partial)renders tabular input for XTabularInput widget
 *
 * The following shows how to use XTabularInputAction action.
 *
 * First set up the action on RequestController actions() method:
 * <pre>
 * return array(
 *     'addFields'=>array(
 *         'class'=>'ext.actions.XTabularInputAction',
 *         'modelName'=>'Person',
 *         'viewName'=>'/person/_inputFields',
 *     ),
 * );
 * </pre>
 *
 * And then XTabularInput widget can be configured as follows:
 * <pre>
 * $this->widget('ext.widgets.tabularinput.XTabularInput',array(
 *     'models'=>$persons,
 *     'inputView'=>'_inputFields',
 *     'inputUrl'=>$this->createUrl('request/addFields'),
 * ));
 * </pre>
 *
 * Example of _inputFields partial view:
 * <pre>
 * echo CHtml::activeLabel($model,"[$index]firstname");
 * echo CHtml::activeTextField($model,"[$index]firstname");
 * echo CHtml::error($model,"[$index]firstname");
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XTabularInputAction extends CAction
{
	/**
	 * @var string name of the model class.
	 */
	public $modelName;

	/**
	 * @var string name of the partial view.
	 */
	public $viewName;

	/**
	 * Runs the action.
	 */
	public function run()
	{
		if(Yii::app()->request->isAjaxRequest && isset($_GET['index']))
		{
			$this->getController()->renderPartial($this->viewName, array(
				'model'=>$this->getModel(),
				'index'=>$_GET['index']
			));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * @return CActiveRecord
	 */
	protected function getModel()
	{
		return CActiveRecord::model($this->modelName);
	}
}