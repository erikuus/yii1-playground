<?php
/**
 * XUniqueMultiColumnValidator validator
 *
 * The following shows how to use this validator on model actions() method
 * <pre>
 * return array(
 *     array('attr1+attr2+attr3','XUniqueMultiColumnValidator','caseSensitive'=>true),
 * );
 * </pre>
 *
 * NOTE! Message translation nee
 *
 */
class XUniqueMultiColumnValidator extends CValidator
{
	public $allowEmpty = false;
	public $caseSensitive = false;

	protected function validateAttribute($object,$attribute)
	{
		$attributes = null;
		$criteria=array('condition'=>'');
		if(false !== strpos($attribute, "+"))
			$attributes = explode("+", $attribute);
		else
			$attributes = array($attribute);

		foreach($attributes as $attribute)
		{
			$value = $object->$attribute;
			if($this->allowEmpty && ($value===null || $value===''))
				return;

			$column=$object->getTableSchema()->getColumn($attribute);
			if($column===null)
				throw new CException(Yii::t('yii','{class} does not have attribute "{attribute}".',

			array('{class}'=>get_class($object), '{attribute}'=>$attribute)));
			$columnName=$column->rawName;
			if(''!=$criteria['condition'])
				$criteria['condition'].= " AND ";

			$criteria['condition'].=$this->caseSensitive===false || is_numeric($value) || is_bool($value) ? "$columnName=:$attribute" : "LOWER($columnName)=LOWER(:$attribute)";
			$criteria['params'][':'.$attribute]=$value;
		}

		if($column->isPrimaryKey)
			$exists=$object->exists($criteria);
		else
		{
			// need to exclude the current record based on PK
			$criteria['limit']=2;
			$objects=$object->findAll($criteria);
			$n=count($objects);
			if($n===1)
			{
				if(''==$object->getPrimaryKey())
					$exists = true;
				else
					$exists=$objects[0]->getPrimaryKey()!==$object->getPrimaryKey();
			}
			else
				$exists=$n>1;
		}
		if($exists)
		{
			$message = '';
			$labels = $object->attributeLabels();
			foreach ($attributes as $attribute)
				$message .= isset($labels[$attribute]) ? $labels[$attribute].", " : null;

			$message = substr ($message, 0, -2);
			$message = $this->message!==null ? $this->message : Yii::t('vd','The Combination of ({attributes}) should be unique.', array('{attributes}'=>$message));
			$this->addError($object,$attributes[0],$message);
		}
	}
}
