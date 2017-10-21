function loadMap() {
    var mapProp = {
        // Center of UCF - DEMO
        center: new google.maps.LatLng(28.602427, -81.200060),
        zoom: 14,
        styles: [
            //Bussiness off (1 google search, 1st link, jorge lied and didn't even try)
            {
                featureType: "poi",
                stylers: [
                    {visibility: "off"}
                ]
            }
        ]
    };

    var map = new google.maps.Map(document.getElementById("map"), mapProp);


    /*
    // AJAX REQUEST for /getimage/ JSON debug (it is set to @readfile() now)
    var root = "http://107.170.23.85/api/marker/";
    var key = "WTF";
    var func = "getimage";

    // Get filename from hidden label
    var filename = document.getElementById("filename").getAttribute("value").toString();

    // AJAX POST REQUEST
    var url = root + func + "/" + filename + "/";

    $.post(
        url,
        {
            token: key
        },
        function (data) {
            console.log(data);
        }
    ); */

    /* AJAX REQUEST
     * After loading Google Maps, make AJAX request for
     * All Markers and load on map
     */
    var root = "http://107.170.23.85/api/marker/";
    var key = "LETSGO";
    var func = "getall";

    // Get filename from hidden label
    var filename = document.getElementById("filename").getAttribute("value").toString();

    // AJAX POST REQUEST
    var url = root + func + "/";

    $.post(
        url,
        {
            token: key
        },
        function(data){
            console.log(data);


            var markerData = data.markers;
            //map.setCenter(markUsr.position);
            var markers = [];
            for (var i = 0; i < 400; i++) { //markerData.length
                var pos = new google.maps.LatLng(markerData[i].latitude, markerData[i].longitude);

                markers[i] = new google.maps.Marker({
                    position: pos,
                    map: map,
                    icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',//"http://107.170.23.85/red-dot.png"//'images/locred.png',
                    filename: markerData[i].filename,
                    powerline: markerData[i].powerline,
                    powerpole: markerData[i].powerpole,
                    overgrowth: markerData[i].overgrowth,
                    oversag: markerData[i].oversag,
                    latitude: markerData[i].latitude,
                    longitude: markerData[i].longitude,
                    lastModified: markerData[i].lastModified,
                    id: i
                });
/*
                var infowindow = new google.maps.InfoWindow({
                    content: markerData[i].filename
                });

                infowindow.open(map, markers[i]);
 */

                // EVENT LISTENER: Marker.OnClick()
                // Here we define the function that is called upon clicking a marker
                google.maps.event.addListener(markers[i], 'click', function () {
                    // Log Click (debugging)
                    console.log(markers[this.id]);

                    // API GET IMAGE BUILDER
                    var filename = markers[this.id].filename;
                    var url = "http://107.170.23.85/api/marker/getimage/API_KEY/" + filename + "/";

                    // Set Image and Booleans
                    document.getElementById("utilityImage").setAttribute("src", url);

                    document.getElementById("powerline").checked = markers[this.id].powerline;
                    document.getElementById("powerpole").checked = markers[this.id].powerpole;
                    document.getElementById("overgrowth").checked = markers[this.id].overgrowth;
                    document.getElementById("oversag").checked = markers[this.id].oversag;
                    document.getElementById("latitude").innerHTML = markers[this.id].latitude
                    document.getElementById("longitude").innerHTML = markers[this.id].longitude;
                    document.getElementById("button").disabled = false;
                    document.getElementById("button").setAttribute("value", "Update Record");

                    // MOBILE ONLY: Scroll Page to Image upon clicking marker
                    if (typeof window.orientation !== 'undefined')
                    {
                        document.getElementById('box').scrollIntoView({
                            block: "start",
                            behavior: "smooth"
                        });
                    }
                });
            }
        }
    );
}

function enableButton() {
    document.getElementById("button").disabled = false;
    document.getElementById("button").setAttribute("value", "Update Record");
}
function updateMarker()
{
    var func = "updatemarker";

    // Get filename from hidden label
    var filename = document.getElementById("filename").getAttribute("value").toString();

    var params = filename + "/";

    var val = ['0/','0/','0/','0/'];

    if (document.getElementById("powerline").checked) {
        val[0] = '1/';
    }

    if (document.getElementById("powerpole").checked) {
        val[1] = '1/';
    }

    if (document.getElementById("overgrowth").checked) {
        val[2] = '1/';
    }

    if (document.getElementById("oversag").checked) {
        val[3] = '1/';
    }

    params += val[0] + val[1] + val[2] + val[3];

    var root = "http://107.170.23.85/api/marker/";
    var key = "API_TOKEN_KEY_GOES_HERE";

    // AJAX POST REQUEST
    var url = root + func + "/" + params;
    $.post(
        url,
        {
            token: key
        },
        function(data){
            console.log(data);
            // CHANGE BUTTON COLOR
            // SUCCESS
            document.getElementById("button").disabled = true;
            document.getElementById("button").setAttribute("value", "Updated Successfully");
        }
    );
}