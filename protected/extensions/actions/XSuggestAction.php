<?php
/**
 * XSuggestAction action
 *
 * This action returns data for CJuiAutoComplete widget
 *
 * The following shows how to use XSuggestAction action
 *
 * First set up suggestCountry action on RequestController actions() method:
 * <pre>
 * public function actions()
 * {
 *     return array(
 *         'suggestCountry'=>array(
 *             'class'=>'ext.actions.XSuggestAction',
 *             'modelName'=>'Country',
 *             'methodName'=>'suggest',
 *         ),
 *     );
 * }
 * </pre>
 *
 * And then set up widget:
 * <pre>
 * $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
 *     'model'=>$model,
 *     'attribute'=>'name',
 *     'source'=>$this->createUrl('request/suggestCountry'),
 * ));
 * </pre>
 *
 * Note, you also have to write model method that makes suggest query. For example:
 * <pre>
 * public function suggestSomething($keyword,$limit=20)
 * {
 *     $models=$this->findAll(array(
 *         'condition'=>'column1 LIKE :keyword',
 *         'params'=>array(':keyword'=>$keyword),
 *         'order'=>'column2',
 *         'limit'=>$limit,
 *     ));
 *     $suggest=array();
 *     foreach($models as $model)
 *     {
 *         $suggest[] = array(
 *             'label'=>$model->attr1, // label for dropdown list
 *             'value'=>$model->attr2, // value for input field
 *             'id'=>$model->attr3, // return values from autocomplete
 *            );
 *        }
 *        return $suggest;
 *    }
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XSuggestAction extends CAction
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
	 * Suggests models based on the current user input.
	 */
	public function run()
	{
		if(isset($_GET['term'])&&($keyword=trim($_GET['term']))!=='')
		{
			$suggest=$this->getModel()->{$this->methodName}($keyword,$this->limit,$_GET);
			echo CJSON::encode($suggest);
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