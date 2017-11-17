/** map
 * Javascript file used by /utility/mapViewer/
 */

/* GLOBALS */
var selectedMarker = null;
var markers = [];
var map;
// Center of UCF - DEMO
var init_lat = 28.602427;
var init_long = -81.200060;

// Filters
var Gcheckbox = document.getElementById("poi-Green");
var Ycheckbox = document.getElementById("poi-Yellow");
var Rcheckbox = document.getElementById("poi-Red");


/* Load Google Maps
 *
 */
function loadMap()
{
    var stylez = window.getStyle();
    var mapProp = {
        center: new google.maps.LatLng(window.init_lat, window.init_long),
        zoom: 15,
        styles: stylez
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
                window.markersVisibility(true);
            } else {
                //window.location.href = window.root_self;
            }
        }
    );
}

function addMarkers(data)
{
    for (var i = 0; i < data.length; i++)
    {
        var pos = new google.maps.LatLng(data[i].latitude, data[i].longitude);

        var status = "blue"; // Non-Utility Image
        if ((data[i].powerline == true) || (data[i].powerpole == true))
        {
            status = "yellow"; // Category-1 Powerline

            if (data[i].overgrowth == true)
                status = "green";

            if (data[i].oversag == true)
                status = "red";
        }

        window.markers[i] = new google.maps.Marker({
            position: pos,
            map: window.map,
            icon: "http://maps.google.com/mapfiles/ms/icons/" + status + "-dot.png",
            status: status,
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
            // Enable checkboxes
            document.getElementById("powerline").disabled = false;
            document.getElementById("powerpole").disabled = false;
            document.getElementById("overgrowth").disabled = false;
            document.getElementById("oversag").disabled = false;

            // API GET IMAGE BUILDER
            var filename = window.markers[this.id].filename;
            var key = window.getCookie();
            var url = window.root + "api/marker/getimage/" + key + "/" + filename + "/";

            // Log Click (debugging)
            console.log("Marker Selected: " + window.markers[this.id].filename);

            // Update selected marker
            window.setSelectedMarker(window.markers[this.id]);

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
                $('html, body').animate({
                    scrollTop: $("#utilityImage").offset().top
                }, 1000);
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

function setSelectedMarker(marker)
{
    // Revert previous marker to original color
    if (window.selectedMarker != null)
    {
        window.selectedMarker.setVisible(false);
        var status = window.selectedMarker.status;
        window.selectedMarker.icon = "http://maps.google.com/mapfiles/ms/icons/" + status + "-dot.png";
        window.selectedMarker.setVisible(true);
    }
    window.selectedMarker = marker;
    window.selectedMarker.setVisible(false);
    window.selectedMarker.icon = "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
    window.selectedMarker.setVisible(true);
}