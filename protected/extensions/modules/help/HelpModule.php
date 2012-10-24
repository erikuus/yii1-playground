<?php
/**
 * HelpModule class file.
 *
 * HelpModule is a module that provides help system and management.
 *
 * To use HelpModule, you must include it as a module in the application configuration like the following:
 * <pre>
 * return array(
 *     'modules'=>array(
 *         'help'=>array(
 *             'class'=>'ext.modules.lookup.HelpModule',
 *         ),
 *     ),
 * )
 * </pre>
 *
 * With the above configuration, you will be able to access HelpModule in your browser using
 * the following URL:
 * http://localhost/path/to/index.php?r=help
 *
 * If your application is using path-format URLs, you can then access HelpModule via:
 * http://localhost/path/to/index.php/help
 *
 * In order to access help model from anywhere of your application,
 * you need to import it in the application configuration like the following:
 *
 * 'import'=>array(
 *     'ext.modules.help.models.*',
 * ),
 *
 * The following examples show how to use Help to display help texts in your application:
 *
 * echo Help::item('annotation','title');
 * echo Help::item('annotation','content');
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class HelpModule extends CWebModule
{
	/**
	 * @var string the name of the help table
	 * Defaults to 'help'.
	 */
	public $helpTable='help';
	/**
	 * @var string the path to the layout
	 */
	public $helpLayout;
	/**
	 * @var array a list of application portlets (className=>properties)
	 * that will be displayed on left panel
	 */
	public $leftPortlets=array();
	/**
	 * @var array a list of application portlets (className=>properties)
	 * that will be displayed on right panel
	 */
	public $rightPortlets=array();
	/**
	 * @var css file for XHeditor widget
	 */
	public $editorCSS;
	/**
	 * @var string route to application upload action (ex. 'request/uploadFile')
	 * that will be used by XHeditor widget
	 */
	public $editorUploadRoute;
	/**
	 * @var string list of tools for XHeditor widget
	 * Possible values are also 'mini', 'simple', 'full'
	 */
	public $editorTools='Cut,Copy,Paste,Pastetext,|,GStart,Blocktag,Bold,Italic,Underline,FontColor,BackColor,Removeformat,SelectAll,|,Align,List,Outdent,Indent,GEnd,|,Link,Unlink,Img,Table,|,Source,Preview,Fullscreen';
	/**
	 * @var mixed a rbac operation name that controlls access to restricted pages (admin, update, create).
	 * Defaults to false, meaning role based access control is not used at all and all authenticated
	 * users are allowed to access all but admin pages.
	 */
	public $rbac=false;

	private $publicPages=array(
		'default/view'
	);

	private $adminPages=array(
		'default/delete',
		'install/index',
		'install/create'
	);

	/**
	 * Initializes the help module.
	 */
	public function init()
	{
		// import the module-level models and components
		$this->setImport(array(
			'help.models.*',
			'help.components.*',
		));
	}

	/**
	 * Performs access check to help module.
	 * @param CController the controller to be accessed.
	 * @param CAction the action to be accessed.
	 * @return boolean whether the action should be executed.
	 */
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			$route=$controller->id.'/'.$action->id;

			// allow only admin user to install module and delete help texts
			if(Yii::app()->user->name!='admin' && in_array($route,$this->adminPages))
				throw new CHttpException(403,'You are not allowed to access this page.');

			// allow authenticated users or users with given role access restricted pages
			if(Yii::app()->user->name!='admin' && $this->rbac===false)
				$this->checkUserAccess($route);
			if(Yii::app()->user->name!='admin' && $this->rbac!==false)
				$this->checkRoleAccess($route);

			return true;
		}
		else
			return false;
	}

	/**
	 * Allow authenticated users to access restricted pages
	 * @param string route of current request
	 */
	protected function checkUserAccess($route)
	{
		if(Yii::app()->user->isGuest && !in_array($route,$this->publicPages))
			Yii::app()->user->loginRequired();
		else
			return true;
	}

	/**
	 * Allow only users with given role to access restricted pages
	 * @param string route of current request
	 */
	protected function checkRoleAccess($route)
	{
		if(!Yii::app()->user->isGuest && !Yii::app()->user->checkAccess($this->rbac) && !in_array($route,$this->publicPages))
			throw new CHttpException(403,'You are not allowed to access this page.');
		if(!Yii::app()->user->checkAccess($this->rbac) && !in_array($route,$this->publicPages))
			Yii::app()->user->loginRequired();
		else
			return true;
	}
}
