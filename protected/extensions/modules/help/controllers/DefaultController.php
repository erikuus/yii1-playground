<?php
class DefaultController extends Controller
{
	/**
	 * @var default action.
	 */
	public $defaultAction='admin';

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

		$this->layout=Yii::app()->controller->module->helpLayout;

		if(Yii::app()->controller->module->leftPortlets!==array())
			$this->leftPortlets=Yii::app()->controller->module->leftPortlets;

		if(Yii::app()->controller->module->rightPortlets!==array())
			$this->rightPortlets=Yii::app()->controller->module->rightPortlets;
	}

	/**
	 * Displays content for help dialog with Ajax load
	*/
	public function actionView()
	{
		$this->renderPartial('_view', array(
			'model'=>$this->loadModel()
		), false, true);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Help;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Help']))
		{
			$model->attributes=$_POST['Help'];
			if($model->save())
				$this->redirect(array('admin'));
		}

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

		if(isset($_POST['Help']))
		{
			$model->attributes=$_POST['Help'];
			if($model->save())
			{
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
	 * Updates a particular model onPage.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdateOnPage()
	{
		$this->layout=null;
		$this->leftPortlets=array();
		$this->rightPortlets=array();

		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Help']))
		{
			$model->attributes=$_POST['Help'];
			if($model->save())
			{
				if(!$this->getReturnUrl('/'))
					$this->redirect(array('admin'));
				else
					$this->redirect($this->getReturnUrl('/'));
			}
		}

		$this->render('updateOnPage',array(
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
				$this->redirect(array('admin'));
		}
		else
			throw new CHttpException(400);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$dataProvider=new CActiveDataProvider('Help', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['pageSize'],
			),
			'sort'=>array(
				'defaultOrder'=>array('title_et'=>false),
			),
		));

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
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
				$this->_model=Help::model()->findbyPk($_GET['id']);
			elseif(isset($_GET['code']))
				$this->_model=Help::model()->findByAttributes(array('code'=>$_GET['code']));
			if($this->_model===null)
				throw new CHttpException(404);
		}
		return $this->_model;
	}

	/**
	 * Generate edit link if user authorized to edit help
	 * @param integer help id
	 * @return html link
	 */
	public function getEditLink($id)
	{
		if(
			(Yii::app()->controller->module->rbac===false && Yii::app()->user->name=='admin') ||
			(Yii::app()->controller->module->rbac!==false && Yii::app()->user->checkAccess(Yii::app()->controller->module->rbac))
		)
			return Help::model()->buildEditLink($id, 'createReturnStackUrl');
		else
			return null;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='help-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}