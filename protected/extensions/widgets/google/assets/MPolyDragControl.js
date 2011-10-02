MPolyDragControl = function(MOptions) {
	MOptions = MOptions ? MOptions : {};
	this.type = MOptions.type ? MOptions.type : 'rectangle';
	this.map = MOptions.map ? MOptions.map : null;
	this.unitDivisor = 2589988.11;

	this.style = {
		markerImage : 'square.png',
		strokeColor : 'red',
		strokeWeight : 2,
		strokeOpacity : 0.5,
		fillColor : 'yellow',
		fillOpacity : 0.3
	};

	for (var s in MOptions.style) {
		this.style[s]=MOptions.style[s];
	}

	this.initialize()
};

MPolyDragControl.prototype.initialize = function() {
	this.self = this;
	this.polyInitialized = false;
	this.bounds = null;
	this.addListener();

	this.radius;
	this.circleCenter;

	this.dragMarker0;
	this.dragMarker1;

	var baseIcon = new GIcon();
	baseIcon.iconSize = new GSize(11,11);
	baseIcon.iconAnchor = new GPoint(6,6);
	baseIcon.infoWindowAnchor = new GPoint(1,1);
	baseIcon.dragCrossSize = new GSize(0,0);
	baseIcon.maxHeight = 0.1;
	this.polyEditIcon = (new GIcon(baseIcon, this.style.markerImage));
};

MPolyDragControl.prototype.initialRectangle = function(sw_lat, sw_lon, ne_lat, ne_lon) {
	var self = this.self;
	self.clear();

	var sw_latlon = new GLatLng(sw_lat, sw_lon);
	var ne_latlon = new GLatLng(ne_lat, ne_lon);

	var p1 = sw_latlon
	var p2 = new GLatLng(ne_lat, sw_lon);
	var p3 = ne_latlon;
	var p4 = new GLatLng(sw_lat, ne_lon);
	var points = Array(p1,p2,p3,p4,p1);

	self.drawPoly(points);

	self.dragMarker0 = new GMarker(sw_latlon,{icon:self.polyEditIcon,draggable:true,bouncy:false,dragCrossMove:true});
	self.map.addOverlay(self.dragMarker0);

	self.dragMarker1 = new GMarker(ne_latlon,{icon:self.polyEditIcon,draggable:true,bouncy:false,dragCrossMove:true});
	self.map.addOverlay(self.dragMarker1);

	GEvent.addListener(self.dragMarker0,'dragstart',function(){self.dragStart(this)});
	GEvent.addListener(self.dragMarker0,'drag',function(){self.drag(this)});
	GEvent.addListener(self.dragMarker0,'dragend',function(){self.dragEnd(this)});

	GEvent.addListener(self.dragMarker1,'dragstart',function(){self.dragStart(this)});
	GEvent.addListener(self.dragMarker1,'drag',function(){self.drag(this)});
	GEvent.addListener(self.dragMarker1,'dragend',function(){self.dragEnd(this)});
};

MPolyDragControl.prototype.addListener = function(latlon) {
	var self = this.self;
	GEvent.addListener(this.map,'click',function(a,b,c){self.mapClick(b)});
}

MPolyDragControl.prototype.mapClick = function(latlon) {

	var self = this.self;

	self.clear();

	self.dragMarker0 = new GMarker(latlon,{icon:self.polyEditIcon,draggable:true,bouncy:false,dragCrossMove:true});
	self.map.addOverlay(self.dragMarker0);

	self.dragMarker1 = new GMarker(latlon,{icon:self.polyEditIcon,draggable:true,bouncy:false,dragCrossMove:true});
	self.map.addOverlay(self.dragMarker1);

	GEvent.addListener(self.dragMarker0,'dragstart',function(){self.dragStart(this)});
	GEvent.addListener(self.dragMarker0,'drag',function(){self.drag(this)});
	GEvent.addListener(self.dragMarker0,'dragend',function(){self.dragEnd(this)});

	GEvent.addListener(self.dragMarker1,'dragstart',function(){self.dragStart(this)});
	GEvent.addListener(self.dragMarker1,'drag',function(){self.drag(this)});
	GEvent.addListener(self.dragMarker1,'dragend',function(){self.dragEnd(this)});

	this.poly = new GPolygon([latlon,latlon,latlon,latlon,latlon],this.style.strokeColor,this.style.strokeWeight,this.style.strokeOpacity,this.style.fillColor,this.style.fillOpacity);
	this.map.addOverlay(this.poly);
};

MPolyDragControl.prototype.dragStart = function() {
};

MPolyDragControl.prototype.drag = function() {
	var self = this.self;

	if (self.type == 'circle') {
		self.updateCircle();
	}
	else if (self.type == 'rectangle') {
		self.updateRectangle();
	}
};

MPolyDragControl.prototype.dragEnd = function() {
	var self = this.self;
	if (self.ondragend) {
		self.ondragend();
	}
//    GLog.write('Search parameters: ' + self.getParams());
};

