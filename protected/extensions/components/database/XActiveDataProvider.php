<?php
/**
 * XActiveDataProvider
 * An extension on CActiveDataProvider so scopes can be applied
 *
 * Usage:
 * <pre>
 * $dataProvider=new XActiveDataProvider('Post', array(
 *     'scopes'=>array('published'),
 *     'criteria'=>array(
 *         //'condition'=>'status=1 AND tags LIKE :tags',
 *         //'params'=>array(':tags'=>$_GET['tags']),
 *         'with'=>array('author'),
 *     ),
 *     'pagination'=>array(
 *         'pageSize'=>20,
 *     ),
 * ));
 * $dataProvider->joinAll = true; // optional if you want to also join the *_MANY relations
 * $dataProvider->getData() will return a list of Post objects
 *
 * </pre>
 *
 * @package system.web
 * @author Dragos Protung (dragos@protung.ro)
 * @since 1.1
 */
class XActiveDataProvider extends CActiveDataProvider
{
	/**
	 * @var bool Flag that the scopes have been added
	 */
	private $_scopesAdded=false;

	/**
	 * @var array Scopes to be aplied
	 */
	protected $_scopes=array();

	/**
	 * @var bool Flag for using together()
	 */
	public $joinAll=false;

	public function setScopes($scopes)
	{
		$this->_scopes=CPropertyValue::ensureArray($scopes);
	}

	public function getScopes()
	{
		return $this->_scopes;
	}

	/**
	 * Fetches the data from the persistent data storage.
	 * @return array list of data items
	 */
	protected function fetchData()
	{
		$this->addScopes();
		$criteria=$this->getCriteria();
		if(($pagination=$this->getPagination())!==false)
		{
			$pagination->setItemCount($this->getTotalItemCount());
			$pagination->applyLimit($criteria);
		}
		if(($sort=$this->getSort())!==false)
			$sort->applyOrder($criteria);

		// Use together() for query?
		if($this->joinAll)
			return CActiveRecord::model($this->modelClass)->with($criteria->with)->together()->findAll($criteria);
		else
			return CActiveRecord::model($this->modelClass)->findAll($criteria);
	}

	/**
	 * Calculates the total number of data items.
	 * @return integer the total number of data items.
	 */
	protected function calculateTotalItemCount()
	{
		$this->addScopes();
		return CActiveRecord::model($this->modelClass)->count($this->getCriteria());
	}

	private function addScopes()
	{
		if($this->_scopesAdded===false)
		{
			$criteria=clone $this->getCriteria();

			if(isset($this->_scopes))
			{
				foreach($this->_scopes as $scope)
				{
					CActiveRecord::model($this->modelClass)->{$scope}();
				}
				CActiveRecord::model($this->modelClass)->applyScopes($criteria);
				$this->setCriteria($criteria);
			}
			$this->_scopesAdded=true;
		}
	}
}