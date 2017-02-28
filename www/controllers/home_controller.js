function goContact(){
    window.location = "menu.html"
}

function goHome(){
    window.location = "home.html"
}

function getGPSData(){

}

function goResults(){

    var from  = $('#from').val();
    var to = $('#to').val();

    $('#loadingDiv').show();
    jQuery.ajax({
        type: "GET",
        dataType: 'jsonp',
        url: "http://www.titansmora.org/findmybusfinal/BusRouteMap/getRoutesOfLocations.php?start="+from+"&destination="+to,
        success: function (obj, textstatus) {
            $('#loadingDiv').hide();
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

function onload_autosugest(){
    $(function () {

        var autoSuggest = JSON.parse(localStorage.getItem("autosuggest"));


        if(autoSuggest==null){
            var autosuggest_adddresses = [];

            jQuery.ajax({
                type: "GET",
                dataType: 'jsonp',
                url: "http://www.titansmora.org/findmybusfinal/LocationsLIst/getLocationsList.php",
                success: function (obj) {
                    localStorage.setItem("autosuggest",JSON.stringify(obj));
                    if (!('error' in obj)) {
                        $.each(obj, function (index, element) {
                            autosuggest_adddresses.push(element);
                            $('#cities').append(
                                '<option value=' + '"' + element + '"' + '></option>');
                        });

                    }
                    else {
                        console.log(obj.error);
                    }
                }
            });
        }else{
            for (var i = 0; i < autoSuggest.length; i++) {
                $('#cities').append(
                    '<option value=' + '"' + autoSuggest[i] + '"' + '></option>');
            }

        }

    });
}