MPolyDragControl.prototype.updateRectangle = function() {
	var self = this.self;
	var latlon0 = self.dragMarker0.getLatLng();
	var latlon1 = self.dragMarker1.getLatLng();

	self.bounds = null;
	self.bounds = new GLatLngBounds();

	if (latlon0.lat() <= latlon1.lat() && latlon0.lng() <= latlon1.lng()) {
		var p1 = latlon0; // SW
		var p2 = latlon1; // NE
	}
	else if (latlon0.lat() <= latlon1.lat() && latlon0.lng() >= latlon1.lng()) {
		var p1 = latlon0; // SE
		var p2 = latlon1; // NW
	}
	else if (latlon0.lat() >= latlon1.lat() && latlon0.lng() >= latlon1.lng()) {
		var p1 = latlon0; // NE
		var p2 = latlon1; // SW
	}
	else if (latlon0.lat() >= latlon1.lat() && latlon0.lng() <= latlon1.lng()) {
		var p1 = latlon0; // NW
		var p2 = latlon1; // SE
	}

	self.bounds.extend(p1);
	self.bounds.extend(p2);

	var p1 = this.bounds.getSouthWest();
	var p2 = new GLatLng(this.bounds.getNorthEast().lat(),this.bounds.getSouthWest().lng());
	var p3 = this.bounds.getNorthEast();
	var p4 = new GLatLng(this.bounds.getSouthWest().lat(),this.bounds.getNorthEast().lng());
	var points = Array(p1,p2,p3,p4,p1);

	self.drawPoly(points);

};

MPolyDragControl.prototype.updateCircle = function() {

	this.circleCenter = this.dragMarker0.getLatLng();
	var points = Array();
	this.radius = this.dragMarker0.getLatLng().distanceFrom(this.dragMarker1.getLatLng()); // meters

	with (Math) {
		var d = this.radius/6378800;    // circle radius / meters of Earth radius = radians
		var lat1 = (PI/180)* this.circleCenter.lat(); // radians
		var lng1 = (PI/180)* this.circleCenter.lng(); // radians

		for (var a = 0 ; a < 361 ; a+=10 ) {
			var tc = (PI/180)*a;
			var y = asin(sin(lat1)*cos(d)+cos(lat1)*sin(d)*cos(tc));
			var dlng = atan2(sin(tc)*sin(d)*cos(lat1),cos(d)-sin(lat1)*sin(y));
			var x = ((lng1-dlng+PI) % (2*PI)) - PI ; // MOD function
			var point = new GLatLng(parseFloat(y*(180/PI)),parseFloat(x*(180/PI)));
			points.push(point);
		}
	}

	this.drawPoly(points);
};

MPolyDragControl.prototype.drawPoly = function(points) {
	if (this.poly) {
		this.map.removeOverlay(this.poly);
		this.poly = null;
	}
	this.poly = new GPolygon(points,this.style.strokeColor,this.style.strokeWeight,this.style.strokeOpacity,this.style.fillColor,this.style.fillOpacity);
	this.map.addOverlay(this.poly);
}

MPolyDragControl.prototype.clear = function() {
	var self = this.self;
	if (self.onclear) {
		self.onclear();
	}
	if (this.poly) {
		this.map.removeOverlay(this.poly);
		this.poly = null;
	}
	if (this.dragMarker0) {
		this.map.removeOverlay(this.dragMarker0);
		this.dragMarker0 = null;
	}
	if (this.dragMarker1) {
		this.map.removeOverlay(this.dragMarker1);
		this.dragMarker1 = null;
	}
};

MPolyDragControl.prototype.getParams = function() {
	var str = '';
	if (this.type == 'circle') {
		str += 'centerLat=' + this.circleCenter.lat().toFixed(5) + '&centerLon=' + this.circleCenter.lng().toFixed(5);
		str += '&radius=' + (this.radius / 1609).toFixed(2);
	}
	else {
		str += 'lat1=' + this.bounds.getSouthWest().lat().toFixed(5) + '&lat2=' + this.bounds.getNorthEast().lat().toFixed(5);
		str += '&lon1=' + this.bounds.getSouthWest().lng().toFixed(5) + '&lon2=' + this.bounds.getNorthEast().lng().toFixed(5);
	}
	return str;
}

MPolyDragControl.prototype.getCoords = function() {
	return coords = {
		sw_lat : this.bounds.getSouthWest().lat().toFixed(5),
		ne_lat : this.bounds.getNorthEast().lat().toFixed(5),
		sw_lon : this.bounds.getSouthWest().lng().toFixed(5),
		ne_lon : this.bounds.getNorthEast().lng().toFixed(5)
	}
}

MPolyDragControl.prototype.setType = function(type) {
	this.type = type;
	if (this.poly) {
		this.drag();
		this.dragEnd();
	}
};

MPolyDragControl.prototype.show = function() {
	this.poly.show();
};

MPolyDragControl.prototype.hide = function() {
	this.poly.hide();
};

MPolyDragControl.prototype.isVisible = function() {
	return !this.poly.isHidden();
};
