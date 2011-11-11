<?php

class PersonController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @var string the default layout for the views.
	 */
	public $layout='leftbar';

	/**
	 * initialize the default portlets for the views
	 */
	function init()
	{
		parent::init();
		$this->leftPortlets['ptl.WidgetMenu']=array();
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','admin','view','alpha','batch','updateYears'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','delete'),
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
		$model=new Person;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Person']))
		{
			$model->attributes=$_POST['Person'];
			if($model->save())
			{
				if(!$this->goBack())
					$this->redirect(array('admin'));
				else
					$this->goBack();
			}
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

		if(isset($_POST['Person']))
		{
			$model->attributes=$_POST['Person'];
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
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Person', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['pageSize'],
				'pageVar'=>'page',
			),
			'sort'=>array(
				'defaultOrder'=>'lastname',
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Person('search');
		if(isset($_GET['Person']))
			$model->attributes=$_GET['Person'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models with batch menu.
	 */
	public function actionBatch()
	{
		$model=new Person('search');
		if(isset($_GET['Person']))
			$model->attributes=$_GET['Person'];

		$this->render('batch',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models with batch menu.
	 */
	public function actionCmenu()
	{
		$model=new Person('search');
		if(isset($_GET['Person']))
			$model->attributes=$_GET['Person'];

		$this->render('cmenu',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionAlpha()
	{
		// AlphaPagination
		Yii::import('ext.widgets.alphapager.XAlphaPagination');
		$criteria=new CDbCriteria;
		$alphaPages = new XAlphaPagination('lastname');
		$alphaPages->charSet = Person::model()->getAlphaChars('lastname');
		$alphaPages->applyCondition($criteria);

		// Dataprovider
		$dataProvider=new CActiveDataProvider('Person', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['pageSize'],
				'pageVar'=>'page',
			),
			'sort'=>array(
				'defaultOrder'=>'lastname',
			),
		));
		$this->render('alpha',array(
			'dataProvider'=>$dataProvider,
			'alphaPages'=>$alphaPages,
		));
	}

	/**
	 * Make selected persons 10 years older.
	 */
	public function actionUpdateYears()
	{
		// we only allow POST request
		if(Yii::app()->request->isPostRequest)
		{
			$increment=!empty($_GET['op']) && $_GET['op']=='more' ?  1 : -1;
			$criteria=new CDbCriteria();
			$criteria->addInCondition('id', $_POST['person-id']);
			Person::model()->updateCounters(array('birthyear'=>$increment), $criteria);

			// if AJAX request, we should not redirect the browser
			if(!isset($_GET['ajax']))
			{
				if(!$this->goBack())
					$this->redirect(array('batch'));
				else
					$this->goBack();
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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
				$this->_model=Person::model()->findbyPk($_GET['id']);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='person-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
