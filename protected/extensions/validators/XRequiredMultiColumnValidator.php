<?php
/**
 * XRequiredMultiColumnValidator validator
 *
 * The following shows how to use this validator on model actions() method
 * <pre>
 * return array(
 *     array('attr1+attr2+attr3','XRequiredMultiColumnValidator'),
 * );
 * </pre>
 */
class XRequiredMultiColumnValidator extends CValidator
{
	/**
	 * @var mixed the desired value that the attribute must have.
	 * If this is null, the validator will validate that the specified attribute does not have null or empty value.
	 * If this is set as a value that is not null, the validator will validate that
	 * the attribute has a value that is the same as this property value.
	 * Defaults to null.
	 * @since 1.0.10
	 */
	public $requiredValue;
	/**
	 * @var boolean whether the comparison to {@link requiredValue} is strict.
	 * When this is true, the attribute value and type must both match those of {@link requiredValue}.
	 * Defaults to false, meaning only the value needs to be matched.
	 * This property is only used when {@link requiredValue} is not null.
	 * @since 1.0.10
	 */
	public $strict=false;
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the object being validated
	 * @param string the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		$attributes=null;
		if(false !== strpos($attribute, "+"))
			$attributes = explode("+", $attribute);
		else
			$attributes = array($attribute);

		$countAttributes=count($attributes);
		$countErrors=0;
		foreach($attributes as $attribute)
		{
			$value=$object->$attribute;
			if($this->requiredValue!==null)
			{
				if(!$this->strict && $value!=$this->requiredValue || $this->strict && $value!==$this->requiredValue)
					$countErrors++;
			}
			else if($this->isEmpty($value,true))
				$countErrors++;
		}
		if($countAttributes==$countErrors)
		{
			$message='';
			$labels=$object->attributeLabels();
			foreach ($attributes as $attribute)
				$message.=$labels[$attribute] ? $labels[$attribute].", " : null;

			$message = substr ($message, 0, -2);
			$message = $this->message!==null ? $this->message : Yii::t('vd','At least one of these ({attributes}) should be filled.', array('{attributes}'=>$message));
			$this->addError($object,$attributes[0],$message);
		}
	}
}
