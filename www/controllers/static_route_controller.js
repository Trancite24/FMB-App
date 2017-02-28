function getStaticRoute(){
    $('#loadingDiv').show();
    var routeData = $('#route').val().split(" ");

    var route_no = routeData[0];
    var startEnd = routeData[1].split("-");

    localStorage.setItem("bus_route_no",route_no);
    localStorage.setItem("bus_route_start",startEnd[0]);
    localStorage.setItem("bus_route_end",startEnd[1]);

    jQuery.ajax({
        type: "GET",
        dataType: 'jsonp',
        url: "http://www.titansmora.org/findmybusfinal/BusRouteMap/getRouteLocations.php?route_no=" + route_no,
        success: function (obj, textstatus) {
            localStorage.setItem("bus_halt_list",JSON.stringify(obj));
            window.location = "bushaltlist.html";
            $('#loadingDiv').hide();
        } ,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingDiv').hide();
        }
    });
}

function onload_static_route(){
    $('#loadingDiv').show();
    $(function () {

        $(function () {
            jQuery.ajax({
                type: "GET",
                dataType: 'jsonp',
                url: "http://www.titansmora.org/findmybusfinal/TimeTables/getRoutes.php",
                success: function (obj, textstatus) {
                    if (!('error' in obj)) {
                        $.each(obj, function (index, element) {
                            $('#routes').append(
                                '<option value=' + '"' + element + '"' + '></option>');
                        });

                    }
                    else {
                        console.log(obj.error);
                    }
                    $('#loadingDiv').hide();
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#loadingDiv').hide();
                }
            });

        });
    });
}