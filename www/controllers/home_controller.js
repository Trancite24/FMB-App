function goContact(){
    window.plugins.nativepagetransitions.flip({
        "href" : "contact.html"
    });
}

function goResults(){
    var from  = $('#from').val();
    var to = $('#to').val();
    var date = $('#datepicker').val();
    var time = $('#time').val();

    console.log(from+" "+to+" "+date+" "+time);

    jQuery.ajax({
        type: "GET",
        dataType: 'jsonp',
        url: "http://localhost:8888/Backend/TransitPlanner/createPlan.php?start_point="+from+"&end_point="+to+"&time="+time,
        success: function (obj, textstatus) {



        }
    });


    // window.plugins.nativepagetransitions.slide({
    //     "href" : "results.html"
    // });
}


function EnterAlert(){
    navigator.notification.alert(  // message
        'Enter the start and destination. Optionally you can add the date and time as well.' +
        ' Results will be based on what you are entering for these fields.',
        null,                   // callback
        'Enter Data',            // title
        'Ok'                  // buttonName
    );
}
function SearchAlert(){
    navigator.notification.alert(  // message
        'Searching will give you the plans that you can use. ' +
        'If you only enter start and destination, all the buses which travel between them will be given as the result.',
        null,                   // callback
        'Search for results',            // title
        'Ok'                  // buttonName
    );
}

function PlanAlert(){
    navigator.notification.alert(  // message
        'We provide you with the most convenient routes that you can take to reach your destination in the least possible time. ',
        null,                   // callback
        'View the Plan',            // title
        'Ok'                  // buttonName
    );
}

function GoAlert(){
    navigator.notification.alert(  // message
        'Enter - Search - Plan and that\'s it, you are ready to go.',
        null,                   // callback
        'That\'s All',            // title
        'Ok'                  // buttonName
    );
}


function openModal() {
    document.getElementById('modal').style.display = 'block';

}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}
