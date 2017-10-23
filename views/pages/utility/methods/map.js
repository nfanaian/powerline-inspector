/** map
 * Javascript file used by /utility/mapViewer/
 */

/* GLOBALS */
var selectedMarker;
var markers = [];
var map;

/* Load Google Maps
 *
 */
function loadMap() {
    var mapProp = {
        // Center of UCF - DEMO
        center: new google.maps.LatLng(28.602427, -81.200060),
        zoom: 14,
        styles: [
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
                //window.location.href = window.root_self;
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

        // EVENT LISTENER: Marker.OnClick()
        // Here we define the function that is called upon clicking a marker
        google.maps.event.addListener(window.markers[i], 'click', function () {
            // API GET IMAGE BUILDER
            var filename = window.markers[this.id].filename;
            var key = window.getCookie();
            var url = window.root + "api/marker/getimage/" + key + "/" + filename + "/";

            // Log Click (debugging)
            console.log("Marker Selected: " + window.markers[this.id].filename);

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
            document.getElementById("update-btn").disabled = false;
            document.getElementById("update-btn").setAttribute("value", "Update Record");

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
    document.getElementById("update-btn").disabled = false;
    document.getElementById("update-btn").setAttribute("value", "Update Record");
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
            document.getElementById("update-btn").disabled = true;
            document.getElementById("update-btn").setAttribute("value", "Updated Successfully");
        }
    );
}

/* Image Full Screen */
function imageClick(){
    // Get the modal
    var modal = document.getElementById('myModal');
    var img = document.getElementById("utilityImage");
    var modalImg = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImg.src = img.src;
}

// When the user clicks on <span> (x), close the modal
function closeClick() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none";
}