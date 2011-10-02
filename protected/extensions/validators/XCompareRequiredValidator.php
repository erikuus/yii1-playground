<?php
/**
 * XCompareRequiredValidator validator
 *
 * The following shows how to use this validator on model actions() method
 * <pre>
 * return array(
 *     array('attr1','XCompareRequiredValidator','compareAttribute'=>'attr2','compareValue'=>1),
 * );
 * </pre>
 */
class XCompareRequiredValidator extends CValidator
{
	/**
	 * @var string the name of the attribute to be compared with
	 */
	public $compareAttribute;
	/**
	 * @var string the constant value to be compared with
	 */
	public $compareValue;
	/**
	 * @var boolean whether the attribute value can be null or empty. Defaults to true,
	 * meaning that if the attribute is empty, it is considered valid.
	 */
	public $allowEmpty=true;
	/**
	 * @var string the operator for comparison. Defaults to '='.
	 */
	public $operator='=';

	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the object being validated
	 * @param string the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		$value=!is_array($object->$attribute) ? $object->$attribute : implode('',$object->$attribute);
		$compareAttribute=$this->compareAttribute;
		$valueAttribute=$object->$compareAttribute;
		if($this->allowEmpty && ($valueAttribute===null || trim($valueAttribute)===''))
		{
			if($value===null || trim($value)==='')
			{
				$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} cannot be blank.');
				$this->addError($object,$attribute,$message);
			}
		}

		switch($this->operator)
		{
			case '=':
			case '==':
				if($valueAttribute==$this->compareValue)
				{
					if($value===null || trim($value)==='')
					{
						$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} cannot be blank.');
						$this->addError($object,$attribute,$message);
					}
				}
			break;
			case '!=':
				if($valueAttribute!=$this->compareValue)
				{
					if($value===null || trim($value)==='')
					{
						$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} cannot be blank.');
						$this->addError($object,$attribute,$message);
					}
				}
			break;
		}
	}
}