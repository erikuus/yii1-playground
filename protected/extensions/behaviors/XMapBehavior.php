<?php
/**
 * XMapBehavior
 *
 * This behavior adds some general map methods to a model
 *
 * This behavior can be attached to a model on its behaviors() method:
 * <pre>
 * public function behaviors()
 * {
 *     return array(
 *         'MapBehavior' => array(
 *             'class' => 'ext.behaviors.XMapBehavior',
 *         ),
 *     );
 * }
 * </pre>
 *
 * NOTE!
 *
 * This behavior requires that the model you want to attach this behavior has following attributes:
 * 1) map central latitude,
 * 2) map central longitude,
 * 3) map zoom level,
 * 4) select rectangle SW latitude,
 * 5) select rectangle SW longitude,
 * 6) select rectangle NE latitude,
 * 7) select rectangle NE longitude.
 *
 * USAGE:
 *
 * The following example shows how XMapBehavior can be used with XGoogleStaticMap widget
 * <pre>
 * $this->widget('ext.widgets.google.XGoogleStaticMap',array(
 *     'visible'=>$model->checkBounds(),
 *     'center'=>$model->mapCenter,
 *     'zoom'=>$model->mapZoom,
 *     'alt'=>$model->pealkiri,
 *     'width'=>450,
 *     'height'=>300,
 *     'paths'=>array(
 *         array(
 *              'style'=>array('color'=>'red','fillcolor'=>'yellow','weight'=>2),
 *              'locations'=>$model->mapLocations,
 *         ),
 *     ),
 * ));
 * </pre>
 *
 * The following examples shows how to use XMapBehavior to build PostGis query condition.
 * This example assumes that XGoogleInputMap widget is used in search form.
 * <pre>
 * if($form->checkBounds())
 *     $criteria->addCondition("st_contains(SetSRID('BOX3D(".$form->getBboxParams().")'::box3d,4326),bbox)");
 * </pre>
 *
 * @author Erik Uus <erik.uus@gmail.com>
 * @version 1.0.0
 */
class XMapBehavior extends CModelBehavior
{
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
	 * @return string of zoom level for XGoogleStaticMap widget
	 */
	public function getMapZoom()
	{
		$owner=$this->getOwner();
		if($owner->{$this->zoom})
			return $owner->{$this->zoom};
		else
			return '';
	}

	/**
	 * @return string of center points for XGoogleStaticMap widget
	 */
	public function getMapCenter()
	{
		$owner=$this->getOwner();
		if($this->checkMap())
			return $owner->{$this->ce_lat}.','.$owner->{$this->ce_lon};
		else
			return '';
	}

	/**
	 * @return boolean wether map params are set
	 */
	public function checkMap()
	{
		$owner=$this->getOwner();
		if(
			$owner->{$this->ce_lat} &&
			$owner->{$this->ce_lon}
		)
			return true;
		else
			return false;
	}

	/**
	 * @return boolean wether bounds params are set
	 */
	public function checkBounds()
	{
		$owner=$this->getOwner();
		if(
			$owner->{$this->sw_lat} &&
			$owner->{$this->sw_lon} &&
			$owner->{$this->ne_lat} &&
			$owner->{$this->ne_lon}
		)
			return true;
		else
			return false;
	}

	/**
	 * @return array of location points for XGoogleStaticMap widget
	 */
	public function getMapLocations()
	{
		$owner=$this->getOwner();
		$points=array();
		if($this->checkBounds())
		{
			$p1 = $owner->{$this->sw_lat}.','.$owner->{$this->sw_lon};
			$p2 = $owner->{$this->ne_lat}.','.$owner->{$this->sw_lon};
			$p3 = $owner->{$this->ne_lat}.','.$owner->{$this->ne_lon};
			$p4 = $owner->{$this->sw_lat}.','.$owner->{$this->ne_lon};
			$points=array($p1,$p2,$p3,$p4,$p1);
		}
		return $points;
	}

	/**
	 * @return string bounding box params (ex. 25.40039 58.13476, 27.33398 58.72146)
	 */
	public function getBboxParams()
	{
		$owner=$this->getOwner();
		return $owner->{$this->sw_lon}." ".$owner->{$this->sw_lat}.", ".$owner->{$this->ne_lon}." ".$owner->{$this->ne_lat};
	}

	/**
	 * Prepares attributes after performing validation.
	 */
	public function afterValidate($event)
	{
		$owner=$this->getOwner();
		if(!$owner->hasErrors())
		{
			if(!$this->checkMap())
			{
				$owner->{$this->ce_lat}=null;
				$owner->{$this->ce_lon}=null;
			}
			if(!$this->checkBounds())
			{
				$owner->{$this->ce_lat}=null;
				$owner->{$this->ce_lon}=null;
				$owner->{$this->zoom}=null;
				$owner->{$this->sw_lat}=null;
				$owner->{$this->sw_lon}=null;
				$owner->{$this->ne_lat}=null;
				$owner->{$this->ne_lon}=null;
			}
		}
	}
}