function goContact(){
    window.location = "menu.html"
}

function goHome(){
    window.location = "home.html"
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

            if(obj.length>0){
                localStorage.setItem("results",JSON.stringify(obj));
                window.location = "search_result.html";
            }else{
                alert('No Buses Found.');
            }
            $('#loadingDiv').hide();

        } ,
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $('#loadingDiv').hide();
        }
    });


}


function timeTableWindow(){
    $('#loadingDiv').show();
    window.location = "timeTables.html";
}
function RoutesWindow(){
    $('#loadingDiv').show();
    window.location = "staticRoute.html";
}

function transitPlanWindow(){
    $('#loadingDiv').show();
    window.location = "transit.html";
}

function busSearchWindow(){
    $('#loadingDiv').show();
    window.location = "home.html";
}


function openModal() {
    document.getElementById('modal').style.display = 'block';

}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function onload_autosugest(){

    $('#loadingDiv').show();
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
                    $('#loadingDiv').hide();
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#loadingDiv').hide();
                }
            });
        }else{
            for (var i = 0; i < autoSuggest.length; i++) {
                $('#cities').append(
                    '<option value=' + '"' + autoSuggest[i] + '"' + '></option>');
            }
            $('#loadingDiv').hide();

        }

    });
}

