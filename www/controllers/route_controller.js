/**
 * Created by ASUS-PC on 2/28/2017.
 */


function onload_routes(){
    $(function () {
        var routes = [];

        jQuery.ajax({
            type: "GET",
            dataType: 'jsonp',
            url: "http://www.titansmora.org/findmybusfinal/TimeTables/getRoutes.php",
            success: function (obj, textstatus) {
                if (!('error' in obj)) {
                    $.each(obj, function (index, element) {
                        routes.push(element);
                    });
                    $("#route").autocomplete({
                        source: routes
                    });
                }
                else {
                    console.log(obj.error);
                }
            }
        });

    });
}