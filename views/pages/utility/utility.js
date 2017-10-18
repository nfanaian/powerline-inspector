var root = 'http://107.170.23.85/';
var income;
$.ajax({
    url: root + 'API/Marker/getAll/',
    method: 'GET'
}).then(function(data) {
    console.log(data);
});







//var infowindow;
// keeps track of current marker selected
var selMarker;
// keeps track of current markers original color
var originalIcon;
//var map;
// keeps track of whether a marker is selected or not
var selected = 0;
//var path = https:'//roads.googleapis.com/v1/snapToRoads?path=-35.27801,149.12958|-35.28032,149.12907|-35.28099,149.12929|-35.28144,149.12984|-35.28194,149.13003|-35.28282,149.12956|-35.28302,149.12881|-35.28473,149.12836&interpolate=true&key=AIzaSyAdB8aLpUldzTnezuHqo8T0_YKSa2vIS';
// marker images
var greenimage ='http://maps.google.com/mapfiles/ms/icons/green-dot.png';
var yellowimage ='http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
var redimage ='http://maps.google.com/mapfiles/ms/icons/red-dot.png';
var blueimage = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';

/*
 var greenimage1 = {
 path: google.maps.SymbolPath.CIRCLE,
 fillOpacity: 1,
 fillColor: 'green',
 strokeWeight: 3.0,
 scale: 7 //pixels
 };
 */

// shape of clickable area on markers
var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
};
// marker arrays
var redArray = [];
var yellowArray = [];
var greenArray = [];







// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// Filter Event Listeners
var Gcheckbox = document.querySelector("input[id=poi-Green]");
Gcheckbox.checked = true;
Gcheckbox.addEventListener( 'change', function() {
    if(this.checked) {
        for(var x in greenArray){
            greenArray[x].setVisible(true);
        }
    } else {
        for(var x in greenArray){
            greenArray[x].setVisible(false);
        }
    }
});

var Ycheckbox = document.querySelector("input[id=poi-Yellow]");
Ycheckbox.checked = true;
Ycheckbox.addEventListener( 'change', function() {
    if(this.checked) {
        for(var x in yellowArray){
            yellowArray[x].setVisible(true);
        }
    } else {
        for(var x in yellowArray){
            yellowArray[x].setVisible(false);
        }
    }
});

var Rcheckbox = document.querySelector("input[id=poi-Red]");
Rcheckbox.checked = true;
Rcheckbox.addEventListener( 'change', function() {
    if(this.checked) {
        for(var x in redArray){
            redArray[x].setVisible(true);
        }
    } else {
        for(var x in redArray){
            redArray[x].setVisible(false);
        }
    }
});
// End of Filter Event Listeners


// creates map
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: {lat: 37.423901, lng: -122.091497},
        // provides styling for map
        styles: [
            {
                featureType: "poi",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
                featureType: 'administrative.locality',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
            },
            {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{color: '#263c3f'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#6b9a76'}]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#38414e'}]
            },
            {
                featureType: 'road',
                elementType: 'geometry.stroke',
                stylers: [{color: '#212a37'}]
            },
            {
                featureType: 'road',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9ca5b3'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#746855'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{color: '#1f2835'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'labels.text.fill',
                stylers: [{color: '#f3d19c'}]
            },
            {
                featureType: 'transit',
                elementType: 'geometry',
                stylers: [{color: '#2f3948'}]
            },
            {
                featureType: 'transit.station',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
            },
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{color: '#17263c'}]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#515c6d'}]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#17263c'}]
            }
        ]
    });


// used for testing, makes points
    /*for(var i = 0; i < 500; i += 0.1) {
     latlng = {lat: -25.363 + i, lng: 131.044 + i};
     addFakeMarker(map, latlng, greenimage, greenArray);
     }
     // used for testing, makes points
     for(var i = 0; i < 500; i += 0.1) {
     latlng = {lat: -15.363 + i, lng: 131.044 + i};

     addFakeMarker(map, latlng, yellowimage, yellowArray);
     }
     */

