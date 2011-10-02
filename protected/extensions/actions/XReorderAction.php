<?php
/**
 * XReorderAction
 *
 * This action is designed to be used in connection with XReorderBehavior to reorder models
 *
 * The following shows how to use XReorderAction action.
 * Set up search action on controller actions() method:
 * <pre>
 * return array(
 *     'reorder'=>array(
 *         'class'=>'ext.actions.XReorderAction',
 *         'modelName'=>'someName'
 *     ),
 * );
 * </pre>
 *
 * In the gridview you can define reordering buttons as follows:
 * <pre>
 * array(
 *     'class'=>'CButtonColumn',
 *     'template'=>'{up} {down}',
 *     'buttons'=>array(
 *          'down'=>array(
 *              'label'=>Yii::t('ui','Move down'),
 *              'url'=>'array("reorder","move"=>"down","id"=>$data->id)',
 *              'imageUrl'=>XHtml::imageUrl('down.png'),
 *              'click'=>'function() {
 *                  $.fn.yiiGridView.update("some-grid", {
 *                      type:"POST",
 *                      url:$(this).attr("href"),
 *                      success:function() {
 *                          $.fn.yiiGridView.update("some-grid");
 *                      }
 *                  });
 *                  return false;
 *               }',
 *               'visible'=>'$this->grid->dataProvider->itemCount > $data->sort ? true : false',
 *          ),
 *          'up'=>array(
 *               'label'=>Yii::t('ui','Move up'),
 *               'url'=>'array("reorder","move"=>"up","id"=>$data->id)',
 *               'imageUrl'=>XHtml::imageUrl('up.png'),
 *               'click'=>'function() {
 *                   $.fn.yiiGridView.update("some-grid", {
 *                       type:"POST",
 *                       url:$(this).attr("href"),
 *                       success:function() {
 *                       $.fn.yiiGridView.update("some-grid");
 *                   }
 *               });
 *               return false;
 *          }',
 *          'visible'=>'$data->sort > 1 ? true : false',
 *      ),
 * )
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