<?php

/**
 * This is the model class for table "tbl_menu".
 */
class Menu extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_menu':
	 * @property integer $id
	 * @property integer $parent_id
	 * @property string $title
	 * @property integer $position
	 */

	public $parentPath;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_menu';
	}

	/**
	 * @return array behaviors.
	 */
	public function behaviors()
	{
		return array(
			'TreeBehavior' => array(
				'class' => 'ext.behaviors.XTreeBehavior',
				'treeLabelMethod'=> 'getTreeLabel',
				'menuUrlMethod'=> 'getMenuUrl',
			),
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, position', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>256),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			  'parent' => array(self::BELONGS_TO, 'Menu', 'parent_id'),
			  'children' => array(self::HAS_MANY, 'Menu', 'parent_id', 'order' => 'position'),
			'childCount' => array(self::STAT, 'Menu', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('ui', 'ID'),
			'parent_id' => Yii::t('ui', 'Parent'),
			'label' => Yii::t('ui', 'Label'),
			'position' => Yii::t('ui', 'Position'),
		);
	}

	/**
	 * @return string tree label
	 */
	public function getTreeLabel()
	{
		return $this->label . ':' . $this->childCount;
	}

	/**
	 * @return array menu url
	 */
	public function getMenuUrl()
	{
		if(Yii::app()->controller->action->id=='adminMenu')
			return array('admin', 'id'=>$this->id);
		else
			return array('index', 'id'=>$this->id);
	}

	/**
	 * Retrieves a list of child models
	 * @param integer the id of the parent model
	 * @return CActiveDataProvider the data provider
	 */
	public function getDataProvider($id=null)
	{
		if($id===null)
			$id=$this->TreeBehavior->getRootId();
		$criteria=new CDbCriteria(array(
			'condition'=>'parent_id=:id',
			'params'=>array(':id'=>$id),
			'order'=>'label',
			'with'=>'childCount',
		));
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	/**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
	public function suggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'label ILIKE :keyword',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"$keyword%")
		));
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->TreeBehavior->pathText,  // label for dropdown list
				'value'=>$model->label,  // value for input field
				'id'=>$model->id,       // return values from autocomplete
			);
		}
		return $suggest;
	}
}