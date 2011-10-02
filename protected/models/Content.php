<?php

/**
 * This is the model class for table "tbl_content".
 */
class Content extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'tbl_content':
	 * @property integer $id
	 * @property string $title
	 * @property string $content
	 * @property integer $authorid
	 * @property integer $createtime
	 * @property integer $updatetime
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Content the static model class
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
		return 'tbl_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('authorid, createtime, updatetime', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, authorid, createtime, updatetime', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('ui', 'ID'),
			'title' => Yii::t('ui', 'Title'),
			'content' => Yii::t('ui', 'Content'),
			'authorid' => Yii::t('ui', 'Authorid'),
			'createtime' => Yii::t('ui', 'Createtime'),
			'updatetime' => Yii::t('ui', 'Updatetime'),
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

		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('authorid',$this->authorid);
		$criteria->compare('createtime',$this->createtime);
		$criteria->compare('updatetime',$this->updatetime);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['pageSize'],
			),
			'sort'=>array(
				'defaultOrder'=>'id',
			),
		));
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
				$this->createtime=time();
			else
				$this->updatetime=time();

			$this->authorid=1;
			return true;
		}
		else
			return false;
	}
}