var infowindows = [];
var markers = [];
var map = null;
var openedInfo = null;
jQuery(document).ready(function ($) {

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/* google */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

function initialize() {
    var map_canvas = document.getElementById('googleMap');
    if(map_canvas == null) return;
    var myLat = fastwp.gmap_center[0];
    var myLng = fastwp.gmap_center[1];

    var map_options = {
        center: new google.maps.LatLng(myLat, myLng),
        zoom: parseInt(fastwp.gmap_zoom),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false
    };

    map = new google.maps.Map(map_canvas, map_options);

    if(typeof fastwp.gmap_marker_addrs != 'undefined' && fastwp.gmap_marker_addrs.length > 0){
        for (var i = 0; i < fastwp.gmap_marker_addrs.length; i++) {
            var title = (typeof fastwp.gmap_marker_titles[i] != 'undefined'? fastwp.gmap_marker_titles[i] : '');
            var mlat = fastwp.gmap_marker_addrs[i][0];
            var mlng = fastwp.gmap_marker_addrs[i][1];

            markers[i] = new google.maps.Marker({
                position: new google.maps.LatLng(mlat, mlng),
                map: map,
                title: title
            });
        };
    }

    if(typeof fastwp.gmap_style == 'undefined' || fastwp.gmap_style == 'fastwp'){
        var styles = [{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}];
        map.setOptions({styles: styles});
    }

    if(markers.length > 0){
        for (i=0; i<markers.length; i++) {
            var contentString   = (typeof fastwp.gmap_marker_ct[i] != 'undefined')? fastwp.gmap_marker_ct[i] : '';
            infowindows[i]      = new google.maps.InfoWindow({  content: contentString });
            google.maps.event.addListener(markers[i], 'click', makeMapListener(infowindows[i], map, markers[i], i));
        };
    }
}

function makeMapListener(window, map, markers, index) {
    return function() {
        if(typeof openedInfo == 'string'){
            try{
                eval(openedInfo).close();
            } catch(e){ }
        }
        map.setZoom(parseInt(fastwp.gmap_izoom));
    /*    map.setCenter(markers.getPosition()); */
        window.open(map, markers);
        openedInfo = 'infowindows['+index+']' ;
    };
}

google.maps.event.addDomListener(window, 'load', initialize);


});