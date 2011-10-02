<?php
class Controller extends CController
{
	/**
	 * @var array the breadcrumbs of the current page.
	 */
	public $breadcrumbs=array();

	/**
	 * @var array context menu items.
	 */
	public $menu=array();

	/**
	 * @var array the portlets of the current page.
	 */
	public $leftPortlets=array();
	public $rightPortlets=array();

	/**
	 * @var array the ips of privilege.
	 */
	public $ips = array(
		'127.0.0.1',
		'::1', // localhost
	);

	/**
	 * initialize
	 */
	function init()
	{
		parent::init();
		if (Yii::app()->getRequest()->getParam('printview'))
			Yii::app()->layout='print';
	}

	/**
	 * @return array behaviors
	 */
	public function behaviors()
	{
		return array(
			'returnable'=>array(
				'class'=>'ext.behaviors.XReturnableBehavior',
			),
		);
	}

	/**
	 * @return boolean true if request IP matches given pattern, otherwise false
	 */
	public function isIpMatched()
	{
		$ip=Yii::app()->request->userHostAddress;

		foreach($this->ips as $rule)
		{
			if($rule==='*' || $rule===$ip || (($pos=strpos($rule,'*'))!==false && !strncmp($ip,$rule,$pos)))
				return true;
		}
		return false;
	}
}
?>