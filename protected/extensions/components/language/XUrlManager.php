<?php
/**
 * XUrlManager handles language parameter in url.
 *
 * XUrlManager can be used together with XLangMenu.
 *
 * The following example shows how to set up XUrlManager
 * in your application configuration (config/main.php):
 * <pre>
 * 'urlManager'=>array(
 *     'class' => 'ext.components.language.XUrlManager',
 *     'urlFormat'=>'path',
 *     'showScriptName'=>true,
 *     'appendParams'=>false,
 *     'supportedLanguages'=>array('et','de'),
 *     'rules'=>array(
 *         '<language:\w{2}>' => 'site/index',
 *         '<language:\w{2}>/<_c:\w+>' => '<_c>',
 *         '<language:\w{2}>/<_c:\w+>/<_a:\w+>'=>'<_c>/<_a>',
 *         '<language:\w{2}>/<_m:\w+>' => '<_m>',
 *         '<language:\w{2}>/<_m:\w+>/<_c:\w+>' => '<_m>/<_c>',
 *         '<language:\w{2}>/<_m:\w+>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
 *     ),
 * ),
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.1.0
 */
class XUrlManager extends CUrlManager
{
	/**
	 * @var array allowedLanguages the language codes that are suppported by application,
	 * deafults to array('et','en')
	 */
	public $supportedLanguages=array('et','en');

	public function parseUrl($pathInfo)
	{
		$result=parent::parseUrl($pathInfo);

		$urlLanguage = Yii::app()->getRequest()->getParam('language');
		if ($urlLanguage && in_array($urlLanguage, $this->supportedLanguages))
			Yii::app()->setLanguage($urlLanguage);

		return $result;
	}

	public function createUrl($route,$params=array(),$ampersand='&')
	{
		if(!isset($params['language']))
			$params['language']=Yii::app()->language;
		return parent::createUrl($route,$params,$ampersand);
	}
}