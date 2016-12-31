function goContact(){
    window.location = "contact.html"
}

function goHome(){
    window.location = "home.html"
}

function getGPSData(){

}

function goResults(){

    var from  = $('#from').val();
    var to = $('#to').val();

    console.log(from+" "+to);
    ftp://dimuthu@titansmora.org@ftp.titansmora.org/findmybusfinal/Connection/connection.php
    jQuery.ajax({
        type: "GET",
        dataType: 'jsonp',
        url: "http://www.titansmora.org/findmybusfinal/BusRouteMap/getRoutesOfLocations.php?start="+from+"&destination="+to,
        success: function (obj, textstatus) {

            console.log(obj);
            if(obj.length>0){
                localStorage.setItem("results",JSON.stringify(obj));
                window.location = "search_result.html";
            }else{
                alert('No Buses Found.');
            }

        }
    });


}


function timeTableWindow(){
    window.location = "timeTables.html";
}
function RoutesWindow(){
    window.location = "staticRoute.html";
    // navigator.notification.alert(  // message
    //     'Searching will give you the plans that you can use. ' +
    //     'If you only enter start and destination, all the buses which travel between them will be given as the result.',
    //     null,                   // callback
    //     'Search for results',            // title
    //     'Ok'                  // buttonName
    // );
}

function transitPlanWindow(){
    window.location = "transit.html";
    // navigator.notification.alert(  // message
    //     'We provide you with the most convenient routes that you can take to reach your destination in the least possible time. ',
    //     null,                   // callback
    //     'View the Plan',            // title
    //     'Ok'                  // buttonName
    // );
}

function busSearchWindow(){
    window.location = "home.html";
    // navigator.notification.alert(  // message
    //     'Enter - Search - Plan and that\'s it, you are ready to go.',
    //     null,                   // callback
    //     'That\'s All',            // title
    //     'Ok'                  // buttonName
    // );
}


function openModal() {
    document.getElementById('modal').style.display = 'block';

}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

