<?php
/**
 * XTreeBehavior behavior
 *
 * This behavior adds tree methods to an ActiveRecord model.
 * It can be  be attached to a model on its behaviors() method:
 * <pre>
 * public function behaviors()
 * {
 *     return array(
 *         'TreeBehavior' => array(
 *             'class' => 'ext.behaviors.XTreeBehavior',
 *         ),
 *     );
 * }
 * </pre>
 *
 * NOTE! This behavior requires that the model you want to attach this behavior:
 * 1) is related to table where root id>0 and root parent_id=0,
 * 2) has 'parent', 'children' and 'childCount' on its relations() method:
 * <pre>
 * return array(
 *     'parent' => array(self::BELONGS_TO, 'MyTree', 'parent_id'),
 *     'children' => array(self::HAS_MANY, 'MyTree', 'parent_id'),
 *     'childCount' => array(self::STAT, 'MyTree', 'parent_id'),
 * );
 * </pre>
 *
 * Methods that this behavior provides can be grouped as follows:
 * 1) methods for tree editing (beforeSave, deleteWithChildren, deleteKeepChildren)
 * 2) methods for tree display (follow examples below)
 *
 * The following examples shows how to use {@link getPathText()}
 *
 * <pre>
 * echo MyTree::model()->getPathText(1,false);
 * </pre>
 *
 * <pre>
 * $model=MyTree::model()->findByPk(1);
 * echo $model->pathText;
 * </pre>
 *
 * The following examples shows how to use {@link getBreadcrumbs()}
 *
 * <pre>
 * echo MyTree::model()->getBreadcrumbs(5,false);
 * </pre>
 *
 * <pre>
 * $model=MyTree::model()->findByPk(1);
 * echo $model->breadcrumbs;
 * </pre>
 *
 * The following examples shows how to use {@link getMenuItems()}
 *
 * <pre>
 * $this->widget('zii.widgets.CMenu',array(
 *     'items'=>MyTree::model()->getMenuItems(),
 * ));
 * </pre>
 *
 * <pre>
 * $this->widget('zii.widgets.CMenu',array(
 *     'items'=>MyTree::model()->getMenuItems(1,false),
 * ));
 * </pre>
 *
 * The following examples shows how to use {@link getTreeItems()}
 *
 * <pre>
 * $this->widget('CTreeView',array(
 *     'data'=>MyTree::model()->getTreeItems()
 * ));
 * </pre>
 *
 * <pre>
 * $this->widget('CTreeView',array(
 *     'data'=>MyTree::model()->getTreeItems(1,false)
 * ));
 * </pre>
 *
 * The following shows how to use {@link fillTree()}
 *
 * First set up fillTree action on RequestController actions() method
 * <pre>
 * return array(
 *     'fillTree'=>array(
 *         'class'=>'ext.actions.XFillTreeAction',
 *         'modelName'=>'MyTree',
 *     ),
 * );
 * </pre>
 *
 * And then set up widget
 * <pre>
 * $this->widget('CTreeView',array(
 *     'url'=>array('request/fillTree')
 * ));
 * </pre>
 *
 * NOTE! In order to format labels and urls you can connect owner model methods to this behavior.
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XTreeBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string the attribute name of tree node id
	 */
	public $id='id';
	/**
	 * @var string the attribute name of tree node parent id
	 */
	public $parent_id='parent_id';
	/**
	 * @var string the attribute name of tree node label
	 */
	public $label='label';
	/**
	 * @var string the attribute name to order tree nodes by
	 */
	public $sort='id';
	/**
	 * @var mixed the with method parameter of owner model
	 */
	public $with=array();
	/**
	 * @var string the name of owner model method to format path label
	 */
	public $pathLabelMethod=null;
	/**
	 * @var string the name of owner model method to format breadcrumbs label
	 */
	public $breadcrumbsLabelMethod=null;
	/**
	 * @var string the name of owner model method to format breadcrumbs url
	 */
	public $breadcrumbsUrlMethod=null;
	/**
	 * @var string the name of owner model method to format menu label
	 */
	public $menuLabelMethod=null;
	/**
	 * @var string the name of owner model method to format menu url
	 */
	public $menuUrlMethod=null;
	/**
	 * @var string the name of owner model method to format tree label
	 */
	public $treeLabelMethod=null;
	/**
	 * @var string the name of owner model method to format tree url
	 */
	public $treeUrlMethod=null;

	/**
	 * @return int id of the absolute root node
	 */
	public function getRootId()
	{
		$owner=$this->getOwner();
		$root=$owner->find($this->parent_id.'=0');
		return $root->id;
	}

	/**
	 * @param model the instance of ActiveRecord
	 * @param bool $showRoot wether the absolute root node should be returned
	 * @return array of parent models
	 */
	public function getParents($model,$showRoot=false)
	{
		$parents=array();
		if ($showRoot===false && $model->parent->{$this->parent_id} > 0)
		{
			$parents[]=$model->parent;
			$parents=array_merge($this->getParents($model->parent,false), $parents);
		}
		if($showRoot===true && $model->parent)
		{
			$parents[]=$model->parent;
			$parents=array_merge($this->getParents($model->parent,true), $parents);
		}
		return $parents;
	}

	/**
	 * @param model the instance of ActiveRecord
	 * @return array of all children models
	 */
	public function getAllChildren($model)
	{
		$children=array();
		if($model->children)
		{
			foreach($model->children as $child)
			{
				$children[]=$child;
				$children=array_merge($this->getAllChildren($child), $children);
			}
		}
		return $children;
	}

	/**
	 * @param int $id the id of the tree node
	 * @param bool $showRoot wether the root node should be displayed
	 * @param bool $showRoot wether the current node should be displayed
	 * @return sting of path
	 */
	public function getPathText($id=null,$showRoot=true,$showNode=true)
	{
		$owner=$this->getOwner();
		$childId=($id===null) ? $owner->getAttribute($this->id) : $id;
		$model=$owner->findByPk($childId);
		if($model===null)
			return null;
		$items=array();
		foreach($this->getParents($model,$showRoot) as $parent)
			$items[]=$this->formatPathText($parent);
		if($showNode===true)
			$items[]=$this->formatPathText($model);
		return implode(' / ', $items);
	}

	/**
	 * @param int $id the id of the tree node
	 * @param bool $showRoot wether the root node should be displayed
	 * @return string of breadcrumbs
	 */
	public function getBreadcrumbs($id=null,$showRoot=true)
	{
		$owner=$this->getOwner();
		$childId=($id===null) ? $owner->getAttribute($this->id) : $id;
		$model=$owner->findByPk($childId);
		if($model===null)
			return null;
		$items=array();
		foreach($this->getParents($model,$showRoot) as $parent)
			$items[]=$this->formatBreadcrumbsLink($parent);
		if($items!==array())
			$items[]=$this->formatBreadcrumbsLabel($model);
		return implode(' &raquo; ', $items);
	}

	/**
	 * @param int $id the id of the relative root node
	 * @param bool $showRoot wether the relative root node should be displayed
	 * @return array of items for CMenu widget
	 */
	public function getMenuItems($id=null,$showRoot=true)
	{
		$owner=$this->getOwner();
		$rootId=($id===null) ? $this->getRootId() : $id;
		$items=array();
		if ($showRoot===false)
		{
			$models=$owner->findAll(array(
				'condition'=>$this->parent_id.'='.$rootId,
				'order'=>$this->sort
			));
			if($models===null)
				throw new CException('The requested menu does not exist.');
			foreach($models as $model)
				$items[]=$model->getMenuSubItems();
		}
		else
		{
			$model=$owner->findByPk($rootId);
			if($model===null)
				throw new CException('The requested menu does not exist.');
			else
				$items[]=$model->getMenuSubItems();
		}
		return $items;
	}

	/**
	 * @param int $id the id of the relative root node
	 * @param bool $showRoot wether the relative root node should be displayed
	 * @return array of items for CTreeView widget
	 */
	public function getTreeItems($id=null,$showRoot=true)
	{
		$owner=$this->getOwner();
		$rootId=($id===null) ? $this->getRootId() : $id;
		$items=array();
		if ($showRoot===false)
		{
			$models=$owner->findAll(array(
				'condition'=>$this->parent_id.'='.$rootId,
				'order'=>$this->sort
			));
			if($models===null)
				throw new CException('The requested tree does not exist.');
			foreach($models as $model)
				$items[]=$model->getTreeSubItems();
		}
		else
		{
			$model=$owner->findByPk($rootId);
			if($model===null)
				throw new CException('The requested tree does not exist.');
			else
				$items[]=$model->getTreeSubItems();
		}
		return $items;
	}

	/**
	 * @param int $id the id of the relative root node
	 * @param bool $showRoot wether the relative root node should be displayed
	 * @return array of children nodes for CTreeView widget in Ajax mode
	 */
	public function fillTree($id=null, $showRoot=true)
	{
		$owner=$this->getOwner();
		$rootId=($id===null) ? $this->getRootId() : $id;
		$items=array();
		if ($showRoot===false)
		{
			$models=$owner->with($this->getWidth())->findAll(array(
				'condition'=>$this->parent_id.'=:id',
				'params'=>array(':id'=>$rootId),
				'order'=>$this->sort,
			));
			if($models===null)
				throw new CException('The requested tree does not exist.');
			foreach($models as $model)
				$items[]=$this->formatTreeItem($model);
		}
		else
		{
			$model=$owner->with($this->getWidth())->findByPk($rootId);
			if($model===null)
				throw new CException('The requested tree does not exist.');
			$items[]=$this->formatTreeItem($model);
		}
		return $items;
	}

	/**
	 * Deletes a particular model and updates its child models.
	 */
	public function deleteKeepChildren()
	{
		$owner=$this->getOwner();
		$id=$owner->getAttribute($this->id);
		$model=$owner->findbyPk($id);
		foreach($model->children as $child)
		{
			$child->{$this->parent_id}=$model->{$this->parent_id};
			$child->update($this->parent_id);
		}
		$model->delete();
	}

	/**
	 * Delete a particular model and all its child models.
	 */
	public function deleteWithChildren()
	{
		$owner=$this->getOwner();
		$id=$owner->getAttribute($this->id);
		$model=$owner->findbyPk($id);
		foreach($this->getAllChildren($model) as $child)
			$child->delete();

		$model->delete();
	}

	/**
	 * This is invoked before the record is saved.
	 */
	public function beforeSave($event)
	{
		$owner=$this->getOwner();
		$parentId=$owner->getAttribute($this->parent_id);
		$newParent=$owner->findbyPk($parentId);
		if($newParent===null)
		{
			$owner->addError($this->parent_id, Yii::t('treeBehavior','Parent node does not exist.'));
			$event->isValid=false;
		}

		if (!$owner->getIsNewRecord())
		{
			$id=$owner->getAttribute($this->id);
			if($parentId==$id)
			{
				$owner->addError($this->parent_id,Yii::t('treeBehavior','This parent node is not allowed, because node cannot be child of itself.'));
				$event->isValid=false;
			}
			$oldModel=$owner->findbyPk($id);
			if($oldModel->parent_id!=$parentId)
			{
				foreach($this->getParents($newParent) as $parent)
				{
					if($parent->id==$id)
					{
						$owner->addError($this->parent_id, Yii::t('treeBehavior','This parent node is not allowed, because it is child node of the given node.'));
						$event->isValid=false;
						break;
					}
				}
			}
		}
	}

	/**
	 * @return subarray of items for CMenu widget
	 */
	protected function getMenuSubItems()
	{
		$owner=$this->getOwner();
		$subItems=array();
		if($owner->children)
		{
			foreach($owner->children as $child)
				$subItems[]=$child->getMenuSubItems();
		}
		$items=$this->formatMenuItem($owner);
		if($subItems!=array())
			$items=array_merge($items, array('items'=>$subItems));
		return $items;
	}

	/**
	 * @return subarray of items for CTreeView widget
	 */
	protected function getTreeSubItems()
	{
		$owner=$this->getOwner();
		$subItems=array();
		if($owner->children)
		{
			foreach($owner->children as $child)
				$subItems[] = $child->getTreeSubItems();
		}
		$items=$this->formatTreeItem($owner);
		if($subItems!=array())
			$items=array_merge($items, array('children'=>$subItems));
		return $items;
	}

	/**
	 * @param model the instance of ActiveRecord
	 * @return string label for path text
	 */
	protected function formatPathText($model)
	{
		if($this->pathLabelMethod!==null)
			$label=$model->{$this->pathLabelMethod}();
		else
			$label=$model->getAttribute($this->label);

		return $label;
	}

	/**
	 * @param model the instance of ActiveRecord
	 * @return string link for CBreadcrumbs widget
	 */
	protected function formatBreadcrumbsLink($model)
	{
		$label=$this->formatBreadcrumbsLabel($model);

		if($this->breadcrumbsUrlMethod!==null)
			$url=$model->{$this->breadcrumbsUrlMethod}();
		else
			$url=array('', 'id'=>$model->getAttribute($this->id));

		return CHtml::link(CHtml::encode($label), $url);
	}

	/**
	 * @param model the instance of ActiveRecord
	 * @return string label for CBreadcrumbs widget
	 */
	protected function formatBreadcrumbsLabel($model)
	{
		if($this->breadcrumbsLabelMethod!==null)
			$label=$model->{$this->breadcrumbsLabelMethod}();
		else
			$label=$model->getAttribute($this->label);

		return $label;
	}

	/**
	 * @param model the instance of ActiveRecord
	 * @return array of menu item formatted for CMenu widget
	 */
	protected function formatMenuItem($model)
	{
		if($this->menuLabelMethod!==null)
			$label=$model->{$this->menuLabelMethod}();
		else
			$label=$model->getAttribute($this->label);

		if($this->menuUrlMethod!==null)
			$url=$model->{$this->menuUrlMethod}();
		else
			$url=array('', 'id'=>$model->getAttribute($this->id));

		return array('label'=>$label, 'url'=>$url);
	}

	/**
	 * @param model the instance of ActiveRecord
	 * @return array of tree item formatted for CTreeview widget
	 */
	protected function formatTreeItem($model)
	{
		if($this->treeLabelMethod!==null)
			$label=$model->{$this->treeLabelMethod}();
		else
			$label=$model->getAttribute($this->label);

		if($this->treeUrlMethod!==null)
			$url=$model->{$this->treeUrlMethod}();
		else
			$url='#';

		return array(
			'text'=>CHtml::link($label, $url, array('id'=>$model->getAttribute($this->id))),
			'id'=>$model->getAttribute($this->id),
			'hasChildren'=>$model->childCount==0 ? false : true,
		);
	}

	/**
	 * @return mixed with method parameters
	 */
	protected function getWidth()
	{
		return $this->with===array() ? 'childCount' : CMap::mergeArray(array('childCount'),$this->with);
	}
}