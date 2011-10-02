<?php

class MenuController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array actions
	 */
	public function actions()
	{
		return array(
			'suggestHierarchy'=>array(
				'class'=>'ext.actions.XSuggestAction',
				'modelName'=>'Menu',
				'methodName'=>'suggest',
			),
			'fillTree'=>array(
				'class'=>'ext.actions.XFillTreeAction',
				'modelName'=>'Menu'
			),
			'ajaxPath'=>array(
				'class'=>'ext.actions.XAjaxEchoAction',
				'modelName'=>'Menu',
				'attributeName'=>'pathText',
			),
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform actions
				'actions'=>array('index','view','indexMenu','suggestHierarchy','fillTree'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform actions
				'actions'=>array('admin','create','update','ajaxPath','adminMenu'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform actions
				'actions'=>array('delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Menu;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Menu']))
		{
			$model->attributes=$_POST['Menu'];

			if($model->save())
			{
				if(!$this->goBack())
					$this->redirect(array('view','id'=>$model->id));
				else
					$this->goBack();
			}
		}

		$parent=$this->loadModel();
		$model->parent_id=$parent->id;
		$model->parentPath=$model->getPathText($parent->id);

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

		if(isset($_POST['Menu']))
		{
			$model->attributes=$_POST['Menu'];
			if($model->save())
			{
				if(!$this->goBack())
					$this->redirect(array('view','id'=>$model->id));
				else
					$this->goBack();
			}
		}

		$model->parentPath=$model->getPathText($model->parent_id);

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Take delete action according to command parameter
	 */
	public function actionDelete()
	{
		// we only allow deletion via POST request
		if(Yii::app()->request->isPostRequest)
		{
			$model=$this->loadModel();

			switch ($_GET['command']) {
				case 'withChildren':
					$model->deleteWithChildren();
				break;
				case 'keepChildren':
					$model->deleteKeepChildren();
				break;
				case 'delete':
					$model->delete();
				break;
				default:
					throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
				break;
			}

			// using xreturnable extension to go back
			if (!$this->goBack())
				$this->redirect(array('admin'));
			else
				$this->goBack();
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=$this->loadModel();
		$dataProvider=Menu::model()->getDataProvider($model->id);
		$this->render('index',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Displays tree in multilevel list.
	 */
	public function actionIndexMenu()
	{
		$this->render('menu');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=$this->loadModel();
		$dataProvider=Menu::model()->getDataProvider($model->id);
		$this->render('admin',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Displays tree in multilevel list.
	 */
	public function actionAdminMenu()
	{
		$this->render('menu');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			$id=isset($_GET['id']) ? $_GET['id'] : Menu::model()->rootId;
			$this->_model=Menu::model()->findbyPk($id);

			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
