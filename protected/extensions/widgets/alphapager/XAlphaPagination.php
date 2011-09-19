<?php
/**
 * XAlphaPagination class file.
 *
 * XAlphaPagination represents information relevant to XAlphaPageLinker.
 * Strongly based on Qiang Xues {@link CPagination} from yiiframework.
 *
 * @author Jascha Koch
 * @license http://www.yiiframework.com/license/
 * @version 1.2
 */

class XAlphaPagination extends CComponent
{
	/**
	 * @var string name of the GET variable storing the current page index. Defaults to 'page'.
	 */
	public $pageVar='alpha';
	/**
	 * @var string name of the GET variable which indicates that a controlled pagination should
	 * be reseted to the default page. Defaults to 'p_rst'.
	 */
	public $pageResetVar='p_rst';
	/**
	 * @var string the route (controller ID and action ID) for displaying the paged contents.
	 * Defaults to empty string, meaning using the current route.
	 */
	public $route='';
	/**
	 * @var array the additional GET parameters (name=>value) that should be used when generating pagination URLs.
	 * Defaults to null, meaning using the currently available GET parameters.
	 */
	public $params;
	/**
	 * @var string the model attribute that the condition should be applied to.
	 */
	public $attribute;
	/**
	 * @var bool whether there are entries starting with digits or not.
	 * Hides the 'SHOW NUMERIC'-button of linkpager if false and {@link showNumPage} is true. Defaults to true.
	 */
	public $activeNumbers=true;
	/**
	 * @var bool tries to force case-insensitive comparison independent from character set case or database collation.
	 */
	public $forceCaseInsensitive=false;

	private $_charSet;
	private $_activeCharSet;
	private $_dbCharSet;

	private $_pagination;
	private $_currentPage;

	/**
	 * Constructor.
	 * @param string model attribute to which the search condition is applied.
	 * @param CPagination Pagination controlled per letter.
	 */
	public function __construct($attribute='',$pagination=null)
	{
		$this->attribute = $attribute;
		if($pagination!=null)
			$this->_pagination = $pagination;
	}

	/**
	 * @return integer the zero-based index of the current page. Defaults to 0.
	 */
	public function getCurrentPage()
	{
		if($this->_currentPage===null)
		{
			if(isset($_GET[$this->pageVar]))
			{
				$this->_currentPage=(int)$_GET[$this->pageVar];
				if($this->_currentPage<-1 || $this->_currentPage>count($this->getCharSet()))
					$this->_currentPage=-1;
			}
			else
				$this->_currentPage=-1;
		}
		return $this->_currentPage;
	}

	/**
	 * @param integer the zero-based index of the current page.
	 */
	public function setCurrentPage($value)
	{
		$this->_currentPage=$value;
		$_GET[$this->pageVar]=$value;
	}

	/**
	 * Creates the URL suitable for pagination.
	 * This method is mainly called by pagers when creating URLs used to
	 * perform pagination. The default implementation is to call
	 * the controller's createUrl method with the page information.
	 * You may override this method if your URL scheme is not the same as
	 * the one supported by the controller's createUrl method.
	 * @param CController the controller that will create the actual URL
	 * @param integer the page that the URL should point to. This is a zero-based index.
	 * @return string the created URL
	 */
	public function createPageUrl($controller,$page)
	{
		$params=$this->params===null ? $_GET : $this->params;
		if($page>=0) // page 0 is the default
			$params[$this->pageVar]=$page;
		else
			unset($params[$this->pageVar]);

		if($this->_pagination!=null)
			$params[$this->pageResetVar] = 1;

		return $controller->createUrl($this->route,$params);
	}

	/**
	 * Applies CONDITION to the specified query criteria.
	 * @param CDbCriteria the query criteria that should be applied with the limit
	 */
	public function applyCondition($criteria)
	{
		if($this->attribute!='')
		{
			$this->resetPaginationVar();
			$currentPage = $this->getCurrentPage();
			$search = $this->getDbChar($currentPage-1);

			if($currentPage>0 && $search!=null)
			{
				if($this->forceCaseInsensitive===true)
					$criteria->addSearchCondition('LOWER('.$this->attribute.')',mb_strtolower($search).'%');
				else
					$criteria->addSearchCondition($this->attribute,$search.'%',false);
			}
			elseif($currentPage == 0) { // Add condition for values starting with a digit
				// Add one condition per digit.
				// This isn't pretty nice but the most compatible way i've found for different DBMS.
				// Smarter ways like:
				// $criteria->addCondition("SUBSTRING($this->attribute FROM 1 FOR 1) BETWEEN '0' AND '9'");
				// are standard compliant but afaik wouldn't work using MSSQL or Oracle.
				$cond = array();
				foreach(range(0,9) as $n)
					$cond[] = "$this->attribute LIKE '$n%'";
				$criteria->addCondition('('.implode(' OR ',$cond).')');
			}
		}
		else
			throw new CException(Yii::t('AlphaPagination','There is no value set for $attribute. You must set the model attribute the pagination condition should be applied to.'));
	}

	/**
	 * @param integer ordinal number of the character. zero-based indexing.
	 * @return string character of the char range. NULL if out of range.
	 */
	public function getChar($ord)
	{
		$chars = $this->getCharSet();
		return ($ord>=0&&$ord<count($chars))?$chars[$ord]:null;
	}

	/**
	 * @param integer ordinal number of the character whose db character equivalent should be returned. zero-based indexing.
	 * @return string character of the database char range. NULL if out of range.
	 */
	public function getDbChar($ord)
	{
		$chars = $this->getDbCharSet();
		return ($ord>=0&&$ord<count($chars))?$chars[$ord]:null;
	}

	/**
	 * Unsets the $pageVar of a controlled CPagination to make it fall back to default page.
	 */
	private function resetPaginationVar()
	{
		if($this->_pagination!=null && isset($_GET[$this->pageResetVar]))
			unset($_GET[$this->pageResetVar],$_GET[$this->pagination->pageVar]);
	}

	/**
	 * @return Pager character set array. Default is A-Z.
	 */
	public function getCharSet()
	{
		if($this->_charSet===null)
			$this->_charSet = range('A','Z');
		return $this->_charSet;
	}

	/**
	 * @return Active character set array. If no active charset is defined the pager charset is returned.
	 */
	public function getActiveCharSet()
	{
		return ($this->_activeCharSet===null)?$this->_charSet:$this->_activeCharSet;
	}

	/**
	 * @return Database character set array. If no database charset is defined the pager charset is returned.
	 */
	public function getDbCharSet()
	{
		return ($this->_dbCharSet===null)?$this->_charSet:$this->_dbCharSet;
	}

	/**
	 * @param value Pager character set array
	 */
	public function setCharSet($value)
	{
		$this->_charSet=$value;
	}

	/**
	 * @param value Active character set array
	 */
	public function setActiveCharSet($value)
	{
		$this->_activeCharSet=$value;
	}

	/**
	 * @param value Database character set array
	 */
	public function setDbCharSet($value)
	{
		$this->_dbCharSet=$value;
	}

	/**
	 * @param value CPagination the controlled CPagination object
	 */
	public function setPagination($value)
	{
		$this->_pagination = $value;
	}

	/**
	 * @return CPagination the controlled CPagination object
	 */
	public function getPagination()
	{
		if($this->_pagination===null)
			$this->_pagination=new CPagination();
		return $this->_pagination;

	}
}
?>