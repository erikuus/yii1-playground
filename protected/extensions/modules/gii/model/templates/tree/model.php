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

/**
 * Before we start generating the tree model we validate:
 * - if table has at least one string column needed for tree label 
 * - if table has columns named id and parent_id
 */
$treeLabelAttribute=null;
foreach($columns as $column)
{
	if($column->type=='string') 
	{
		$treeLabelAttribute=$column->name; 
		break;
	}
}
if($treeLabelAttribute===null)
	throw new CHttpException(500,'To use tree template, table must have at least one string column!');
if(!in_array('id',array_keys($labels)))
	throw new CHttpException(500, 'To use tree model template, table must have column named "id"!');
if(!in_array('parent_id',array_keys($labels)))
	throw new CHttpException(500, 'To use tree model template, table must have column named "parent_id"!');
?>

<?php echo "<?php\n"; ?>

/**
 * This is the model class for table "<?php echo $tableName; ?>".
 */
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass."\n"; ?>
{
	/**
	 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
	 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
	 */

	public $parentPath;

	/**
	 * Returns the static model of the specified AR class.
	 * @return <?php echo $modelClass; ?> the static model class
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
		return '<?php echo $tableName; ?>';
	}
	
	/**
	 * @return array behaviors.
	 */
	public function behaviors()
	{
    	return array(
    		// NOTE: you may need to change label attribute
    		'TreeBehavior' => array(
				'class' => 'ext.behaviors.XTreeBehavior',
				'label' => '<?php echo $treeLabelAttribute; ?>',
				'menuUrlMethod'=>'getMenuUrl',
				/*
				'sort'=>'',	
				'pathLabelMethod'=>'',	
				'breadcrumbsLabelMethod'=>'',
				'breadcrumbsUrlMethod'=>'',		
				'menuLabelMethod'=>'',	
				'treeLabelMethod'=>'',
				'treeUrlMethod'=>'',				
				*/
            ),
    	);
	}	

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
			array('parentPath', 'safe'),
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
			'parent' => array(self::BELONGS_TO, '<?php echo $modelClass; ?>', 'parent_id'),
			'children' => array(self::HAS_MANY, '<?php echo $modelClass; ?>', 'parent_id'),
			'childCount' => array(self::STAT, '<?php echo $modelClass; ?>', 'parent_id'),
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
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
	 * @return array menu url
	 */
	public function getMenuUrl()
	{			
		if(Yii::app()->controller->action->id=='adminMenu')
			return array('admin', 'id'=>$this->id);
		else
			return array('index', 'id'=>$this->id);
	}
	
	/**
	 * Retrieves a list of child models
	 * @param integer the id of the parent model
	 * @return CActiveDataProvider the data provider
	 */
	public function getDataProvider($id=null)
	{			
		// NOTE: you may need to change order criteria
		if($id===null)
			$id=$this->TreeBehavior->getRootId();
		$criteria=new CDbCriteria(array(
			'condition'=>'parent_id=:id',
			'params'=>array(':id'=>$id),
			'order'=>'<?php echo $treeLabelAttribute; ?>',
			'with'=>'childCount',
		));
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	/**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
	public function suggest($keyword,$limit=20)
	{
		// NOTE: you may need to change label attribute
		$models=$this->findAll(array(
			'condition'=>'<?php echo $treeLabelAttribute; ?> ILIKE :keyword',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"$keyword%"),
			'order'=>'<?php echo $treeLabelAttribute; ?>',
		));
		$suggest=array();	
		foreach($models as $model) {
    		$suggest[] = array(
        		'label'=>$model->TreeBehavior->pathText,  // label for dropdown list          
        		'value'=>$model-><?php echo $treeLabelAttribute; ?>,  // value for input field          
        		'id'=>$model->id,       // return values from autocomplete
        	);      
		}
		return $suggest;
	}	
}