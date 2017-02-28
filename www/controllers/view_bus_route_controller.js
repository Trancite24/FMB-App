/**
 * Created by ASUS-PC on 2/28/2017.
 */

var map, ren, ser;
var data = {};

function initMap() {
    $('#loadingDiv').show();
    map = new google.maps.Map(document.getElementById('adminMap'),
        {
            'zoom': 5, 'mapTypeId': google.maps.MapTypeId.ROADMAP,
            'center': new google.maps.LatLng(7.8731, 80.7718)
        });

    ren = new google.maps.DirectionsRenderer({'draggable': false});
    ren.setMap(map);
    ser = new google.maps.DirectionsService();
    fetchdata();
    $('#loadingDiv').hide();


}

function fetchdata() {
    $('#loadingDiv').show();
    var route_no = localStorage.getItem("bus_route_no");

    jQuery.ajax({
        type: "GET",
        dataType: 'jsonp',
        url: "http://www.titansmora.org/findmybusfinal/BusRouteMap/busRouteMapLoader.php?" +
        "route_no=" + route_no,
        success: function (obj) {
            try {
                setroute(eval('(' + obj + ')'));
            }
            catch (e) {
                alert(e);
            }
            $('#loadingDiv').hide();

        } ,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingDiv').hide();
        }
    });
}
function setroute(os) {
    $('#loadingDiv').show();

    var wp = [];
    for (var i = 0; i < os.waypoints.length; i++)
        wp[i] = {'location': new google.maps.LatLng(os.waypoints[i][0], os.waypoints[i][1]), 'stopover': false}

    ser.route({
        'origin': new google.maps.LatLng(os.start.lat, os.start.lng),
        'destination': new google.maps.LatLng(os.end.lat, os.end.lng),
        'waypoints': wp,
        'travelMode': google.maps.DirectionsTravelMode.DRIVING
    }, function (res, sts) {
        if (sts == 'OK') ren.setDirections(res);
    })
    $('#loadingDiv').hide();

}