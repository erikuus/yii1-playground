<?php
class XDbCriteria extends CDbCriteria
{
	/**
	 * Appends search condition with meta symbols to the existing {@link condition}.
	 * @param string $column the column name (or a valid SQL expression)
	 * @param string $keyword the search keyword. This interpretation of the keyword is affected by the next parameter.
	 * @param boolean $escape whether the keyword should be escaped if it contains characters % or _.
	 * @param string $operator the operator used to concatenate the new condition with the existing one.
	 * @param string $like the LIKE operator. Defaults to 'LIKE'. You may also set this to be 'NOT LIKE'.
	 * @return CDbCriteria the criteria object itself
	 */
	public function mcompare($column, $keyword, $operator='AND', $like='LIKE')
	{
		return $this->addSearchCondition("LOWER($column)",$this->formatSearch($keyword,true),false,$operator,$like);
	}

	/**
	 * Adds a case insensitive comparison expression to the {@link condition} property.
	 *
	 * This method is a helper that appends to the {@link condition} property
	 * with a new comparison expression. The comparison is done by comparing a column
	 * with the given value using some comparison operator.
	 *
	 * Note that any surrounding white spaces will be removed from the value before comparison.
	 * When the value is empty, no comparison expression will be added to the search condition.
	 *
	 * @param string $column the name of the column to be searched
	 * @param string value to be compared with.
	 * @param boolean $partialMatch whether the value should consider partial text match (using LIKE and NOT LIKE operators).
	 * Defaults to false, meaning exact comparison.
	 * @param string $operator the operator used to concatenate the new condition with the existing one.
	 * Defaults to 'AND'.
	 * @return CDbCriteria the criteria object itself
	 */

	public function icompare($column, $value, $partialMatch=false, $operator='AND')
	{
		$value="$value";

		if(preg_match('/^(?:\s*(<>|<=|>=|<|>|=))?(.*)$/',$value,$matches))
		{
			$value=$matches[2];
			$op=$matches[1];
		}
		else
			$op='';

		if($value==='')
			return $this;

		if($partialMatch)
		{
			if($op==='')
				return $this->addSearchCondition("LOWER($column)",$this->formatSearch($value),true,$operator);
			if($op==='<>')
				return $this->addSearchCondition("LOWER($column)",$this->formatSearch($value),true,$operator,'NOT LIKE');
		}
		else if($op==='')
			$op='=';

		$this->addCondition("LOWER($column)".$op.self::PARAM_PREFIX.self::$paramCount,$operator);
		$this->params[self::PARAM_PREFIX.self::$paramCount++]=$this->formatSearch($value);

		return $this;
	}

	/**
	 * Formats search string
	 * @param string search from user input
	 * @param boolean whether to convert meta symbols
	 * @return string search for sql
	 */
	public function formatSearch($str, $symbols=false)
	{
		if($symbols===true)
			$str=strtr($str, array('*'=>'%','?'=>'_'));
		return mb_strtolower($str);
	}
}