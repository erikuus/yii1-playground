<?php
/**
 * XGoogleBboxMap class file
 *
 * Widget to display Google Map with bounding box.
 *
 * The minimal code needed to use XGoogleBboxMap is as follows:
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleBboxMap', array(
 *     'googleApiKey'=>Yii::app()->params['googleApiKey'],
 *     'model'=>$model,
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XGoogleBboxMap extends CWidget
{
	/**
	 * @var string the google map api key (default www.ra.ee)
	 */
	public $googleApiKey;
	/**
	 * @var integer the zoom level for map
	 */
	public $defaultZoom=6;
	/**
	 * @var integer the center longitude for map
	 */
	public $defaultCeLon=25.048828;
	/**
	 * @var integer the center latitude for map
	 */
	public $defaultCeLat=58.568252;
	/**
	 * @var string the width for map canvas div
	 */
	public $width='470px';
	/**
	 * @var string the height for map canvas div
	 */
	public $height='300px';
	/**
	 * @var CModel the data model associated with this widget.
	 */
	public $model;
	/**
	 * @var string the model attribute name for the map central latitude
	 */
	public $ce_lat='ce_lat';
	/**
	 * @var string The model attribute name for the map central longitude
	 */
	public $ce_lon='ce_lon';
	/**
	 * @var string the model attribute name for the map zoom level
	 */
	public $zoom='zoom';
	/**
	 * @var string the model attribute name for the select rectangle SW latitude
	 */
	public $sw_lat='sw_lat';
	/**
	 * @var string The model attribute name for the select rectangle SW longitude
	 */
	public $sw_lon='sw_lon';
	/**
	 * @var string The model attribute name for the select rectangle NE latitude
	 */
	public $ne_lat='ne_lat';
	/**
	 * @var string The model attribute name for the select rectangle NE longitude
	 */
	public $ne_lon='ne_lon';

	/**
	 * Initializes the widget.
	 * This method will initialize required property values
	 */
	public function init()
	{
		if(!isset($this->googleApiKey))
			throw new CException('"googleApiKey" have to be set!');

		if(!isset($this->model))
			throw new CException('"model" have to be set!');

		if(!$this->checkBounds() && !$this->model->{$this->zoom})
			$this->model->{$this->zoom}=$this->defaultZoom;

		if(!$this->checkBounds() && !$this->model->{$this->ce_lat})
			$this->model->{$this->ce_lat}=$this->defaultCeLat;

		if(!$this->checkBounds() && !$this->model->{$this->ce_lon})
			$this->model->{$this->ce_lon}=$this->defaultCeLon;
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$id=$this->getId();
		$this->registerClientScript();
		echo "<div id=\"{$id}_map_canvas\" style=\"width:".$this->width."; height:".$this->height."; overflow:hidden\"></div>\n";
	}

	/**
	 * @return boolean wether map center and zoom params are set
	 */
	protected function checkCenterAndZoom()
	{
		if(
			$this->model->{$this->ce_lat} &&
			$this->model->{$this->ce_lon} &&
			$this->model->{$this->zoom}
		)
			return true;
		else
			return false;
	}

	/**
	 * @return boolean wether bounds params are set
	 */
	protected function checkBounds()
	{
		if(
			$this->model->{$this->sw_lat} &&
			$this->model->{$this->sw_lon} &&
			$this->model->{$this->ne_lat} &&
			$this->model->{$this->ne_lon}
		)
			return true;
		else
			return false;
	}

	/**
	 * @return string part of client script that set center and zoom level for map
	 */
	protected function getCenterAndZoom()
	{
		$id=$this->getId();
		if($this->checkCenterAndZoom()===true)
		{
			$ceLat=$this->model->{$this->ce_lat};
			$ceLon=$this->model->{$this->ce_lon};
			$zoom=$this->model->{$this->zoom};
			return "{$id}_map.setCenter(new GLatLng({$ceLat},{$ceLon}), {$zoom});";
		}
		elseif($this->checkBounds()===true)
		{
			$sw_lat=$this->model->{$this->sw_lat};
			$sw_lon=$this->model->{$this->sw_lon};
			$ne_lat=$this->model->{$this->ne_lat};
			$ne_lon=$this->model->{$this->ne_lon};

			return "
			var {$id}_southWest=new GLatLng({$sw_lat},{$sw_lon})
			var {$id}_northEast=new GLatLng({$ne_lat},{$ne_lon})
			var {$id}_bounds=new GLatLngBounds({$id}_southWest,{$id}_northEast);
			{$id}_map.setCenter({$id}_bounds.getCenter(), {$id}_map.getBoundsZoomLevel({$id}_bounds));
			";
		}
		else
			return "{$id}_map.setCenter(new GLatLng({$this->defaultCeLat},{$this->defaultCeLon}), {$this->defaultZoom});";
	}

	/**
	 * @return string part of client script that set polyline for map
	 */
	protected function getPolygon()
	{
		$id=$this->getId();

		if($this->checkBounds())
		{
			$p1 = 'new GLatLng('.$this->model->{$this->sw_lat}.','.$this->model->{$this->sw_lon}.')';
			$p2 = 'new GLatLng('.$this->model->{$this->ne_lat}.','.$this->model->{$this->sw_lon}.')';
			$p3 = 'new GLatLng('.$this->model->{$this->ne_lat}.','.$this->model->{$this->ne_lon}.')';
			$p4 = 'new GLatLng('.$this->model->{$this->sw_lat}.','.$this->model->{$this->ne_lon}.')';

			return "
			var polygon = new GPolygon([$p1,$p2,$p3,$p4,$p1], 'red',2,0.5,'yellow',0.3);
			{$id}_map.addOverlay(polygon);
			";
		}
		else
			return null;
	}

	/**
	 * Registers necessary client scripts.
	 */
	protected function registerClientScript()
	{
		$id=$this->getId();

		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile('http://maps.google.com/maps?file=api&v=2&sensor=false&key='.$this->googleApiKey, CClientScript::POS_HEAD);
		$cs->registerScript(__CLASS__.'#'.$id, "
			GEvent.addDomListener(window,'load',function(){
				if (GBrowserIsCompatible()) {
					// if map is inside hidden div you need to set size in constructor
					var {$id}_map = new GMap2(document.getElementById('{$id}_map_canvas'));

					// set center and zoom level
					{$this->getCenterAndZoom()}

					{$id}_map.addControl(new GLargeMapControl());
					{$id}_map.addControl(new GHierarchicalMapTypeControl());
					{$id}_map.addMapType(G_PHYSICAL_MAP);
					{$id}_map.enableScrollWheelZoom();

					// get polygon
					{$this->getPolygon()}
				}
			});
			GEvent.addDomListener(window,'unload',function(){
				GUnload();
			});
		", CClientScript::POS_HEAD);
	}
}