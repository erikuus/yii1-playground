<?php
/**
 * XAjaxViewAction action
 *
 * This action displays content with renderPartial
 *
 * To use XAjaxViewAction action set up ajaxContent action on Controller actions() method
 * <pre>
 * return array(
 *     // ajaxContent action renders "static" pages stored under 'protected/views/controller/pages'
 *     // They can be accessed via: index.php?r=controller/ajaxContent&view=FileName
 *     'ajaxContent'=>array(
 *         'class'=>'ext.actions.XAjaxViewAction',
 *     ),
 * );
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XAjaxViewAction extends CViewAction
{
	private $_viewPath;

	public function run()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$this->resolveView($this->getRequestedView());
			$controller=$this->getController();
			$controller->renderPartial($this->view, null, false, true);
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
}