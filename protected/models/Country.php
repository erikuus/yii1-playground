<?php

/**
 * This is the model class for table "tbl_country".
 */
class Country extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_country':
	 * @property integer $id
	 * @property string $code
	 * @property string $name
	 * @property integer $call_code
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Country the static model class
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
		return 'tbl_country';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('call_code', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>2),
			array('name', 'length', 'max'=>100),
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
			'persons' => array(self::HAS_MANY, 'Person', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('ui', 'ID'),
			'code' => Yii::t('ui', 'Code'),
			'name' => Yii::t('ui', 'Name'),
			'call_code' => Yii::t('ui', 'Call Code'),
		);
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
			'condition'=>'name LIKE :keyword',
			'order'=>'name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		foreach($models as $model) {
			$suggest[] = array(
				'label'=>$model->name.' - '.$model->code.' - '.$model->call_code,  // label for dropdown list
				'value'=>$model->name,  // value for input field
				'id'=>$model->id,       // return values from autocomplete
				'code'=>$model->code,
				'call_code'=>$model->call_code,
			);
		}
		return $suggest;
	}

	/**
	 * Suggests a list of existing fullnames matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching fullnames
	 */
	public function legacySuggest($keyword,$limit=20)
	{
		$models=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
		$suggest=array();
		foreach($models as $model)
			$suggest[]=$model->name.' - '.$model->code.' - '.$model->call_code.'|'.$model->name.'|'.$model->code.'|'.$model->call_code;
		return $suggest;
	}

	/**
	 * @return array for dropdown (attr1 => attr2)
	 */
	public function getOptions()
	{
		return CHtml::listData($this->findAll(),'id','name');
	}
}