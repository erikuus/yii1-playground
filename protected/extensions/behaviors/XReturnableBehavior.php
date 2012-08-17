<?php
/**
 * XReturnable behavior
 *
 * This behavior can create URLs that allow to return to a page
 * by storing its GET Parameters. It can be  be attached to a
 * controller on its {@link Controller::init()} method.
 *
 * To store the return parameters a stack is used. This return stack
 * gets encoded and compressed and gets appended to the URL as
 * additional parameter '_xr'.
 *
 * {@link createReturnableUrl()} can be used like {@link CController::createUrl()}
 * to create a URL that contains the encoded return stack including
 * the current page parameters.
 *
 * {@link createReturnStackUrl()} can be used to create a URL that contains
 * the unmodified return stack without the parameters of the current page
 * being added.
 *
 * Two methods are provided to return to the last page on the stack:
 * {@link getReturnUrl()} provides the URL to the last page whereas
 * {@link goBack()} redirects to the last page on the stack.
 *
 * Note 1: This behavoir requires that the view state of any page
 * you want to return to only depends on its $_GET parameters.
 *
 * Note 2: The return stack is propagated via URL. As the URL length
 * is limited in some browsers (e.g. about 2KB for IE) this may
 * lead to problems if your pages have lots of parameters or the parameters
 * are very big. So even since XReturnable uses gzcompress() to minimize
 * URL length as much as possible you should make sure that your parameter
 * size can never exceed this limit.
 *
 * @copyright 2009 by Michael Härtl
 * @author Michael Härtl <haertl.mike@googlemail.com>
 * @license See http://www.yiiframework/extension/xreturnable
 * @version 1.0.2
 */

/**
 * IMPORTANT WHEN UPGRADING!!!
 * New Method {@link  getReturnUrlRoute()}
 * Updated Method {@link  getReturnUrl()}
 *  by adding param prefix
 *  so that you can now call $this->getReturnUrl('/')
 *  to get return url from module to app
 * Updated Method {@link  createReturnableUrl()}
 *  by adding param $stackParams so that you can define return target
 *  $this->createReturnableUrl('specify',array('id'=>$data->id),array('#'=>'order'.$data->id)),
 * Updated Methods {@link  urlUncompress()} and {@link  loadStackFromUrl()}
 *  to Fix PHP Warning gzuncompress()
 *
 * @author Erik Uus <erik.uus@gmail.com>
 */
class XReturnableBehavior extends CBehavior
{
	/**
	 * @var string name of GET parameter that should hold the stack. Defaults to '_xr'.
	 */
	public $paramName='_xr';

	/**
	 * @var array the current stack of returnable page's GET parameters.
	 */
	protected $_returnStack;

	/**
	 * @var array the current page parameters with route as first entry
	 */
	protected $_currentPageParams;

	/**
	 * @var string the URL to go back
	 */
	protected $_returnUrl;

	/**
	 * Creates a returnable URL with the encoded return stack appended
	 * to the URL as GET parameter '_xr'. The current page's return
	 * parameters where added to that stack.
	 *
	 * @param mixed $route the route as used by {@link CController::createUrl}
	 * @param array $params additional GET parameters as used by {@link CController::createUrl}
	 * @param string $stackParams additional GET parameters for returnable url (added by Erik Uus)
	 * @param string $amp the separator as used by {@link CController::createUrl}
	 * @return string the constructed URL with appended return parameters
	 */
	public function createReturnableUrl($route, $params=array(),$stackParams=array(),$amp='&')
	{
		$stack=$this->getReturnStack();
		$stack[]=$this->getCurrentPageParams() + $stackParams;

		$params[$this->paramName]=self::urlCompress($stack);
		Yii::trace('Compressed length: '.strlen($params[$this->paramName]),'XReturnableBehavior');
		return $this->getOwner()->createUrl($route,$params,$amp);
	}

	/**
	 * Creates a URL with the encoded return stack appended
	 * to the URL as GET parameter '_xr'. The stack doesn't contain
	 * the parameters for the current page.
	 *
	 * @param mixed $route the route as used by {@link CController::createUrl}
	 * @param array $params additional GET parametes as used by {@link CController::createUrl}
	 * @param string $amp the separator as used by {@link CController::createUrl}
	 * @return string the constructed URL with appended return parameters
	 */
	public function createReturnStackUrl($route, $params=array(),$amp='&')
	{
		$stack=$this->getReturnStack();

		$params[$this->paramName]=self::urlCompress($stack);
		return $this->getOwner()->createUrl($route,$params,$amp);
	}

