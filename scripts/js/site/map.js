/**
 * Created by Edgar on 4/14/14.
 */

var markers = new Array();
var newMarkers = new Array();
var lastInfoWindows;
var map;
var poly;
var polyOptions;
var maxMarkersMsj = 'Reached the maximum number of markers available';

$(window).load(function(e){
	google.maps.event.addDomListener(window, 'load', mapIni);
});

$(document).ready(function(e){
	google.maps.event.addDomListener(window, 'load', mapIni);
});

function mapIni()
{
	var mapOptions = {
		scaleControl: true,
		zoom: 14,
		center: new google.maps.LatLng(-25.363883, 131.044923)
	};

	if(defaultUI != undefined)
		mapOptions.disableDefaultUI = defaultUI;

	map = new google.maps.Map(document.getElementById('map'),
		mapOptions);

	if(addMarkers.traceRoute != undefined && addMarkers.traceRoute == true)
	{
		polyOptions = {
			strokeColor: '#000000',
			strokeOpacity: 0.9,
			strokeWeight: 3
		};

		poly = new google.maps.Polyline(polyOptions);
		poly.setMap(map);
	}

	markersIni(markersData);

	if(addMarkers != undefined && addMarkers.enabled == true)
	{
		google.maps.event.addListener(map, 'click', function(event) {
			if(addMarkers.limit == 0 || newMarkers.length < addMarkers.limit)
				addNewMarker(event.latLng,addMarkers);
			else
				alert(maxMarkersMsj);
		});
	}
}

function markersIni(markersData)
{
	if(markersData == undefined)
		return;

	$.each(markersData,function(index,data){

		markers[index] = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng(data.x,data.y),
			title: data.title,
			icon: data.image,
			shape: data.shape
		});

		addMarkerMessage(markers[index],data.message);
	});
}

function addMarkerMessage(marker,message)
{
	var infowindow = new google.maps.InfoWindow({
		content: message
	});

	google.maps.event.addListener(marker, 'click', function() {
		if(lastInfoWindows != undefined)
			lastInfoWindows.close();

		lastInfoWindows = infowindow;
		infowindow.open(marker.get('map'), marker);
	});
}

function addNewMarker(location,options) {
	var canTrace = (addMarkers.traceRoute != undefined && addMarkers.traceRoute == true);

	if(canTrace)
		pushPolyPath(location);

	var marker = new google.maps.Marker({
		position: location,
		map: map
	});

	if(options.centerOnClick != undefined && options.centerOnClick == true)
		map.panTo(location);

	if(options.deleteOnClick != undefined && options.deleteOnClick == true)
	{
		var position;

		google.maps.event.addListener(marker, 'click', function() {
			position = newMarkers.indexOf(marker);

			if (position > -1) {
				newMarkers.splice(position, 1);
			}

			marker.setMap(null);

			if(canTrace)
			{
				poly.setMap(null);
				poly = new google.maps.Polyline(polyOptions);
				poly.setMap(map);

				$.each(newMarkers,function(index,data) {
					pushPolyPath(data.getPosition());
				});
			}
		});
	}

	newMarkers.push(marker);
}

function pushPolyPath(location)
{
	var path = poly.getPath();
	path.push(location)
}