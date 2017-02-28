/**
 * Created by ASUS-PC on 12/14/2016.
 */

function goContact(){
    window.location = "menu.html";
}

function goHome(){
    window.history.back();
}

function viewMap(){
    $('#loadingDiv').show();
    window.location="viewBusRoute.html"
}

function onload_bushaltlist(){
    $('#loadingDiv').show();
    var bus_halt_list = JSON.parse(localStorage.getItem("bus_halt_list"));

    $('#timeToDestination').text("Bus Route : "+ localStorage.getItem("bus_route_no"));
    $('#from').text("Start : "+localStorage.getItem("bus_route_start"));
    $('#to').text("To : "+localStorage.getItem("bus_route_end"));

    $.each(bus_halt_list, function (index, element) {

        $('#exchange_stations').append(
            '<div class="contact">'+
            '<div class="dot z-depth-1"></div>'+
            '<p>'+element+'</p>'+
            '</div>'
        )

    });
    $('#loadingDiv').hide();
}


