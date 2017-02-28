/**
 * Created by ASUS-PC on 2/28/2017.
 */

function onload_transit(){
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