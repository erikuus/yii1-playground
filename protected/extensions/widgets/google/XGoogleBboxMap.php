<?php

/**
 * XGoogleBboxMap class file
 *
 * Widget to display Google Map with bounding box.
 * Based on Google Maps JavaScript API v3
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
 * @author Urmas Tamm (from Google Maps JavaScript API v2 to v3)
 * @version 2.0.0
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
		if(!$this->googleApiKey)
			throw new CException('"googleApiKey" have to be set!');

		if(!$this->model)
			throw new CException('"model" have to be set!');
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
			return "{$id}_map.setCenter(new google.maps.LatLng({$ceLat},{$ceLon}), {$zoom});";
		}
		elseif($this->checkBounds()===true)
		{
			$sw_lat=$this->model->{$this->sw_lat};
			$sw_lon=$this->model->{$this->sw_lon};
			$ne_lat=$this->model->{$this->ne_lat};
			$ne_lon=$this->model->{$this->ne_lon};

			return "
				var {$id}_southWest=new google.maps.LatLng({$sw_lat},{$sw_lon})
				var {$id}_northEast=new google.maps.LatLng({$ne_lat},{$ne_lon})
				var {$id}_bounds=new google.maps.LatLngBounds({$id}_southWest,{$id}_northEast);
				{$id}_map.setCenter({$id}_bounds.getCenter(), {$id}_map.fitBounds({$id}_bounds));
			";
		}
		else
			return "{$id}_map.setCenter(new google.maps.LatLng({$this->defaultCeLat},{$this->defaultCeLon}), {$this->defaultZoom});";
	}

	/**
	 * @return string part of client script that set polyline for map
	 */
	protected function getPolygon()
	{
		$id=$this->getId();

		if($this->checkBounds())
		{
			$p1='new google.maps.LatLng('.$this->model->{$this->sw_lat}.','.$this->model->{$this->sw_lon}.')';
			$p2='new google.maps.LatLng('.$this->model->{$this->ne_lat}.','.$this->model->{$this->sw_lon}.')';
			$p3='new google.maps.LatLng('.$this->model->{$this->ne_lat}.','.$this->model->{$this->ne_lon}.')';
			$p4='new google.maps.LatLng('.$this->model->{$this->sw_lat}.','.$this->model->{$this->ne_lon}.')';

			return "
				var polygon = new google.maps.Polygon({
					paths: [$p1,$p2,$p3,$p4,$p1],
					strokeColor: 'red',
					strokeWeight: 2,
					strokeOpacity: 0.5,
					fillColor: 'yellow',
					fillOpacity: 0.3
				});
				polygon.setMap({$id}_map);
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
		$initZoom=$this->model->{$this->zoom} ? $this->model->{$this->zoom} : $this->defaultZoom;

		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile('https://maps.googleapis.com/maps/api/js?sensor=false&key='.$this->googleApiKey,CClientScript::POS_HEAD);
		$cs->registerScript(__CLASS__.'#'.$id,"
			function {$id}_initialize() {
				var mapOptions = {
					zoom: {$initZoom},
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					panControl: true,
					streetViewControl: false
				};

				// if map is inside hidden div you need to set size in constructor
				var {$id}_map = new google.maps.Map(document.getElementById('{$id}_map_canvas'),mapOptions);

				//set center and zoom level
				{$this->getCenterAndZoom()}

				// get polygon
				{$this->getPolygon()}
			}
			google.maps.event.addDomListener(window, 'load', {$id}_initialize);
		",CClientScript::POS_HEAD);
	}
}