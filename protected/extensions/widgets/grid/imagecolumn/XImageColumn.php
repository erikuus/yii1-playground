<?php
/**
 * XImageColumn
 *
 * Allows to display image in CGridView column.
 *
 * Allows to display image in CGridView column.
 * @author Alexander Makarov
 * @version 1.1
 *
 * Added url expression
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.2
 */
Yii::import('zii.widgets.grid.CGridColumn');

class XImageColumn extends CGridColumn
{
	/**
	 * @var array the HTML options for the data cell tags.
	 */
	public $htmlOptions=array('class'=>'image-column');
	/**
	 * @var array the HTML options for the header cell tag.
	 */
	public $headerHtmlOptions=array('class'=>'image-column');
	/**
	 * @var array the HTML options for the footer cell tag.
	 */
	public $footerHtmlOptions=array('class'=>'image-column');
	/**
	* @var array the HTML options for the image tag.
	*/
	public $imageOptions=array();
	/**
	 * @var string a PHP expression that is evaluated for every data cell and whose result
	 * is used as the path to image. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $imagePathExpression;
	/**
	 * @var string Text that is used if cell is empty.
	 */
	public $emptyText;
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * as the URL of the hyperlink of the data cells. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $urlExpression;
	/**
	 * @var array the HTML options for the hyperlinks
	 */
	public $linkHtmlOptions=array();

	/**
	 * Renders the data cell content.
	 * @param integer the row number (zero-based)
	 * @param mixed the data associated with the row
	 */
	protected function renderDataCellContent($row,$data)
	{
		$content = $this->emptyText;
		if($this->imagePathExpression!==null && $imagePath = $this->evaluateExpression($this->imagePathExpression,array('row'=>$row,'data'=>$data)))
		{
			$this->imageOptions['src'] = $imagePath;
			$content=CHtml::tag('img', $this->imageOptions);

			if($this->urlExpression!==null)
			{
				$url=$this->evaluateExpression($this->urlExpression,array('data'=>$data,'row'=>$row));
				$content=CHtml::link($content,$url,$this->linkHtmlOptions);
			}
		}
		echo $content;
	}
}