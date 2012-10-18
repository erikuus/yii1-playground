<?php
/**
 * XReorderBehavior
 *
 * This behavior adds reordering methods to a ActiveRecord model.
 *
 * This behavior is designed to be used in connection with
 * - XReorderAction
 * - XReorderColumn
 *
 * It can be  be attached to a model on its behaviors() method:
 * <pre>
 * public function behaviors()
 * {
 *     return array(
 *         'ReorderBehavior' => array(
 *             'class'=>'ext.behaviors.XReorderBehavior',
 *             'groupId'=>'parent_id',
 *         ),
 *     );
 * }
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.1.0
 */
class XReorderBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string the attribute name of unique id
	 */
	public $id='id';
	/**
	 * @var string the attribute name of sort value. Defaults to 'sort'.
	 */
	public $sort='sort';
	/**
	 * @var mixed the column value defining subset for reordering.
	 * This can be either single column name: "group_id"
	 * or array of column names: array("group_id", "subgroup_id").
	 * If left empty, no group restrictions will be applied to reordering.
	 */
	public $groupId;
	/**
	 * @var string scenario name for soft delete.
	 * Sometimes, instead of permanent delete, we want to use soft delete (hiding record
	 * by setting some attribute, for example: deleted=true). In this case we can not rely
	 * on afterDelete method for repairing sort values. But when we run soft delete
	 * under specific scenario, afterSave method takes care of repairing sort values.
	 */
	public $softDeleteScenario='softDelete';

	private $_groupId;
	private $_groupCondition;

	/**
	 * Move item up by one step.
	 * If this is first item, move it into last place
	 */
	public function moveUp()
	{
		$owner=$this->getOwner();
		if($owner->{$this->sort}==1)
		{
			$owner->{$this->sort}=$this->maxSort+1;
			$owner->update($this->sort);
			$this->repairSort($this->groupCondition);
		}
		else
		{
			$owner->{$this->sort}=$owner->{$this->sort}-1;
			$owner->update($this->sort);
			$this->updateDuplicate($owner->{$this->sort}+1);
		}
	}

	/**
	 * Move item down by one step.
	 * If this is last item, move it into first place
	 */
	public function moveDown()
	{
		$owner=$this->getOwner();
		if($owner->{$this->sort}==$this->maxSort)
		{
			$owner->{$this->sort}=0;
			$owner->update($this->sort);
			$this->repairSort($this->groupCondition);
		}
		else
		{
			$owner->{$this->sort}=$owner->{$this->sort}+1;
			$owner->update($this->sort);
			$this->updateDuplicate($owner->{$this->sort}-1);
		}
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 * Store group id and group condition in private properties to be used
	 * before and after save.
	 */
	public function afterFind($event)
	{
		$this->_groupId=$this->groupIdValue;
		$this->_groupCondition=$this->groupCondition;
	}

	/**
	 * This is invoked before the record is saved.
	 * If new model is created or existing model moved from one group
	 * to another get next available sort value within target group.
	 * If model is updated under soft delete scenario, set sort to null.
	 */
	public function beforeSave($event)
	{
		$owner=$this->getOwner();

		if($owner->isNewRecord || $this->_groupId!=$this->groupIdValue)
			$owner->{$this->sort}=$this->maxSort+1;
		elseif($owner->scenario==$this->softDeleteScenario)
			$owner->{$this->sort}=null;
	}

	/**
	 * This is invoked after the record is saved.
	 * Repair sort attributes if model moved from one group to another
	 */
	public function afterSave($event)
	{
		$owner=$this->getOwner();

		if(!$owner->isNewRecord && $this->_groupId!=$this->groupIdValue)
		{
			$this->repairSort($this->groupCondition);
			$this->repairSort($this->_groupCondition);
		}
		elseif($owner->scenario==$this->softDeleteScenario)
			$this->repairSort($this->groupCondition);
	}

	/**
	 * This is invoked after the record is deleted.
	 * Repair sort attribute
	 */
	public function afterDelete($event)
	{
		$owner=$this->getOwner();
		$this->repairSort($this->groupCondition);
	}

	/**
	 * Get group sql condition.
	 * This can be either single condition (ex. group_id='1')
	 * or multiple conditions glued with "AND" (ex. group_id='1' AND subgroup_id='1')
	 * @return string sql condition defining a group
	 */
	protected function getGroupCondition()
	{
		$owner=$this->getOwner();
		$alias=$owner->getTableAlias();
		if(is_array($this->groupId))
		{
			$condition=array();
			foreach ($this->groupId as $groupId)
			{
				if($owner->{$groupId})
					$condition[]="{$alias}.{$groupId}='".$owner->{$groupId}."'";
			}
			return implode(' AND ', $condition);
		}
		elseif($this->groupId && $owner->{$this->groupId})
			return "{$alias}.{$this->groupId}='".$owner->{$this->groupId}."'";
		else
			return '1=1'; //dummy condition
	}

	/**
	 * Get group id value.
	 * This can be either single attribute value (ex. 1)
	 * or list of attribute values glued with "|" (ex. 1|9)
	 * or null if group id attribute is unspecified
	 * @return string group defining value
	 */
	protected function getGroupIdValue()
	{
		$owner=$this->getOwner();

		if(is_array($this->groupId))
		{
			$value=array();
			foreach ($this->groupId as $groupId)
				$value[]=$owner->{$groupId};
			return implode('|', $value);
		}
		elseif($this->groupId)
			return $owner->{$this->groupId};
		else
			return null;
	}

	/**
	 * Get max sort value within group.
	 * @return integer max sort value within group
	 */
	protected function getMaxSort()
	{
		$owner=$this->getOwner();
		$alias=$owner->getTableAlias();
		$model=$owner->find(array(
			'condition'=>"{$alias}.{$this->sort} IS NOT NULL AND {$this->groupCondition}",
			'order'=>"{$alias}.{$this->sort} DESC",
			'limit'=>1,
		));
		if($model===null)
			return 0;
		else
			return $model->{$this->sort};
	}

	/**
	 * Update duplicate sort value
	 * After increasing or decreasing sort value of given item,
	 * there are two items with same sort value (duplicate).
	 * This updates sort value of item that was not moved.
	 * @param integer new sort value for duplicate
	 */
	protected function updateDuplicate($newSort)
	{
		$owner=$this->getOwner();
		$alias=$owner->getTableAlias();
		$model=$owner->find(array(
			'condition'=> "{$alias}.{$this->id}!=:id AND {$alias}.{$this->sort}=:sort AND {$this->groupCondition}",
			'params'=> array(
				':id'=>$owner->{$this->id},
				':sort'=>$owner->{$this->sort}
			)
		));
		if($model!==null)
		{
			$model->{$this->sort}=$newSort;
			$model->update($this->sort);
		}
	}

	/**
	 * Repair sort attributes within group.
	 * If model is deleted or moved from one group to another
	 * we need to repair sort values within group. For example
	 * from 1, 2, 4 to 1, 2, 3.
	 */
	protected function repairSort($condition)
	{
		$owner=$this->getOwner();
		$alias=$owner->getTableAlias();
		$sort=1;
		$models=$owner->findAll(array(
			'condition'=>"{$alias}.{$this->sort} IS NOT NULL AND $condition",
			'order'=>"{$alias}.{$this->sort}"
		));
		foreach($models as $model)
		{
			$model->{$this->sort}=$sort;
			$model->update(array($this->sort));
			$sort++;
		}
	}
}