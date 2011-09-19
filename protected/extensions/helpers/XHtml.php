<?php
/**
 * XHtml class
 *
 * This class adds helper methods to CHtml class.
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XHtml extends CHtml
{
    /**
     * Makes the given filename relative to the /css directory
     * @param string $filename the css filename
     * @return string css relative url
     */
    public static function cssUrl($filename)
    {
        return Yii::app()->baseUrl.'/css/'.$filename;
    }
    /**
     * Makes the given URL relative to the /js directory
     * @param string $filename the js filename
     * @return string js relative url
     */
    public static function jsUrl($filename)
    {
        return Yii::app()->baseUrl.'/js/'.$filename;
    }
    /**
     * Makes the given URL relative to the /images directory
     * @param string $filename the image filename
     * @return string image relative url 
     */
    public static function imageUrl($filename)
    {
        return Yii::app()->baseUrl.'/images/'.$filename;
    }
    /**
     * Makes the image tag inside link tag
     * @param string $image the image filename
     * @param string $linkUrl the url of the link
     * @param array $linkHtmlOptions the link html options 
     * @return string image tag inside link tag
     */
    public static function imageLink($image, $linkUrl='#', $linkHtmlOptions=array())
    {
        return self::link(self::image(self::imageUrl($image),'',array('align'=>'top')), $linkUrl, $linkHtmlOptions);
    }
    /**
     * Makes image tag followed by text
     * @param string $image the image filename
     * @param string $label the url of the link
     * @param boolean $reverse whether text should appear before image
     * @param string align image to text
     * @return string image tag followed by text
     */
    public static function imageLabel($image, $text='', $reverse=false, $align='top')
    {
    	$image=self::image(self::imageUrl($image),'',array('align'=>$align));
        $label=trim($text);
    	return $reverse ? $label.' '.$image : $image.' '.$label;
    }
   /** 
    * Extremely simplified truncation method 
    * @param string $str the string to truncate
    * @param integer $len the length to truncate to
    * @param string $ellipsis the concatenation characters
    * @return string
    */
    public static function truncate($str,$length=50,$ellipsis='...')
    {     
        if (mb_strlen($str)<$length)
            return $str; 
        $tmp=mb_substr($str,0,($length-mb_strlen($ellipsis)));
        return $tmp.$ellipsis;
    } 
	/**
	 * Converts a type name into space-separated words.
	 * For example, 'UserRole' will be converted as 'User Role'.
	 * @param string the string to be converted
	 * @param boolean whether to capitalize the first letter in each word
	 * @return string the resulting words
	 */
	public static function labelize($name,$ucwords=true)
	{
		$result=trim(mb_strtolower(str_replace('_',' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $name))));
		return $ucwords ? ucwords($result) : $result;
	}
	/**
	 * Format time
	 * @param integer unix time
	 * @param string time format
	 * @return string formatted datetime
	 */
	public static function formatTime($time, $format='d.m.Y H:i')
	{
		return $time ? date($format, $time) : null;
	}
	/**
	 * Format date
	 * @param string date
	 * @param string time format
	 * @return string formatted datetime
	 */	
	public static function formatDate($date, $format='d.m.Y')
	{
		return $date ? date_format(date_create($date), $format) : null;
	}		
	/**
	 * Add option 
	 * @return array of 'add new' option for dropdown
	 */	
	public static function addOption($add='-add-')
	{									
		return array('-1'=>$add);
	}
	/**
	 * Boolean options
	 * @return array of boolean options for dropdown
	 */	
	public static function booleanOptions()
	{									
		return array('1'=>Yii::t('zii','Yes'),'0'=>Yii::t('zii','No'));
	}
	/**
	 * Label boolean
	 * @param boolean value
	 * @return string yes/no label for boolean
	 */	
	public static function booleanLabel($value)
	{									
		return $value ? Yii::t('zii','Yes') : Yii::t('zii','No');
	}	
	/**
	 * Highlight words
	 * @param string $text
	 * @param mixed $words
	 * @param boolean $fullWords
	 * @param string $startTag
	 * @param string $endTag
	 * @return string
	 */
	public static function highlight($text, $words, $fullWords=false, $startTag='<strong>', $endTag='</strong>')
	{
		if(!$words || (is_array($words) && !$words[0]))
			return $text;
		
		if(is_string($words))	
			$words=explode(',', $words);
		
		foreach ($words as $word)
		{		
			$word=str_replace('/','\\/',preg_quote($word));
			if($fullWords)
				$text=preg_replace("/\b($word)\b/iu", $startTag.'\1'.$endTag, $text);
			else 
				$text=preg_replace("/($word)/iu", $startTag.'\1'.$endTag, $text);
		}
		return $text;
	}		
	/**
	 * Explodes radioButtonList into array 
	 * enabling to render buttons separately ($radio[0], $radio[1]...)
	 * @param CActiveForm $form the form widgets
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data value-label pairs used to generate the radio button list.
	 * @return array of radio buttons
	 */	
	public static function explodeRadioButtonList($form,$model,$attribute,$data)
	{
		return explode('|',$form->radioButtonList($model,$attribute,$data,array('template'=>'{input}{label}','separator'=>'|')));
	}
	/**
	 * Explodes checkBoxList into array 
	 * enabling to render boxes separately ($box[0], $box[1]...)
	 * @param CActiveForm $form the form widgets
	 * @param CModel $model the data model
	 * @param string $attribute the attribute
	 * @param array $data value-label pairs used to generate the check box list.
	 * @return array of check boxes
	 */	
	public static function explodeCheckBoxList($form,$model,$attribute,$data)
	{
		return explode('|',$form->checkBoxList($model,$attribute,$data,array('template'=>'{input}{label}','separator'=>'|')));
	}	
}