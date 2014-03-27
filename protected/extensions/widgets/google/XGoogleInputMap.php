<?php

/**
 * XGoogleInputMap class file
 *
 * Widget to implement a Google Map as form input.
 * Based on Google Maps JavaScript API v3
 *
 * Map can be moved and zoomed. User can select area on map by drawing rectangle on it.
 * Invisible form fields store:
 * 1) map central latitude,
 * 2) map central longitude,
 * 3) map zoom level,
 * 4) select rectangle SW latitude,
 * 5) select rectangle SW longitude,
 * 6) select rectangle NE latitude,
 * 7) select rectangle NE longitude.
 *
 * The minimal code needed to use XGoogleInputMap is as follows:
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleInputMap', array(
 *     'googleApiKey'=>Yii::app()->params['googleApiKey'],
 *     'form'=>$form,
 *     'model'=>$model,
 * ));
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @author Urmas Tamm (from Google Maps JavaScript API v2 to v3)
 * @version 1.0.0
 */
class XGoogleInputMap extends CInputWidget
{
	/**
	 * @var string the google map api key
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
	public $width=470;
	/**
	 * @var string the height for map canvas div
	 */
	public $height=300;
	/**
	 * @var CActiveForm the form associated with this widget.
	 */
	public $form;
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
	 */
	public function init()
	{
		if(!$this->googleApiKey)
			throw new CException('"googleApiKey" have to be set!');

		if(!$this->form)
			throw new CException('"form" have to be set!');

		if(!$this->model)
			throw new CException('"model" have to be set!');

		if($this->checkBounds()===false && $this->checkCenterAndZoom()===false)
		{
			$this->model->{$this->zoom}=$this->defaultZoom;
			$this->model->{$this->ce_lat}=$this->defaultCeLat;
			$this->model->{$this->ce_lon}=$this->defaultCeLon;
		}
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$id=$this->getId();
		$this->registerClientScript();

		echo Yii::t('ui','Click on the map to place markers. Then drag the markers to define a polygon.');
		echo "<div id=\"{$id}_map_canvas\" style=\"width:".$this->width."px; height:".$this->height."px; margin:5px 0 5px 0; overflow:hidden\"></div>\n";
		echo CHtml::link(Yii::t('ui','Clear map'),'#',array(
			'onclick'=>$id.'_clearMap(); return false;'
		));

		echo $this->form->hiddenField($this->model, $this->ce_lat, array('id'=>$id.'_ce_lat'));
		echo $this->form->hiddenField($this->model, $this->ce_lon, array('id'=>$id.'_ce_lon'));
		echo $this->form->hiddenField($this->model, $this->zoom, array('id'=>$id.'_zoom'));
		echo $this->form->hiddenField($this->model, $this->sw_lat, array('id'=>$id.'_sw_lat'));
		echo $this->form->hiddenField($this->model, $this->sw_lon, array('id'=>$id.'_sw_lon'));
		echo $this->form->hiddenField($this->model, $this->ne_lat, array('id'=>$id.'_ne_lat'));
		echo $this->form->hiddenField($this->model, $this->ne_lon, array('id'=>$id.'_ne_lon'));
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
	 * @return string part of client script that set center and zoom level for map
	 */
	protected function getClientScriptPart()
	{
		$id=$this->getId();

		if($this->checkBounds()===true && $this->checkCenterAndZoom()===false)
		{
			return "
				var {$id}_southWest=new google.maps.LatLng($('#{$id}_sw_lat').val(),$('#{$id}_sw_lon').val())
				var {$id}_northEast=new google.maps.LatLng($('#{$id}_ne_lat').val(),$('#{$id}_ne_lon').val())
				var {$id}_bounds=new google.maps.LatLngBounds({$id}_southWest,{$id}_northEast);
				{$id}_map.setCenter({$id}_bounds.getCenter(), {$id}_map.fitBounds({$id}_bounds));
			";
		}
		else
		{
			$ceLat=$this->model->{$this->ce_lat};
			$ceLon=$this->model->{$this->ce_lon};
			$zoom=$this->model->{$this->zoom};
			return "{$id}_map.setCenter(new google.maps.LatLng({$ceLat},{$ceLon}), {$zoom});";
		}
	}

	/**
	 * Registers necessary client scripts.
	 */
	protected function registerClientScript()
	{
		$id=$this->getId();
		$assets=dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
		$baseUrl=Yii::app()->getAssetManager()->publish($assets);
		$initZoom=$this->model->{$this->zoom} ? $this->model->{$this->zoom} : $this->defaultZoom;

		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile($baseUrl.'/MPolyDragControl.js',CClientScript::POS_HEAD);
		$cs->registerScriptFile('https://maps.googleapis.com/maps/api/js?sensor=false&key='.$this->googleApiKey,CClientScript::POS_HEAD);
		$cs->registerScript(__CLASS__.'#'.$id,"
			function {$id}_initialize() {
				var mapOptions = {
					zoom: $initZoom,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					panControl: true,
					streetViewControl: false
				};

				// if map is inside hidden div you need to set size in constructor
				var {$id}_map = new google.maps.Map(document.getElementById('{$id}_map_canvas'),mapOptions);

				// set center and zoom level
				{$this->getClientScriptPart()}

				google.maps.event.addListener({$id}_map, 'zoom_changed', function() {
					$('#{$id}_zoom').val({$id}_map.getZoom());
				});
				google.maps.event.addListener({$id}_map, 'center_changed', function() {
					$('#{$id}_ce_lat').val({$id}_map.getCenter().lat());
					$('#{$id}_ce_lon').val({$id}_map.getCenter().lng());
				});
				var {$id}_polyStyle = {
					markerImage : '{$baseUrl}/images/square.png'
				}

				{$id}_polyDragControl = new MPolyDragControl({map:{$id}_map,style:{$id}_polyStyle});
				{$id}_polyDragControl.ondragend = {$id}_getCoordinates;

				var {$id}_sw_lat= $('#{$id}_sw_lat').val();
				var {$id}_sw_lon= $('#{$id}_sw_lon').val();
				var {$id}_ne_lat= $('#{$id}_ne_lat').val();
				var {$id}_ne_lon= $('#{$id}_ne_lon').val();

				if({$id}_sw_lat && {$id}_sw_lon && {$id}_ne_lat && {$id}_ne_lon) {
					{$id}_polyDragControl.initialRectangle({$id}_sw_lat, {$id}_sw_lon, {$id}_ne_lat, {$id}_ne_lon);
				}
			}

			function {$id}_getCoordinates() {
				var coords = {$id}_polyDragControl.getCoords();
				$('#{$id}_sw_lat').val(coords['sw_lat']);
				$('#{$id}_sw_lon').val(coords['sw_lon']);
				$('#{$id}_ne_lat').val(coords['ne_lat']);
				$('#{$id}_ne_lon').val(coords['ne_lon']);
			}

			function {$id}_clearCoordinates() {
				$('#{$id}_sw_lat').val('');
				$('#{$id}_sw_lon').val('');
				$('#{$id}_ne_lat').val('');
				$('#{$id}_ne_lon').val('');
			}

			function {$id}_clearMap() {
				{$id}_polyDragControl.clear();
				{$id}_clearCoordinates();
			}

			google.maps.event.addDomListener(window, 'load', {$id}_initialize);
		",CClientScript::POS_HEAD);
	}
}