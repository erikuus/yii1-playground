<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image
			// this is used by the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xf9f9f9,
			),
			// widget action renders "static" pages stored under 'protected/views/site/widgets'
			// They can be accessed via: index.php?r=site/widget&view=FileName
			'widget'=>array(
				'class'=>'CViewAction',
				'basePath'=>'widgets',
			),
			'extension'=>array(
				'class'=>'CViewAction',
				'basePath'=>'extensions',
			),
			'module'=>array(
				'class'=>'CViewAction',
				'basePath'=>'modules',
			),
			'design'=>array(
				'class'=>'CViewAction',
				'basePath'=>'designs',
			),
			// ajaxContent action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/ajaxContent&view=FileName
			'ajaxContent'=>array(
				'class'=>'ext.actions.XAjaxViewAction',
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
			array('allow',
				'actions'=>array('index','contact','login','logout','error','captcha','widget','extension','module','design','ajaxContent'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('upload','movePersons'),
				'ips'=>$this->ips,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers ="From: {$model->email}\r\n";
				$headers.="Reply-To: {$model->email}\r\n";
				$headers.="Content-type: text/html; charset=UTF-8";
				$subject='['.Yii::app()->name.'] '.$model->subject;
				mail(Yii::app()->params['contactEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact',Yii::t('ui','Thank you for contacting us. We will respond to you as soon as possible.'));
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$form=new LoginForm;
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$form->attributes=$_POST['LoginForm'];
			// validate user input and redirect to previous page if valid
			if($form->validate())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('form'=>$form));
	}

	/**
	 * Logout the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect($this->createUrl('/site/index'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', array('error'=>$error));
		}
	}

	/**
	 * Uploads files submitted via CMultiFileUpload widget
	 * Deletes all old files before uploading new files
	 */
	public function actionUpload()
	{
		if(isset($_FILES['files']))
		{
			// delete old files
			foreach($this->findFiles() as $filename)
				unlink(Yii::app()->params['uploadDir'].$filename);

			//upload new files
			foreach($_FILES['files']['name'] as $key=>$filename)
				move_uploaded_file($_FILES['files']['tmp_name'][$key],Yii::app()->params['uploadDir'].$filename);
		}
		$this->redirect(array('site/widget','view'=>'multifileupload'));
	}

	/**
	 * Move users between Australia and New Zealand.
	 * This method is used by XMultiSelects widget.
	 */
	public function actionMovePersons()
	{
		if(isset($_POST['Person']['australia']))
		{
			foreach ($_POST['Person']['australia'] as $id)
				Person::model()->updateUserCountry($id, 14);
		}

		if(isset($_POST['Person']['newzealand']))
		{
			foreach ($_POST['Person']['newzealand'] as $id)
				Person::model()->updateUserCountry($id, 158);
		}
		Yii::app()->user->setFlash('saved',Yii::t('ui','Data successfully saved!'));
		$this->redirect(array('site/extension','view'=>'listbuilder'));
	}


	/**
	 * @return array filename
	 */
	public function findFiles()
	{
		return array_diff(scandir(Yii::app()->params['uploadDir']), array('.', '..'));
	}
}