<?php
/**
 * XSearchAction
 *
 * This action finds models through SearchForm
 *
 * The following shows how to use XSearchAction action.
 * Set up search action on controller actions() method:
 * <pre>
 * return array(
 *     'advancedSearch'=>array(
 *         'class'=>'ext.actions.XSearchAction',
 *         'modelName'=>'Content',
 *         'scenario'=>'searchAdvanced',
 *         'view'=>'advanced',
 *     ),
 * );
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XSearchAction extends CAction
{
	/**
	 * @var string name of the CFormModel class.
	 */
	public $formModelName='SearchForm';
	/**
	 * @var string name of the CActiveRecord class.
	 */
	public $modelName;
	/**
	 * @var string name of the method of CActiveRecord class that performs.
	 */
	public $methodName='search';
	/**
	 * @var string name of the scenario of search form.
	 */
	public $scenario;
	/**
	 * @var string name of the search result view.
	 */
	public $view;
	/**
	 * @var boolean whether to allow empty search to find all results.
	 */
	public $allowEmpty=true;

	/**
	 * Runs the action.
	 */
	public function run()
	{
		$form=new $this->formModelName($this->scenario);
		if($this->allowEmpty===false)
			$this->notEmptySearch($form);
		else
			$this->allowEmptySearch($form);
	}

	/**
	 * This method is used when empty search IS NOT allowed.
	 * @param form CFormModel of Search form
	 * @throws CHttpException if search is empty or if the search form is invalid
	 */
	protected function notEmptySearch($form)
	{
		if(isset($_GET['q']))
		{
			$form->attributes=$form->getParams();
			if (!$form->validate())
				throw new CHttpException(400);
			$this->getController()->render($this->view,array(
				'dataProvider'=>$this->getModel()->{$this->methodName}($form),
				'form'=>$form
			));
		}
		else
			throw new CHttpException(400);
	}

	/**
	 * This method is used when empty search IS allowed.
	 * @param form CFormModel of Search form
	 * @throws CHttpException only if the search form is invalid
	 */
	protected function allowEmptySearch($form)
	{
		if(isset($_GET['q']))
		{
			$form->attributes=$form->getParams();
			if (!$form->validate())
				throw new CHttpException(400);
		}
		$this->getController()->render($this->view,array(
			'dataProvider'=>$this->getModel()->{$this->methodName}($form),
			'form'=>$form
		));
	}

	/**
	 * @return CActiveRecord
	 */
	protected function getModel()
	{
		return CActiveRecord::model($this->modelName);
	}
}