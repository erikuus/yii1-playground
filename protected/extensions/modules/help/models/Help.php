<?php
class Help extends CActiveRecord
{
	/**
	 * The followings are the available columns in table:
	 * @var integer $id
	 * @var string $code
	 * @var string $title_et
	 * @var string $content_et
	 * @var string $title_en
	 * @var string $content_en
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
		return isset(Yii::app()->getModule('help')->helpTable)
			? Yii::app()->getModule('help')->helpTable
			: Yii::app()->controller->module->helpTable;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title_et, title_en, content_et, content_en', 'required'),
			array('code', 'unique'),
			array('code', 'length', 'max'=>64),
			array('title_et, title_en', 'length', 'max'=>256),
			array('content_et, content_en', 'safe'),
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
			'id' => Yii::t('HelpModule.ui', 'Id'),
			'code' => Yii::t('HelpModule.ui', 'Code'),
			'title_et' => Yii::t('HelpModule.ui', 'Title in Estonian'),
			'content_et' => Yii::t('HelpModule.ui', 'Content in Estonian'),
			'title_en' => Yii::t('HelpModule.ui', 'Title in English'),
			'content_en' => Yii::t('HelpModule.ui', 'Content in English'),
		);
	}

	/**
	 * @return string the localized attribute
	 */
	public function localizeAttribute($name)
	{
		return $name.'_'.Yii::app()->language;
	}

	/**
	 * @param integer help id
	 * @param string name of method that generates url
	 * @return html link
	 */
	public function buildEditLink($id, $urlMethod='createReturnableUrl')
	{
		$icon=CHtml::image(Yii::app()->baseUrl.'/images/update.png', Yii::t('HelpModule.ui','Edit'));
		$url=Yii::app()->controller->{$urlMethod}('/help/default/updateOnPage',array('id'=>$id));
		return CHtml::link($icon, $url);
	}

	// METHODS TO BE USED FROM WITHIN APPLICATION:

	/**
	 * Returns the item name for the specified type and code.
	 * @param string the item code (corresponding to the 'code' column value)
	 * @param string the item name ('title' or 'content').
	 * @return string the value for the specified the type and code. False is returned if the item type or code does not exist.
	 */
	public static function item($code,$name,$edit=false)
	{
		if(!isset(self::$_item))
			self::loadItems($code,$name);
		$item=isset(self::$_items[$code][$name]) ? self::$_items[$code][$name] : null;
		if($item && $edit)
			$item=$item.' '.Help::model()->buildEditLink(self::$_items[$code]['id']);

		return $item;
	}

	/**
	 * Loads the items for the specified type from the database.
	 * @param string the item code (corresponding to the 'code' column value)
	 * @param string the item name ('title' or 'content').
	 */
	private static function loadItems($code,$name)
	{
		self::$_items[$name]=array();
		$models=self::model()->findAll(array(
			'condition'=>'code=:code',
			'params'=>array(':code'=>$code),
		));
		$attr=self::model()->localizeAttribute($name);
		foreach($models as $model)
		{
			self::$_items[$code][$name]=$model->{$attr};
			self::$_items[$code]['id']=$model->id;
		}
	}
}