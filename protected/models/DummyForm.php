<?php
/**
 * DummyForm class.
 * DummyForm is the data structure for keeping dummy test data only. 
 */
class DummyForm extends CFormModel
{
	public $firstname;
	public $lastname;
	public $email;
	public $webpage;
	public $country_id;
	public $eyecolor_code;	
	public $gender_code;	
	public $lang_et;
	public $lang_en;
	public $lang_de;
	public $lang_ru;
	public $lang_es;
	public $lang_fi;
	public $persons;
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('firstname, lastname, gender_code', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'firstname' => Yii::t('ui', 'Firstname'),
			'lastname' => Yii::t('ui', 'Lastname'),
			'email' => Yii::t('ui', 'Email'),
			'webpage' => Yii::t('ui', 'Webpage'),
			'country_id' => Yii::t('ui', 'Country'),
			'eyecolor_code' => Yii::t('ui', 'Eyecolor'),
			'gender_code' => Yii::t('ui', 'Gender'),
			'lang_et' => Yii::t('ui', 'Estonian'),
			'lang_en' => Yii::t('ui', 'English'),
			'lang_de' => Yii::t('ui', 'German'),
			'lang_ru' => Yii::t('ui', 'Russian'),
			'lang_es' => Yii::t('ui', 'Spanish'),
			'lang_fi' => Yii::t('ui', 'Finnish'),
			'persons' => Yii::t('ui', 'Persons'),				
		);
	}
}