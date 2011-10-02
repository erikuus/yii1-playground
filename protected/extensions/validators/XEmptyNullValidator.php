<?php
/**
 * XEmptyNullValidator class file.
 *
 * @author Tim Beck <tim@beckcentral.org>
 * @copyright Copyright &copy; 2010 Sillero (Pty) Ltd
 */

/**
 * EmptyValidator sets the attributes with null if empty.
 * Empty includes an empty string, zero, false or any other value
 * passed in emptyValues
 * It does not do validation. It simply changes an empty value to null
 *
 * @author Tim Beck <tim@beckcentral.org>
 */
class XEmptyNullValidator extends CValidator
{
	/**
	 * @var mixed the value/s to be condidered as empty - other than
	 * those returning true from the empty() PHP function.
	 * emptyValues can be either a scalar value or an array of values
	 */
	public $emptyValues;
	/**
	 * @var boolean whether the comparison to emptyValues is case
	 * insensitive with lowercase comparison. Defaults to false.
	 * Note, by setting it to true, you are assuming the attribute type is string.
	 */
	public $lowercaseCompare=false;
	/**
	 * @var boolean whether the attribute value should be whitespace trimmed
	 * before checking for empty. Defaults to false.
	 * Note, by setting it to true, you are assuming the attribute type is string.
	 */
	public $trimValue=false;
	/**
	 * @var boolean whether the attribute value of zero should be ignored as
	 * empty -  ie: not empty. Defaults to false.
	 * Note, by setting it to true, you are assuming the attribute type is numeric.
	 */
	public $ignoreZero=false;
	/**
	 * Validates the attribute of the object.
	 * @param CModel the object being validated
	 * @param string the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		$value = $object->$attribute;
		if ($value !== null) {
			$compareVal = $value;
			if ($this->trimValue)
				$compareVal = trim($value);
			if (empty($compareVal)) {
				if (!($this->ignoreZero && is_numeric($compareVal) && ((int)$compareVal === 0)))
					$value = null;
			}
			elseif ($this->emptyValues !== null) {
				if ($this->lowercaseCompare)
					$compareVal = mb_strtolower($value);
				if (is_array($this->emptyValues)) {
					if (in_array($compareVal, $this->emptyValues))
						$value = null;
				}
				elseif ($compareVal == $this->emptyValues)
					$value = null;
			}
		}
		$object->$attribute = $value;
	}
}