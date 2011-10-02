<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $modelClass; ?> extends CFormModel
{
	/**
	 * The followings are the search parameters
	 */
<?php foreach($columns as $column): ?>
	 <?php echo 'public $'.$column->name.";\n"; ?>
<?php endforeach; ?>

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			// The following rule is used by search.
			// Please remove those attributes that should not be searched.
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
			// The following rule is used by advanced search
			// Please remove those attributes that should not be searched by advanced search.
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'searchAdvanced'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
<?php foreach($labels as $name=>$label): ?>
			<?php echo "'$name' => Yii::t('md', '$label'),\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * @return array of params for search url
	 */
	public function buildParams()
	{
		$params=array();
		foreach ($this->attributes as $name=>$value)
		{
			if ($value)
				$params[$name]=trim($value);
		}
		if($params!==array())
			$params['q']= 1;

		return $params;
	}

	/**
	 * @return array get params that match form attributes
	 */
	public function getParams()
	{
		$params=array();
		foreach ($_GET as $name=>$value)
		{
			if (in_array($name, $this->safeAttributeNames))
				$params[$name]=$value;
		}
		return $params;
	}
}