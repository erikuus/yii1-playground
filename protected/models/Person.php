<?php

/**
 * This is the model class for table "tbl_person".
 */
class Person extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_person':
	 * @property integer $id
	 * @property string $firstname
	 * @property string $lastname
	 * @property integer $birthyear
	 * @property string $email
	 * @property string $webpage
	 * @property integer $country_id
	 * @property string $registered
	 * @property integer $eyecolor_code
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Person the static model class
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
		return 'tbl_person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, country_id', 'required'),
			array('birthyear, country_id, eyecolor_code', 'numerical', 'integerOnly'=>true),
			array('firstname, lastname, email, webpage', 'length', 'max'=>64),
			array('registered', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstname, lastname, birthyear, email, webpage, country_id, registered, eyecolor_code', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('ui', 'ID'),
			'firstname' => Yii::t('ui', 'Firstname'),
			'lastname' => Yii::t('ui', 'Lastname'),
			'birthyear' => Yii::t('ui', 'Birth'),
			'email' => Yii::t('ui', 'Email'),
			'webpage' => Yii::t('ui', 'Webpage'),
			'country_id' => Yii::t('ui', 'Country'),
			'registered' => Yii::t('ui', 'Registered'),
			'eyecolor_code' => Yii::t('ui', 'Eyecolor'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new XDbCriteria(array(
			'with'=>'country',
		));

		$criteria->compare('id',$this->id);
		$criteria->icompare('firstname',$this->firstname,true);
		$criteria->icompare('lastname',$this->lastname,true);
		$criteria->compare('birthyear',$this->birthyear);
		$criteria->icompare('email',$this->email,true);
		$criteria->icompare('webpage',$this->webpage,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->icompare('registered',$this->registered,true);
		$criteria->compare('eyecolor_code',$this->eyecolor_code);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['pageSize'],
				'pageVar'=>'page',
			),
			'sort'=>array(
				'defaultOrder'=>'lastname,firstname',
				'sortVar'=>'sort',
				'attributes'=>array(
					'firstname',
					'lastname',
					'birthyear',
					'country_id'=>array(
						'asc'=>'country.name',
						'desc'=>'country.name DESC',
					)
				),
			),

		));
	}

	/**
	 * @return string reference code of given map
	 */
	public function getFullname()
	{
		return $this->firstname.' '.$this->lastname;
	}

	/**
	 * @param string attribute name
	 * @return array for XAlphaPagination (A,B,C,etc)
	 */
	public function getAlphaChars($attribute)
	{
		$chars=array();
		$criteria=array(
			'select'=>"DISTINCT(SUBSTR(\"$attribute\",1,1)) AS \"$attribute\"",
			'order'=>"$attribute",
		);
		$models=$this->findAll($criteria);
		foreach($models as $model)
			$chars[]=mb_strtoupper($model->$attribute);
		return $chars;
	}

	/**
	 * @param int $country_id
	 * @return array for listbuilder (id => name)
	 */
	public function findUsersByCountry($country_id)
	{
		$criteria=array(
			'select'=>"id, firstname || ' ' || lastname AS firstname",
			'condition'=>'country_id='.$country_id,
			'order'=>'firstname, lastname',
		);
		return CHtml::listData($this->findAll($criteria),'id','firstname');
	}

	/**
	 * @param int $id the id (primary key) of person
	 * @param int $country_id
	 */
	public function updateUserCountry($id, $country_id)
	{
		$model=$this->findByPk($id);
		$model->country_id=$country_id;
		$model->update('country_id');
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	protected function afterFind()
	{
		parent::afterFind();
		$this->registered=date("d.m.Y", strtotime($this->registered));
	}
}