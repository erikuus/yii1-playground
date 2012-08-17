<?php
/**
 * XReorderAction
 *
 * This action is designed to be used in connection with
 * - XReorderBehavior
 * - XReorderColumn
 *
 * The following shows how to use XReorderAction action.
 *
 * Set up the action on controller actions() method:
 * <pre>
 * public function actions()
 * {
 *     return array(
 *         'reorder'=>array(
 *             'class'=>'ext.actions.XReorderAction',
 *             'modelName'=>'someName'
 *         ),
 *     );
 * }
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XReorderAction extends CAction
{
	/**
	 * @var string name of the CActiveRecord class.
	 */
	public $modelName;

	/**
	 * Runs the action.
	 */
	public function run()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model=$this->loadModel();

			if(isset($_GET['move']) && $_GET['move']=='up')
				$model->moveUp();

			if(isset($_GET['move']) && $_GET['move']=='down')
				$model->moveDown();
		}
		else
			throw new CHttpException(400);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		$model=null;

		if(isset($_GET['id']))
			$model=$this->getModel()->findbyPk($_GET['id']);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		else
			return $model;
	}

	/**
	 * @return CActiveRecord
	 */
	protected function getModel()
	{
		return CActiveRecord::model($this->modelName);
	}
}