/**
 * Created by ASUS-PC on 2/28/2017.
 */

function onload_search_result(){
    var locations = [];
    $(document).ready(function () {
        var results = JSON.parse(localStorage.getItem("results"));

        $.each(results, function (index, value) {
            locations.push([value.VehNoF,value.latitude, value.logitude]);
            $('#resultdiv').append("<li class=\"list-message\" data-ix=\"list-item\">" +
                "<a class=\"w-clearfix w-inline-block result\">" +
                "<div class=\"column-right\" style=\"padding-left: 20px\">" +
                "<div class=\"message-title\"> Route No: "+ value.route_no+ "</div>" +
                "<div class=\"message-text\"><b>Vehicle No : " + value.VehNoF + "</b><br><b>Now at: </b>" + value.now_at + "<br><b>Time to arrive : </b>" + value.timeToArrive + "<br><b>Distance from start point: </b>" + value.distance + "<br></div>" +
                "</div>" +
                "</a>" +
                "</li>");
        });
        localStorage.setItem("map_data",JSON.stringify(locations));
    });
}

function goBusMap(){
    window.location = "busmap.html";
}