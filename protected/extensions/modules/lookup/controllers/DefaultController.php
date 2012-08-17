<?php
class DefaultController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * initialize the default portlets for the views
	 */
	public function init()
	{
		parent::init();

		$this->layout=Yii::app()->controller->module->lookupLayout;

		if(Yii::app()->controller->module->leftPortlets!==array())
			$this->leftPortlets=Yii::app()->controller->module->leftPortlets;

		if(Yii::app()->controller->module->rightPortlets!==array())
			$this->rightPortlets=Yii::app()->controller->module->rightPortlets;
	}

	/**
	 * Default action.
	 */
	public function actionIndex()
	{
		$model=new Lookup;

		if(isset($_POST['Lookup']))
		{
			$model->attributes=$_POST['Lookup'];
			if($model->save())
				$this->redirect(array('admin','type'=>$model->type));
		}
		$this->render('index',array(
			'model'=>$model
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Lookup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lookup']))
		{
			$model->attributes=$_POST['Lookup'];
			if($model->save())
			{
				// using xreturnable extension to go back
				if(!$this->goBack())
					$this->redirect(array('admin'));
				else
					$this->goBack();
			}
		}
		elseif(isset($_GET['type']))
			$model->type=$_GET['type'];
		else
			throw new CHttpException(404);

		$this->render('create',array(
			'model'=>$model,

		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Lookup']))
		{
			$model->attributes=$_POST['Lookup'];
			if($model->save())
			{
				// using xreturnable extension to go back
				if(!$this->goBack())
					$this->redirect(array('admin'));
				else
					$this->goBack();
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400);
	}

	/**
	 * Manages all models.
	 * Handles search and filter requests
	 */
	public function actionAdmin()
	{
		$model=new Lookup('search');

		if(!empty($_GET['type']))
			$model->type=$_GET['type'];
		else
			throw new CHttpException(404);

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Lookup::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404);
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='Lookup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Moves model up or down.
	 */
	public function actionMove()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow movement via POST request
			$model=$this->loadModel();

			if(isset($_GET['move']) && $_GET['move']=='up')
				$model->moveUp();

			if(isset($_GET['move']) && $_GET['move']=='down')
				$model->moveDown();
		}
		else
			throw new CHttpException(400);
	}
}