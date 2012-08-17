<?php
class Lookup extends CActiveRecord
{
	/**
	 * The followings are the available columns in table:
	 * @var integer $id
	 * @var integer $code
	 * @var string $name_et
	 * @var string $name_en
	 * @var string $type
	 * @var integer $position
	 */

	private static $_items=array();

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return isset(Yii::app()->getModule('lookup')->lookupTable)
			? Yii::app()->getModule('lookup')->lookupTable
			: Yii::app()->controller->module->lookupTable;
	}

	// METHODS TO BE USED FROM WITHIN APPLICATION:

	/**
	 * Returns the items for the specified type.
	 * @param string item type (e.g. 'PostStatus').
	 * @return array item names indexed by item code. The items are order by their position values.
	 * An empty array is returned if the item type does not exist.
	 */
	public static function items($type)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return self::$_items[$type];
	}

	/**
	 * Returns the item name for the specified type and code.
	 * @param string the item type (e.g. 'PostStatus').
	 * @param integer the item code (corresponding to the 'code' column value)
	 * @return string the item name for the specified the code. False is returned if the item type or code does not exist.
	 */
	public static function item($type,$code)
	{
		if(!isset(self::$_items[$type]))
			self::loadItems($type);
		return isset(self::$_items[$type][$code]) ? self::$_items[$type][$code] : null;
	}

	/**
	 * @return array of 'add new' option for dropdown
	 */
	public static function add()
	{
		return array('-1'=>Yii::t('LookupModule.ui','-add-'));
	}

	/**
	 * Loads the lookup items for the specified type from the database.
	 * @param string the item type
	 */
	private static function loadItems($type)
	{
		self::$_items[$type]=array();
		$models=self::model()->findAll(array(
			'condition'=>'type=:type',
			'params'=>array(':type'=>$type),
			'order'=>'position',
		));
		$name='name_'.Yii::app()->language;
		foreach($models as $model)
			self::$_items[$type][$model->code]=$model->{$name};
	}

	// METHODS USED WITHIN MODULE:

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, name_et, name_en', 'required'),
			array('code, position', 'numerical', 'integerOnly'=>true),
			array('name_et, name_en', 'length', 'max'=>256),
			array('type', 'length', 'max'=>64),
			array('code', 'length', 'max'=>16),
			array('type', 'match', 'pattern'=>'/^[A-Za-z0-9_]+$/u','message'=>Yii::t('LookupModule.ui', '{attribute} can only contain alphanumeric symbols.')),
			array('type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('LookupModule.ui', 'Id'),
			'code' => Yii::t('LookupModule.ui', 'Code'),
			'name_et' => Yii::t('LookupModule.ui', 'Name Et'),
			'name_en' => Yii::t('LookupModule.ui', 'Name En'),
			'type' => Yii::t('LookupModule.ui', 'Type'),
			'position' => Yii::t('LookupModule.ui', 'Position'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider('Lookup', array(
			'criteria'=>$criteria,
			'pagination'=>false,
			'sort'=>array(
				'defaultOrder'=>'type,position',
			),
		));
	}

	/**
	 * Get menu items
	 * @param integer maximum number of names to be returned
	 * @return array for CMenu widget
	 */
	public function getMenu()
	{
		$menu=array();
		$models=$this->findAll(array('select'=>'DISTINCT(type)','order'=>'type'));
		foreach($models as $model)
		{
			$menu[]=array(
				'label'=>Yii::t('ui',XHtml::labelize($model->type)),
				'url'=>array('admin','type'=>$model->type),
				'visible'=>$this->isTypeVisible($model->type),
			);
		}
		return $menu;
	}

	/**
	 * Move up.
	 */
	public function moveUp()
	{
		$this->position=$this->position-1;
		$this->update(array('position'));

		$model=$this->find("position=$this->position AND type='$this->type' AND id!=$this->id");
		$model->position=$model->position+1;
		$model->update(array('position'));
	}

	/**
	 * Move down.
	 */
	public function moveDown()
	{
		$this->position=$this->position+1;
		$this->update(array('position'));

		$model=$this->find("position=$this->position AND type='$this->type' AND id!=$this->id");
		$model->position=$model->position-1;
		$model->update(array('position'));
	}

	/**
	 * @param string the value of type attribute
	 * @return integer next available code
	 */
	public function queryNextCode($type)
	{
		$model=$this->find(array(
			'condition'=>"type='$type'",
			'order'=>'code DESC',
			'limit'=>1,
		));
		if($model===null)
			return 1;
		else
			return $model->code+1;
	}

	/**
	 * @param string the value of type attribute
	 * @return integer next available position
	 */
	public function queryNextPosition($type)
	{
		$model=$this->find(array(
			'condition'=>"type='$type'",
			'order'=>'position DESC',
			'limit'=>1,
		));
		if($model===null)
			return 1;
		else
			return $model->position+1;
	}

	/**
	 * @param string the value of type attribute
	 * @return boolean whether the type should be visible in LookupMenu.
	 */
	protected function isTypeVisible($type)
	{
		$safeTypes=Yii::app()->controller->module->safeTypes;
		if ($safeTypes!==array() && !in_array($type,$safeTypes) && Yii::app()->user->name!='admin')
			return false;
		else
			return true;
	}

	/**
	 * Prepares attributes before performing validation.
	 */
	protected function beforeValidate()
	{
		parent::beforeValidate();

		if(!$this->name_en && $this->name_et)
			$this->name_en=$this->name_et;

		return true;
	}

	/**
	 * This is invoked before the record is saved.
	 * @return boolean whether the record should be saved.
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->code=$this->queryNextCode($this->type);
				$this->position=$this->queryNextPosition($this->type);
			}
			return true;
		}
		else
			return false;
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();

		$position=1;
		$models=$this->findAll(array(
			'condition'=>"type='$this->type'",
			'order'=>'position'
		));
		foreach($models as $model)
		{
			$model->position=$position;
			$model->update(array('position'));
			$position++;
		}
	}
}