function goResults(){
    $('#loadingDiv').show();
    var routeData = $('#route').val().split(" ");

    var route_no = routeData[0];
    var startEnd = routeData[1].split("-");

    localStorage.setItem("bus_route_timetable_route_no",route_no);

    jQuery.ajax({
        type: "GET",
        dataType: 'jsonp',
        url: "http://www.titansmora.org/findmybusfinal/TimeTables/viewTimeTables.php?start="+startEnd[0]+"&end="+startEnd[1]+"&route_no="+route_no,
        success: function (obj, textstatus) {
            console.log(obj);

            $('#route_table_div').show();

            for(var i=0;i<obj.length;i++){
                var timeTableRow = obj[i];
                $('#route_table_body').append(
                    '<tr>'+
                    '<td class="price us"><i class="fa fa-bus" aria-hidden="true"></i> '+timeTableRow.start_halt_short+'</td>'+
                    '<td class="wthree"><i class="fa fa-clock-o"></i> '+timeTableRow.start_time+'</td>'+
                    '<td class="price us"> '+timeTableRow.end_halt_short+'</td>'+
                    '<td class="wthree"> '+timeTableRow.end_time+'</td>'+
                    '</tr>'
                );
            }
            $('#loadingDiv').hide();
        } ,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingDiv').hide();
        }
    });

}

function viewMap(){
    window.location="viewBusRoute.html"
}

function onload_route_timetable(){
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
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#loadingDiv').hide();
                }
            });

        });

;

    });
}