// used to add from points array
    for(var x in points) {
        var point = points[x];
        var location = new google.maps.LatLng(point.lat,point.lng);
        addMarker(map, point.violation, location, point.status, point.url);
    }

// used to add from var array
//for(var x in yellows) {
//  var point = yellows[x];
//  var location = new google.maps.LatLng(point.lat,point.lng);  
//  addMarker(map, point.violation, location, yellowimage);
//  }
    // on click of map, revert previously selected marker to original color, deselect marker.
    google.maps.event.addListener(map, 'click', function(){
        if (selected == 1){
            document.getElementById("myImg").src="http://31.media.tumblr.com/18b5f8f0a00ad01e50f7ae2f513be52d/tumblr_msqcl4iwM01soh1p8o1_500.png";
            selMarker.setIcon(originalIcon);
            selected = 0;
            selMarker = null;
            originalIcon = null;
        }

    });


    /*  // used to test marker array objects, sets markers to be invisible
     google.maps.event.addListener(filter-group, 'rightclick', function(){
     for(var x in yellowArray){
     yellowArray[x].setVisible(false);
     }
     });
     */

}



// used for the multiple marker testing
/*    function addFakeMarker(map, location, image, array){
 var marker = new google.maps.Marker({
 position: location,
 //animation: google.maps.Animation.DROP,
 map: map,
 //icon: {
 //path: google.maps.SymbolPath.CIRCLE,
 //scale: 5
 //},
 icon: image,
 shape: shape,
 });

 google.maps.event.addListener(marker, 'click', function(){
 //document.getElementById('box').innerHTML = violation;
 if (selected == 0) {originalIcon = marker.getIcon();
 marker.setIcon(blueimage);
 selected = 1;
 selMarker = marker;
 } else {
 selMarker.setIcon(originalIcon);
 originalIcon = marker.getIcon();
 marker.setIcon(blueimage);
 selMarker = marker;
 }

 });

 array.push(marker);
 }
 */

/*
 function show_image() {
 var img = document.createElement("img");
 img.src = blueimage;
 img.width = 276;
 img.height = 110;
 img.alt = greenimage;

 // This next line will just add it to the <body> tag
 document.getElementById('box').innerHTML = img;
 //document.body.appendChild(img);
 }
 */

// Used for single marker
function addMarker(map, violation, location, status, url){

    var marker = new google.maps.Marker({
        position: location,
        //animation: google.maps.Animation.DROP,
        map: map,
        //icon: {
        //path: google.maps.SymbolPath.CIRCLE,
        //scale: 5
        //},
        icon: 'http://maps.google.com/mapfiles/ms/icons/' + status + '-dot.png',
        //shape: shape,
        //icon: greenimage,
        url: url,
        index: 0,
    });

    google.maps.event.addListener(marker, 'click', function(){
        //document.getElementById('box').innerHTML = marker.index;
        pictureChange(marker.url);
        if (selected == 0) {originalIcon = marker.getIcon();
            marker.setIcon(blueimage);
            selected = 1;
            selMarker = marker;
        } else {
            selMarker.setIcon(originalIcon);
            originalIcon = marker.getIcon();
            marker.setIcon(blueimage);
            selMarker = marker;
        }
    });

    // checks points status and sends it to correct array with correct index number
    if (status == 'green'){
        marker.index = greenArray.length;
        var place =greenArray.push(marker);
    } else if(status == 'yellow'){
        marker.index = yellowArray.length;
        var place = yellowArray.push(marker);
    }else{
        marker.index = redArray.length;
        var place = redArray.push(marker);
    }

    /*    google.maps.event.addListener(marker, 'click', function(){
     if (typeof infowindow != 'undefined') infowindow.close();
     infowindow = new google.maps.InfoWindow({
     content: name
     });
     infowindow.open(map, marker);
     });
     */
//      var infowindow = new google.maps.InfoWindow({
//      content: name
//      });

//      google.maps.event.addListener(marker, 'click', function(){
//        infowindow.open(map,marker);
//        });

    function pictureChange(url)
    {
        document.getElementById("myImg").src=url;
    }

}


google.maps.event.addDomListener(window, 'load', initialize);