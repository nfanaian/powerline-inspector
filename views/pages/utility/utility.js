/** Utility
 * Javascript file used by /utility/mapViewer/
 */


// ** GLOBAL VARIABLES
//var root = "http://107.170.23.85/";
var root = window.location.href.split("/")[0] + "//" + window.location.href.split("/")[2] + "/";
console.log(root);
var selectedMarker;
var markers = [];
var map;



function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

//window.onload = authenticateUser();
/** Disabling line above, better done server-side instead
 * this way the server will check for jwt cookie
 * and authenticate the jwt
 * before serving any HTML/JavaScript to begin with
 */

/* Authenticates user
 * Upon failure of authentication
 * User is redirected to login screen
 * (this function is called when the window loads => window.onload = authenticateUser();
 */
function authenticateUser()
{
    var we_good = false;

    var apiController = "api/auth/";
    var func = "authpage";

    var key = window.getCookie('token');


    // AJAX POST REQUEST
    var url = window.root + apiController + func + "/";

    console.log("authenticating..");
    $.post(
        url,
        {
            token: key
        },
        function(data){
            if (data.success == true)
            {
                // User Authenticated
                we_good = true;
                console.log(data);
            } else {
                window.location.href = window.root;
            }
        }
    );
}

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

    window.map = new google.maps.Map(document.getElementById("map"), mapProp);

    window.initMarkers();
}

function initMarkers()
{
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

    var apiController = "api/marker/";
    var key = window.getCookie('token');
    var func = "getall";


    // AJAX POST REQUEST
    var url = window.root + apiController + func + "/";

    $.post(
        url,
        {
            token: key
        },
        function(data){
            if (data.success == true)
            {
                console.log(data);
                window.addMarkers(data.markers);
            } else {
                //window.location.href = window.root;
            }
        }
    );
}

function addMarkers(data)
{
    for (var i = 0; i < 400; i++) { //data.length
        var pos = new google.maps.LatLng(data[i].latitude, data[i].longitude);

        window.markers[i] = new google.maps.Marker({
            position: pos,
            map: window.map,
            icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png',//"http://107.170.23.85/red-dot.png"//'images/locred.png',
            filename: data[i].filename,
            powerline: data[i].powerline,
            powerpole: data[i].powerpole,
            overgrowth: data[i].overgrowth,
            oversag: data[i].oversag,
            latitude: data[i].latitude,
            longitude: data[i].longitude,
            lastModified: data[i].lastModified,
            id: i
        });
        /*
         var infowindow = new google.maps.InfoWindow({
         content: data[i].filename
         });

         infowindow.open(map, markers[i]);
         */

        // EVENT LISTENER: Marker.OnClick()
        // Here we define the function that is called upon clicking a marker
        google.maps.event.addListener(window.markers[i], 'click', function () {
            // Log Click (debugging)
            console.log("Marker Selected: " + window.markers[this.id].filename);

            // API GET IMAGE BUILDER
            var filename = window.markers[this.id].filename;
            var key = window.getCookie("token");
            var url = window.root + "api/marker/getimage/" + key + "/" + filename + "/";

            // Update selected marker
            window.selectedMarker = window.markers[this.id];

            // Set Image and Booleans
            document.getElementById("utilityImage").setAttribute("src", url);
            document.getElementById("powerline").checked = window.markers[this.id].powerline;
            document.getElementById("powerpole").checked = window.markers[this.id].powerpole;
            document.getElementById("overgrowth").checked = window.markers[this.id].overgrowth;
            document.getElementById("oversag").checked = window.markers[this.id].oversag;
            document.getElementById("latitude").innerHTML = window.markers[this.id].latitude;
            document.getElementById("longitude").innerHTML = window.markers[this.id].longitude;
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

function enableButton()
{
    document.getElementById("button").disabled = false;
    document.getElementById("button").setAttribute("value", "Update Record");
}

function updateMarker()
{
    var func = "updatemarker";

    // Get filename from hidden label
    var filename = selectedMarker.filename;

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

    var root = window.root + "api/marker/";
    var key = window.getCookie("token");

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