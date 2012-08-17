<?php
/**
 * XReturnableHelperBehavior
 *
 * XReturnableHelperBehavior is meant to be used togther with
 * XReturnableBehavior that creates URLs that allow to return to a page.
 * XReturnableHelperBehavior provides texts for return links based on return url.
 *
 * There are two ways in which texts are matched to url:
 * 1) route part of returnable url are mapped to labels via routeLabels array,
 * 2) text is queried with model method using parameter extracted from return url.
 *
 * It can be attached to a model on its behaviors() method:
 * <pre>
 * public function behaviors()
 * {
 *     return CMap::mergeArray(
 *         parent::behaviors(),
 *         array(
 *             'returnableHelper'=>array(
 *                 'class'=>'ext.behaviors.XReturnableHelperBehavior',
 *                 'modelName'=>'User',
 *                 'methodName'=>'getTextByStatus',
 *                 'paramName'=>'status',
 *                 'routeLabels'=>array(
 *                     'client/create' => Yii::t('ui','New Client'),
 *                     'employee/admin' => Yii::t('ui','Manage Employees'),
 *                     'userStatusHistory/admin' => Yii::t('ui','Client Status History'),
 *                     'userVisitHistory/admin' => Yii::t('ui','Client Visits History'),
 *                     'orderManage/index' => Yii::t('ui','Orders'),
 *                     'orderManage/view' => Yii::t('ui','Orders'),
 *                     'orderManage/specify' => Yii::t('ui','Orders'),
 *                 )
 *             )
 *         )
 *     );
 * }
 * </pre>
 *
 * It can be used in view as follows:
 * <pre>
 * $this->breadcrumbs=array(
 *     $this->getReturnText()=>$this->getReturnUrl(),
 *     Yii::t('ui', 'View Item')
 * );
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XReturnableHelperBehavior extends CBehavior
{
	/**
	 * @var array $routeLabels the routes to labels (ex. 'client/create' => Yii::t('ui','New Client'))
	 */
	public $routeLabels=array();
	/**
	 * @var string $modelName the name of the model to be used to query text for link
	 */
	public $modelName;
	/**
	 * @var string $modelName the name of the model method to be used to query text for link
	 */
	public $methodName;
	/**
	 * @var $paramName the name of the parameter that is extracted from url and used in model method
	 * to query text for link
	 */
	public $paramName;

	/**
	 * @return string text for return link
	 */
	public function getReturnText()
	{
		$returnUrl=$this->owner->getReturnUrl();
		if($returnUrl)
		{
			parse_str(parse_url($returnUrl, PHP_URL_QUERY));

			if($this->routeLabels!==array())
				$textByRoute=$this->getTextByRoute($this->owner->getReturnUrlRoute());

			if(isset($textByRoute) && $textByRoute)
				return $textByRoute;
			elseif($this->paramName && isset(${$this->paramName}))
				return $this->getModel()->{$this->methodName}(${$this->paramName});
		}
		else
			return null;
	}

	/**
	 * @param string route part of url
	 * @return string text for link
	 */
	protected function getTextByRoute($route)
	{
		return isset($this->routeLabels[$route]) ? $this->routeLabels[$route] : null;
	}

	/**
	 * @return CActiveRecord
	 */
	protected function getModel()
	{
		return CActiveRecord::model($this->modelName);
	}
}