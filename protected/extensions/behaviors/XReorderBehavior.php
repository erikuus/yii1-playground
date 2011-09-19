<?php
/**
 * XReorderBehavior
 * 
 * This behavior adds reordering methods to a ActiveRecord model.
 * This behavior is designed to be used in connection with XReorderAction
 *  
 * It can be  be attached to a model on its behaviors() method: 
 * <pre>
 *  	public function behaviors()
 * 		{
 *     		return array(
 *     			'ReorderBehavior' => array(
 * 					'class' => 'ext.behaviors.XReorderBehavior',
 *          	),
 * 			);
 *		}
 * </pre> 
 * 
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XReorderBehavior extends CActiveRecordBehavior
{
	private $_groupId;
	
	/**
	 * @var string the attribute name of unique id
	 */
	public $id='id';
	/**
	 * @var string the attribute name of group id
	 */
	public $groupId='group_id';
	/**
	 * @var string the attribute name of order value
	 */
	public $sort='sort';	
	
	/**
	 * Move up
     */
	public function moveUp()
	{
		$owner=$this->getOwner();	
		$owner->{$this->sort}=$owner->{$this->sort}-1;
		$owner->update(array($this->sort));
		$model=$owner->find(array(
			'condition'=> "{$this->sort}=:sort AND {$this->groupId}=:groupId AND {$this->id}!=:id",
			'params'=> array(
				':sort'=>$owner->{$this->sort},
				':groupId'=>$owner->{$this->groupId},
				':id'=>$owner->{$this->id},
			)
		));
		$model->{$this->sort}=$model->{$this->sort}+1;
		$model->update(array($this->sort));
	}

	/**
	 * Move down
     */
	public function moveDown()
	{
		$owner=$this->getOwner();	
		$owner->{$this->sort}=$owner->{$this->sort}+1;
		$owner->update(array($this->sort));
		$model=$owner->find(array(
			'condition'=> "{$this->sort}=:sort AND {$this->groupId}=:groupId AND {$this->id}!=:id",
			'params'=> array(
				':sort'=>$owner->{$this->sort},
				':groupId'=>$owner->{$this->groupId},
				':id'=>$owner->{$this->id},
			)
		));
		$model->{$this->sort}=$model->{$this->sort}-1;
		$model->update(array($this->sort));
	}

	/**
	 * This is invoked when a record is populated with data from a find() call.
	 */
	public function afterFind($event)
	{
		$owner=$this->getOwner();
		$this->_groupId=$owner->{$this->groupId};
	}	

	/**
	 * This is invoked before the record is saved.
	 */
	public function beforeSave($event)
	{
		$owner=$this->getOwner();
			
		if($owner->isNewRecord)
			$owner->{$this->sort}=$this->queryNextSort($owner->{$this->groupId});				
		elseif($this->_groupId!=$owner->{$this->groupId})
			$owner->{$this->sort}=$this->queryNextSort($owner->{$this->groupId});			
	}

	/**
	 * This is invoked after the record is saved.
	 */
	public function afterSave($event)
	{
		$owner=$this->getOwner();
		
		if(!$owner->isNewRecord && $this->_groupId!=$owner->{$this->groupId})
		{	
			$this->repairSort($owner->{$this->groupId});
			$this->repairSort($this->_groupId);
		}
	}	
	
	/**
	 * Repair sort attribute
     * This is invoked after the record is deleted.
	 */
	public function afterDelete($event)
	{
		$owner=$this->getOwner();
		$this->repairSort($owner->{$this->groupId});
	}

	/**
	 * Get next available sort value
	 */
	protected function queryNextSort($groupId)
	{
		$owner=$this->getOwner();
		$model=$owner->find(array(
			'condition'=>"{$this->groupId}=$groupId",
			'order'=>"{$this->sort} DESC",
			'limit'=>1,
		));
		if($model===null)
			return 1;
		else
			return $model->{$this->sort}+1;
	}

	/**
	 * Repair sort attribute
	 */
	protected function repairSort($groupId)
	{
		$owner=$this->getOwner();
		$sort=1;
		$models=$owner->findAll(array(
			'condition'=>"{$this->groupId}=$groupId",
			'order'=>$this->sort
		));
		foreach($models as $model)
		{
			$model->{$this->sort}=$sort;
			$model->update(array($this->sort));
			$sort++;
		}
	}	
}