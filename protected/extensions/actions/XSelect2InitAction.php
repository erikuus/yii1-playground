<?php
/**
 * XSelect2InitAction class
 *
 * This action initalizes selection for Select2 widget
 *
 * The following shows how to use XSelect2InitAction action.
 *
 * First set up the action on RequestController actions() method:
 * <pre>
 * return array(
 *     'initPerson'=>array(
 *         'class'=>'ext.actions.XSelect2InitAction',
 *         'modelName'=>'Person',
 *         'textField'=>'fullname',
 *     ),
 * );
 * </pre>
 *
 * And then Select2 widget can be initalized as follows:
 * <pre>
 * $this->widget('ext.widgets.select2.XSelect2', array(
 *     'model'=>$model,
 *     'attribute'=>'id',
 *     'options'=>array(
 *         ...
 *         'initSelection' => "js:function (element, callback) {
 *             var id=$(element).val();
 *             if (id!=='') {
 *                 $.ajax('".$this->createUrl('/request/initPerson')."', {
 *                     dataType: 'json',
 *                     data: {
 *                         id: id
 *                     }
 *                 }).done(function(data) {callback(data);});
 *             }
 *         }",
 *     ),
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XSelect2InitAction extends CAction
{
	/**
	 * @var string name of the model class.
	 */
	public $modelName;
	/**
	 * @var string name of the model primary key attribute.
	 */
	public $idField='id';
	/**
	 * @var string name of the model attribute that is used as text value for Select2 widget.
	 */
	public $textField;

	/**
	 * Runs the action.
	 */
	public function run()
	{
		if(isset($_GET[$this->idField]))
		{
			$id=$_GET[$this->idField];
			if(strstr($id, ','))
				$this->getMultiple($id);
			else
				$this->getSingle($id);
		}
	}

	/**
	 * @param mixed id
	 * @return json encoded single selection
	 */
	protected  function getSingle($id)
	{
		$model=$this->getModel()->findByAttributes(array($this->idField=>$id));
		if($model!==null)
			echo CJSON::encode(array('id'=>$model->{$this->idField},'text'=>$model->{$this->textField}));
	}

	/**
	 * @param string comma separated list of ids
	 * @return json encoded multiple selections
	 */
	public function getMultiple($id)
	{
		$models=$this->getModel()->findAll("$this->idField IN ($id)");
		$data=array();
		foreach($models as $model)
	    	$data[]=array('id'=>$model->{$this->idField},'text'=>$model->{$this->textField});

		echo CJSON::encode($data);
	}

	/**
	 * @return CActiveRecord
	 */
	protected function getModel()
	{
		return CActiveRecord::model($this->modelName);
	}
}