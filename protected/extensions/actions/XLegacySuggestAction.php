<?php
/**
 * XLegacySuggestAction action
 *
 * This action returns data for CAutoComplete widget
 *
 * The following shows how to use XLegacySuggestAction action
 *
 * First set up the action on RequestController actions() method:
 * <pre>
 * return array(
 *     'legacySuggestCountry'=>array(
 *         'class'=>'ext.actions.XLegacySuggestAction',
 *         'modelName'=>'Country',
 *         'methodName'=>'legacySuggest',
 *     ),
 * );
 * </pre>
 *
 * And then set up widget:
 * <pre>
 * $this->widget('CAutoComplete',array(
 *     'model'=>$model,
 *     'attribute'=>'name',
 *     'url'=>array('request/legacySuggestCountry'),
 * ));
 * </pre>
 *
 * Note: You also have to write model method that makes suggest query
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XLegacySuggestAction extends CAction
{
	/**
	 * @var string name of the model class.
	 */
	public $modelName;
	/**
	 * @var string name of the method of model class that returns data.
	 */
	public $methodName;
	/**
	 * @var integer maximum number of rows to be returned
	 */
	public $limit=20;

	/**
	 * Suggests country names based based on the current user input.
	 */
	public function run()
	{
		if(isset($_GET['q'])&&($keyword=trim($_GET['q']))!=='')
		{
			$suggest=$this->getModel()->{$this->methodName}($keyword, $this->limit, $_GET);
			if($suggest!==array())
				echo implode("\n",$suggest);
		}
	}

	/**
	 * @return CActiveRecord
	 */
	protected function getModel()
	{
		return CActiveRecord::model($this->modelName);
	}
}