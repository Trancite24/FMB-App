function goContact(){
    window.plugins.nativepagetransitions.flip({
        "href" : "contact.html"
    });
}

function goHome(){
    window.plugins.nativepagetransitions.slide({
        "href" : "home.html"
    });
}

var results = JSON.parse(localStorage.getItem("results"));
var route_name = results[2].split(":")[0];

var stations = results[1].split("--");

var timeToDestinationMins = parseInt(results[0])%60;
var timeToDestinationHours = Math.floor(parseInt(results[0])/60);

$('#timeToDestination').text("Time : "+timeToDestinationHours.toString()+" hrs "+timeToDestinationMins.toString()+" mins");
$('#from').text("Start : "+localStorage.getItem("from"));
$('#to').text("To : "+localStorage.getItem("to"));

var previousRoute = stations[1].substring(0,stations[1].indexOf("->"));

$('#exchange_stations').append(
    '<div class="contact">'+
        '<div class="dot z-depth-1"></div>'+
            '<p> <div class=" btn secondary-color">'+'138'+'</div></p>'+
            '<p>'+route_name+'</p>'+
        '<span> Get down from Nugegoda</span>'+
    '</div>'
)

for(var stationIndex=1; stationIndex<stations.length; stationIndex++){
    var station = stations[stationIndex].substring(0,stations[1].indexOf("->"));
    if(previousRoute!=station){

    }
}