	/**
	 * @param string param prefix (added by Erik Uus)
	 * @return string the URL to the last page on the return stack or null if none present.
	 */
	public function getReturnUrl($prefix='')
	{
		if ($this->_returnUrl===null) {
			if (!($stack=$this->getReturnStack()))
				return null;

			$params=array_pop($stack);
			$route=array_shift($params);
			if (count($stack))
				$params[$this->paramName]=self::urlCompress($stack);
			$this->_returnUrl=$this->Owner->createUrl($prefix.$route,$params);
		}
		return $this->_returnUrl;
	}

	/**
	 * @return string the route part of URL to the last page on the return stack.
	 */
	public function getReturnUrlRoute()
	{
		if (!($stack=$this->getReturnStack()))
				return null;

		$params=array_pop($stack);
		$route=array_shift($params);

		return $route;
	}

	/**
	 * Redirect to the last page on the stack.
	 * @return bool Wether a return URL was found.
	 */
	public function goBack() {
		if (($url=$this->getReturnUrl())===null)
			return false;
		$this->Owner->redirect($url);
		return true;
	}

	/**
	 * Compress the given data for use in a URL
	 *
	 * @param mixed the data to compress
	 * @static
	 * @return string the compressed data
	 */
	public static function urlCompress($data) {
		return urlencode(base64_encode(gzcompress(serialize($data),9)));
	}

	/**
	 * Uncompresses the given data
	 *
	 *
	 * @param string the compressed data
	 * @static
	 * @return mixed the uncompressed data
	 */
	public static function urlUncompress($data) {
		$uncompressed=@gzuncompress(base64_decode(urldecode($data))); // Fix PHP Warning gzuncompress() by Erik Uus
		return $uncompressed===false ? null : unserialize($uncompressed);
	}

	/**
	 * Create a URL safe representation of multi dim assoc arrays.
	 *
	 * For example will convert this array
	 *
	 *   array(
	 *      'a' => array(
	 *          'b' => array(
	 *              'c1' => 1,
	 *              'c2' => 2
	 *          ),
	 *      ),
	 *
	 * into
	 *
	 *   array(
	 *      'a[b][c1]' => 1,
	 *      'a[b][c2]' => 2,
	 *   )
	 *
	 * @param mixed $tree
	 * @param string $keyPrefix
	 * @static
	 * @access private
	 * @return void
	 */
	public static function flattenAssocArray($a,$p=null)
	{
		$r=array();
		foreach ($a as $k => $v) {
			$nk= $p===null ? $k : $p.'['.$k.']';
			if (is_array($v))
				$r += self::flattenAssocArray($v,$nk);
			else
				$r[$nk]=$v;
		}
		return $r;
	}

	/**
	 * @return array the current page parameters with route as first entry
	 */
	protected function getCurrentPageParams()
	{
		if ($this->_currentPageParams===null) {
			$this->_currentPageParams=self::flattenAssocArray($_GET);
			//$this->_currentPageParams=$_GET;
			$r=Yii::app()->urlManager->routeVar;
			$c=$this->getOwner();
			$route=isset($_GET[$r]) ? $_GET[$r] : $c->getId().'/'.$c->getAction()->getId();
			unset($this->_currentPageParams[$r]);
			array_unshift($this->_currentPageParams,$route);
		}
		return $this->_currentPageParams;
	}

	/**
	 * @return array the current return stack
	 */
	protected function getReturnStack()
	{
		if ($this->_returnStack===null)
			$this->loadStackFromUrl();
		return $this->_returnStack;
	}

	/**
	 * Extract return stack parameters from URL.
	 */
	protected function loadStackFromUrl()
	{
		$this->_returnStack=
			isset($_GET[$this->paramName]) &&
			self::urlUncompress($_GET[$this->paramName]) // Fix PHP Warning gzuncompress() by Erik Uus
				? self::urlUncompress($_GET[$this->paramName]) : array();
	}
}