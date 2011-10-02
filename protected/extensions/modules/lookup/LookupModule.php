<?php
/**
 * LookupModule class file.
 *
 * LookupModule is a module that provides lookup system and classificators management.
 *
 * To use LookupModule, you must include it as a module in the application configuration like the following:
 * <pre>
 * return array(
 *     'modules'=>array(
 *         'lookup'=>array(
 *             'class'=>'ext.modules.lookup.LookupModule',
 *         ),
 *     ),
 * )
 * </pre>
 *
 * With the above configuration, you will be able to access LookupModule in your browser using
 * the following URL:
 * http://localhost/path/to/index.php?r=lookup
 *
 * If your application is using path-format URLs, you can then access LookupModule via:
 * http://localhost/path/to/index.php/lookup
 *
 * In order to access lookup model from anywhere of your application,
 * you need to import it in the application configuration like the following:
 *
 * 'import'=>array(
 *     'ext.modules.lookup.models.*',
 * ),
 *
 * The following examples show how to use Lookup for creating dropdown in your application:
 *
 * echo $form->dropDownList($model,'status',Lookup::items('PostStatus'));
 * echo $form->dropDownList($model,'status',Lookup::add()+Lookup::items('PostStatus'),array('prompt'=>''));
 *
 * The following example shows how to use Lookup for gridview in your application:
 *
 * $this->widget('zii.widgets.grid.CGridView', array(
 *     'dataProvider'=>$model->search(),
 *     'filter'=>$model,
 *     'columns'=>array(
 *         array(
 *             'name'=>'status',
 *             'value'=>'Lookup::item("PostStatus",$data->status)',
 *             'filter'=>Lookup::items('PostStatus'),
 *         ),
 *     ),
 * ));
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class LookupModule extends CWebModule
{
	/**
	 * @var string the name of the lookup table
	 * Defaults to 'lookup'.
	 */
	public $lookupTable='lookup';
	/**
	 * @var string the path to the layout
	 */
	public $lookupLayout;
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
	 * @var array a list of safe types. If safe types are set,
	 * only admin user can manage other (unsafe) attributes.
	 */
	public $safeTypes=array();
	/**
	 * @var mixed a rbac operation name that controlls access to restricted pages (admin, update, create).
	 * Defaults to false, meaning role based access control is not used at all and all authenticated
	 * users are allowed to access restriced pages. NOTE! Admin user is always given full access
	 * and delete is allowed only to admin user.
	 */
	public $rbac=false;
	/**
	* @var string The base script URL for all module resources (e.g. javascript,
	* CSS file, images).
	* If NULL (default) the integrated module resources (which are published as
	* assets) are used.
	*/
	public $baseScriptUrl;

	private $publicPages=array();
	private $adminPages=array(
		'default/delete',
		'install/index',
		'install/create'
	);

	/**
	 * Initializes the lookup module.
	 */
	public function init()
	{
		// import the module-level models and components
		$this->setImport(array(
			'lookup.models.*',
			'lookup.components.*',
		));

		// publish module assets
		if (!is_string($this->baseScriptUrl)) {
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('lookup.assets'));
		}
	}

	/**
	 * Performs access check to lookup module.
	 * @param CController the controller to be accessed.
	 * @param CAction the action to be accessed.
	 * @return boolean whether the action should be executed.
	 */
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			$route=$controller->id.'/'.$action->id;

			// allow only admin user to delete lookup items
			if(Yii::app()->user->name!='admin' && in_array($route,$this->adminPages))
				throw new CHttpException(403,'You are not allowed to access this page.');

			// allow authenticated users or users with given role access restricted pages
			if(Yii::app()->user->name!='admin' && $this->rbac===false)
				$this->checkUserAccess($route);
			if(Yii::app()->user->name!='admin' && $this->rbac!==false)
				$this->checkRoleAccess($route);

			// allow only admin user to add lookup items of new type
			if (isset($_GET['type']) && $this->safeTypes!==array() && !in_array($_GET['type'],$this->safeTypes) &&
			Yii::app()->user->name!='admin')
				throw new CHttpException(403,'You are not allowed to access this page.');

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