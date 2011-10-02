<?php
/**
 * XCompareRangeRequiredValidator validator
 *
 * The following shows how to use this validator on model actions() method
 * <pre>
 * return array(
 *     array('attr1','XCompareRangeRequiredValidator','compareAttribute'=>'attr2','compareRange'=>array(1,2),
 *         'message'=>Yii::t('ui','{attribute} cannot be blank if ...'),
 *     );
 * </pre>
 */
class XCompareRangeRequiredValidator extends CValidator
{
	/**
	 * @var string the name of the attribute to be compared with
	 */
	public $compareAttribute;
	/**
	 * @var array list of valid values to be compared with
	 */
	public $compareRange;
	/**
	 * @var boolean whether the comparison is strict (both type and value must be the same)
	 */
	public $strict=false;
	/**
	 * @var boolean whether the attribute value can be null or empty. Defaults to true,
	 * meaning that if the attribute is empty, it is considered valid.
	 */
	public $allowEmpty=true;

	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the object being validated
	 * @param string the attribute being validated
	 */
	protected function validateAttribute($object,$attribute){
		$value=$object->$attribute;
		$compareAttribute=$this->compareAttribute;
		$valueAttribute=$object->$compareAttribute;
		if($this->allowEmpty && $this->isEmpty($valueAttribute))
			return;
		if(is_array($this->compareRange) && in_array($valueAttribute,$this->compareRange,$this->strict))
		{
			if($value===null || trim($value)===''){
				$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} cannot be blank.');
				$this->addError($object,$attribute,$message);
			}
		}
	}
}