<?php
/**
 * XGoogleChart class file
 *
 * Widget to display a Google Chart image
 *
 * Pie chart example
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleChart',array(
 *     'type'=>'pie',
 *     'title'=>'Browser market 2008',
 *     'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
 *     'size'=>array(400,300), // width and height of the chart image
 *     'color'=>array('6f8a09', '3285ce','dddddd'), // if there are fewer color than slices, then colors are interpolated.
 * ));
 * </pre>
 *
 * Vertical Bar Chart
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleChart',array(
 *     'type'=>'bar-vertical',
 *     'title'=>'Browser market January  2008',
 *     'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
 *     'size'=>array(400,260),
 *     'barsSize'=>array('a'), // automatically resize bars to fit the space available
 *     'color'=>array('3285ce'),
 *     'axes'=>array('x','y'), // axes to show
 * ));
 * </pre>
 *
 * Horizontal Bar Chart
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleChart',array(
 *     'type'=>'bar-horizontal',
 *     'title'=>'Browser market February  2008',
 *     'data'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
 *     'size'=>array(400,200),
 *     'barsSize'=>array('a'),
 *     'color'=>array('3285ce'),
 *     'axes'=>array(
 *         'x'=>array(0,20,40,60,80,100),
 *         'y'=>array('Opera','Safari','Mozilla','Firefox','IE5','IE6','IE7'),
 *     ),
 * ));
 * </pre>
 *
 * Vertical Grouped Bar Chart
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleChart',array(
 *     'type'=>'bar-vertical',
 *     'title'=>'Browser market 2008',
 *     'data'=>array(
 *         'February 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
 *         'January 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
 *     ),
 *     'size'=>array(550,300),
 *     'color'=>array('c93404','3285ce'),
 *     'axes'=>array('x','y'),
 * ));
 * </pre>
 *
 * Vertical Stacked Bar Chart
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleChart',array(
 *     'type'=>'stacked-bar-vertical',
 *     'title'=>'Browser market 2008',
 *     'data'=>array(
 *         'February 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
 *         'January 2008'=>array('IE7'=>22,'IE6'=>30.7,'IE5'=>1.7,'Firefox'=>36.5,'Mozilla'=>1.1,'Safari'=>2,'Opera'=>1.4),
 *     ),
 *     'size'=>array(500,200),
 *     'barsSize'=>array(40,10), // bar width and space between bars
 *     'color'=>array('6f8a09', '3285ce'),
 *     'axes'=>array('x','y'),
 * ));
 * </pre>
 *
 * Line Chart
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleChart',array(
 *     'type'=>'line',
 *     'title'=>'Browser market 2008',
 *     'data'=> array(
 *         '2007'=>array('Jan'=>61.0,'Feb'=>51.2,'Mar'=>61.8,'Apr'=>42.9,'May'=>33.7,'June'=>34.0,'July'=>34.5,'August'=>34.9,'Sept'=>45.4,'Oct'=>46.0,'Nov'=>46.3,'Dec'=>46.3),
 *         '2006'=>array('Jan'=>35.0,'Feb'=>34.5,'Mar'=>44.5,'Apr'=>32.9,'May'=>22.9,'June'=>25.5,'July'=>25.5,'August'=>24.9,'Sept'=>37.3,'Oct'=>37.3,'Nov'=>39.9,'Dec'=>39.9),
 *         '2005'=>array('Jan'=>15.0,'Feb'=>14.5,'Mar'=>24.5,'Apr'=>22.9,'May'=>12.9,'June'=>15.5,'July'=>15.5,'August'=>14.9,'Sept'=>17.3,'Oct'=>27.3,'Nov'=>29.9,'Dec'=>29.9)
 *    ),
 *    'size'=>array(550,200),
 *    'color'=>array('c93404','6f8a09','3285ce'),
 *    'fill'=>array('f8d4c8','d4e1a5'),
 *    'gridSize'=>array(9,20), // x-axis and y-axis step of the grid
 *    'gridStyle'=>'light', // optional: light or solid
 *    'axes'=>array('x','y'),
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XGoogleChart extends CWidget
{
	/**
	 * The base url of the Google Chart API driver
	 * @var string
	 */
	const API_BASE_URL='http://chart.apis.google.com/chart?';
	/**
	 * The url query of the Google Chart API driver
	 * @var string
	 */
	private $query;
	/**
	 * The type of the chart
	 * require
	 * @var string
	 */
	public $type;
	/**
	 * The title of the chart
	 * require
	 * @var string
	 */
	public $title;
	/**
	 * The data of the chart
	 * require
	 * @var array
	 */
	public $data=array();
	/**
	 * The width and height of the chart image (defaults 400x400)
	 * option
	 * @var array
	 */
	public $size=array();
	/**
	 * Colors of the chart (if there are fewer color than slices, then colors are interpolated.)
	 * option
	 * @var array
	 */
	public $color=array();
	/**
	 * Fill colors of the line chart
	 * option
	 * @var array
	 */
	public $fill=array();
	/**
	 * Axes of the chart to display (defaults null)
	 * Supports labels array: 'x'=>array(0,20,40,60,80,100)
	 * options: x|y|r|t
	 * @var array
	 */
	public $axes=array();
	/**
	 * bar width and space between bars (if 'a' then automatically resize bars to fit the space available)
	 * option
	 * @var array
	 */
	public $barsSize=array();
	/**
	 * X and Y step of the grid
	 * option
	 * @var array
	 */
	public $gridSize=array();
	/**
	 * The style of the grid
	 * options: light|solid
	 * @var string
	 */
	public $gridStyle;
	/**
	 * The background color of the chart (defaults white)
	 * option
	 * @var string
	 */
	public $background='a,s,ffffff';
	/**
	 * The use of the legend
	 * option
	 * @var boolean
	 */
	public $useLegend=true;

	/**
	 * Prepares widget to be used by setting necessary
	 */
	public function init()
	{
		$data=$this->getData();
		$type=$this->getType();
		$legend=$this->getLegend();
		$width=$this->getWidth();
		$height=$this->getHeight();
		$grid=$this->getGrid();
		$fill=$this->getFill();
		$axes=$this->getAxes();

		$values=isset($data['values']) ? $data['values'] : null;
		$labels=!isset($axes['labels']) ? $data['labels'] : null;
		$axesNames=isset($axes['names']) ? $axes['names'] : null;
		$axesLabels=isset($axes['labels']) ? $axes['labels'] : null;

		$color=(!empty($this->color)) ? implode(',',$this->color) : null;
		$barsSize=(!empty($this->barsSize)) ? implode(',',$this->barsSize) : null;

		$background='bg,s,'.$this->background;

		$this->query=array(
			'cht'=>$type,
			'chtt'=>$this->title,
			'chd'=>'t:'.$values,
			'chl'=>$labels,
			'chdl'=>$legend,
			'chs'=>$width.'x'.$height,
			'chco'=>$color,
			'chm'=>$fill,
			'chxt'=>$axesNames,
			'chxl'=>$axesLabels,
			'chf'=>$background,
			'chg'=>$grid,
			'chbh'=>$barsSize
		);
	}

	/**
	 * Create chart
	 */
	public function run()
	{
		echo $this->img(self::API_BASE_URL.http_build_query($this->query),$this->title);
	}

	/**
	 * Get chart type
	 */
	protected function getType()
	{
		$type=null;
		$options=array(
			'pie'=>'p',
			'line'=>'lc',
			'bar-horizontal'=>'bhg',
			'stacked-bar-horizontal'=>'bhs',
			'bar-vertical'=>'bvg',
			'stacked-bar-vertical'=>'bvs',
		);

		if(isset($options[$this->type]))
			$type=$options[$this->type];

		return $type;
	}

	/**
	 * Get chart image width
	 */
	protected function getWidth()
	{
		$width=400;

		if(isset($this->size[0]))
			$width=$this->size[0];

		return $width;
	}

	/**
	 * Get chart image height
	 */
	protected function getHeight()
	{
		$height=400;

		if(isset($this->size[1]))
			$height=$this->size[1];

		return $height;
	}

	/**
	 * Get chart legends
	 */
	protected function getLegend()
	{
		$legend=null;

		if($this->useLegend && is_array(reset($this->data)))
			$legend=implode('|',array_keys($this->data));

		return $legend;
	}

	/**
	 * Get data
	 */
	protected function getData()
	{
		$data=array();

		if(is_array(reset($this->data)))
		{
			foreach($this->data as $key=>$value)
			{
				$data['values'][]=implode(',',$value);
				$data['labels']=implode('|',array_keys($value));
			}
			$data['values']=implode('|',$data['values']);

		}
		else
		{
			$data['values']=implode(',',$this->data);
			$data['labels']=implode('|',array_keys($this->data));
		}

		return $data;
	}


	/**
	 * Get fill
	 */
	protected function getFill()
	{
		$fill=null;

		// Fill must have atleast 4 parameters
		if(count($this->fill)<4)
		{
			// Add remaining params
			$temp=array();
			$count=count($this->fill);
			for($i=0;$i<$count;++$i)
				$temp[$i]='b,'.$this->fill[$i].','.$i.','.($i+1).',0';

			$fill = implode('|',$temp);
		}

		return $fill;
	}

	/**
	 * Get grid
	 */
	protected function getGrid()
	{
		$grid=null;

		$styleOptions=array(
			'light'=>',1,5',
			'solid'=>',1,0',
		);

		if(!empty($this->gridSize))
			$grid=implode(',',$this->gridSize);

		if($grid && isset($styleOptions[$this->gridStyle]))
			$grid.=$styleOptions[$this->gridStyle];

		return $grid;
	}

	/**
	 * Get chart legends
	 */
	protected function getAxes()
	{
		$axes=array();

		$index=array('x'=>0,'y'=>'1','r'=>'2','t'=>'3');

		if(is_array(reset($this->axes)))
		{
			$axes['names']=implode(',',array_keys($this->axes));

			$temp=array();
			foreach($this->axes as $key=>$value)
				$temp['values'][]=$index[$key].':|'.implode('|',$value);

			$axes['labels']=implode('|',$temp['values']);
		}
		else
		{
			$axes['names']=implode(',',$this->axes);
			$axes['labels']=null;
		}

		return $axes;
	}

	/**
	 * Create img html tag
	 */
	protected function img($url,$alt=null)
	{
		return sprintf('<img src="%s" alt="%s" />',$url,$alt);
	}
}