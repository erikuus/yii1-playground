MPolyDragControl = function(MOptions) {

	MOptions = MOptions ? MOptions : {};
	this.map = MOptions.map ? MOptions.map : null;

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

	this.initialize();
};

MPolyDragControl.prototype.initialize = function() {
	this.self = this;
	this.bounds = null;
	this.addListener();
	this.dragMarker0;
	this.dragMarker1;
	this.polyEditIcon = {
    	url: this.style.markerImage,
    	size: new google.maps.Size(11,11),
    	anchor: new google.maps.Point(6,6)
    };
};

MPolyDragControl.prototype.initialRectangle = function(sw_lat, sw_lon, ne_lat, ne_lon) {

	var self = this.self;
	self.clear();

	var sw_latlon = new google.maps.LatLng(sw_lat, sw_lon);
	var ne_latlon = new google.maps.LatLng(ne_lat, ne_lon);

	var p1 = sw_latlon
	var p2 = new google.maps.LatLng(ne_lat, sw_lon);
	var p3 = ne_latlon;
	var p4 = new google.maps.LatLng(sw_lat, ne_lon);
	var points = Array(p1,p2,p3,p4,p1);

	self.drawPoly(points);

	self.dragMarker0 = new google.maps.Marker({
		position: sw_latlon,
		map: this.map,
		icon: self.polyEditIcon,
		draggable:true,
		crossOnDrag: false
	});

	self.dragMarker1 = new google.maps.Marker({
		position: ne_latlon,
		map: this.map,
		icon: self.polyEditIcon,
		draggable:true,
		crossOnDrag: false
	});

	google.maps.event.addListener(self.dragMarker0,'dragstart',function(){self.dragStart(this)});
	google.maps.event.addListener(self.dragMarker0,'drag',function(){self.drag(this)});
	google.maps.event.addListener(self.dragMarker0,'dragend',function(){self.dragEnd(this)});

	google.maps.event.addListener(self.dragMarker1,'dragstart',function(){self.dragStart(this)});
	google.maps.event.addListener(self.dragMarker1,'drag',function(){self.drag(this)});
	google.maps.event.addListener(self.dragMarker1,'dragend',function(){self.dragEnd(this)});
};

MPolyDragControl.prototype.addListener = function(latlon) {
	var self = this.self;
	google.maps.event.addListener(this.map,'click',function(event){self.mapClick(event)});
}

MPolyDragControl.prototype.mapClick = function(event) {

	var self = this.self;

	self.clear();

	var lat = event.latLng.lat();
	var lng = event.latLng.lng();

	self.dragMarker0 = new google.maps.Marker({
		position: new google.maps.LatLng(lat,lng),
		map: this.map,
		icon: self.polyEditIcon,
		draggable:true,
		crossOnDrag: false
	});

	self.dragMarker1 = new google.maps.Marker({
		position: new google.maps.LatLng(lat,lng),
		map: this.map,
		icon: self.polyEditIcon,
		draggable:true,
		crossOnDrag: false
	});

	google.maps.event.addListener(self.dragMarker0,'dragstart',function(){self.dragStart(this)});
	google.maps.event.addListener(self.dragMarker0,'drag',function(){self.drag(this)});
	google.maps.event.addListener(self.dragMarker0,'dragend',function(){self.dragEnd(this)});

	google.maps.event.addListener(self.dragMarker1,'dragstart',function(){self.dragStart(this)});
	google.maps.event.addListener(self.dragMarker1,'drag',function(){self.drag(this)});
	google.maps.event.addListener(self.dragMarker1,'dragend',function(){self.dragEnd(this)});

	this.poly = new google.maps.Polygon({
		paths: [event.latLng,event.latLng,event.latLng,event.latLng,event.latLng],
		strokeColor: this.style.strokeColor,
		strokeWeight: this.style.strokeWeight,
		strokeOpacity: this.style.strokeOpacity,
		fillColor: this.style.fillColor,
		fillOpacity: this.style.fillOpacity
	});

	this.poly.setMap(this.map);
};

MPolyDragControl.prototype.dragStart = function() {
};

MPolyDragControl.prototype.drag = function() {
	var self = this.self;
	self.updateRectangle();
};

MPolyDragControl.prototype.dragEnd = function() {
	var self = this.self;
	if (self.ondragend) {
		self.ondragend();
	}
};

MPolyDragControl.prototype.updateRectangle = function() {
	var self = this.self;
	var latlon0 = self.dragMarker0.position;
	var latlon1 = self.dragMarker1.position;

	self.bounds = null;
	self.bounds = new google.maps.LatLngBounds();

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
	var p2 = new google.maps.LatLng(this.bounds.getNorthEast().lat(),this.bounds.getSouthWest().lng());
	var p3 = this.bounds.getNorthEast();
	var p4 = new google.maps.LatLng(this.bounds.getSouthWest().lat(),this.bounds.getNorthEast().lng());
	var points = Array(p1,p2,p3,p4,p1);

	self.drawPoly(points);
};

MPolyDragControl.prototype.drawPoly = function(points) {
	if (this.poly) {
		this.poly.setMap(null);
		this.poly = null;
	}
	this.poly = new google.maps.Polygon({
		paths: points,
		strokeColor: this.style.strokeColor,
		strokeWeight: this.style.strokeWeight,
		strokeOpacity: this.style.strokeOpacity,
		fillColor: this.style.fillColor,
		fillOpacity: this.style.fillOpacity
	});
	this.poly.setMap(this.map);
}

MPolyDragControl.prototype.clear = function() {
	var self = this.self;
	if (self.onclear) {
		self.onclear();
	}
	if (this.poly) {
		this.poly.setMap(null);
		this.poly = null;
	}
	if (this.dragMarker0) {
		this.dragMarker0.setMap(null);
		this.dragMarker0 = null;
	}
	if (this.dragMarker1) {
		this.dragMarker1.setMap(null);
		this.dragMarker1 = null;
	}
};

MPolyDragControl.prototype.getParams = function() {
	var str = '';
	str += 'lat1=' + this.bounds.getSouthWest().lat().toFixed(5) + '&lat2=' + this.bounds.getNorthEast().lat().toFixed(5);
	str += '&lon1=' + this.bounds.getSouthWest().lng().toFixed(5) + '&lon2=' + this.bounds.getNorthEast().lng().toFixed(5);
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

MPolyDragControl.prototype.show = function() {
	this.poly.show();
};

MPolyDragControl.prototype.hide = function() {
	this.poly.hide();
};

MPolyDragControl.prototype.isVisible = function() {
	return !this.poly.isHidden();
};
