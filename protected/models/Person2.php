<?php
/**
 * Needed for tabular input example only
 */
class Person2 extends Person
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>