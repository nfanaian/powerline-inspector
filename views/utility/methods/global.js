// keeps track of users token
var token;
// keeps track of current marker selected
var selMarker;
// keeps track of current markers original color
var originalIcon;
//var map;
// keeps track of whether a marker is selected or not
var selected = 0;

// Testing of snapToRoads feature (Not implemented yet)
//var path = https:'//roads.googleapis.com/v1/snapToRoads?path=-35.27801,149.12958|-35.28032,149.12907|-35.28099,149.12929|-35.28144,149.12984|-35.28194,149.13003|-35.28282,149.12956|-35.28302,149.12881|-35.28473,149.12836&interpolate=true&key=AIzaSyAdB8aLpUldzTnezuHqo8T0_YKSa2vIS';

// marker images
var greenimage ='http://maps.google.com/mapfiles/ms/icons/green-dot.png';
var yellowimage ='http://maps.google.com/mapfiles/ms/icons/yellow-dot.png';
var redimage ='http://maps.google.com/mapfiles/ms/icons/red-dot.png';
var blueimage = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
// shape of clickable area on markers
var shape = {
    coords: [1, 1, 1, 20, 18, 20, 18, 1],
    type: 'poly'
  };
// marker arrays
var redArray = [];
var yellowArray = [];
var greenArray = [];
var markerArray = [];

var redPointer = 0;
var yellowPointer = 0;
var greenPointer = 0;

// Values of current Marker(used for update call)
var currentPowerline;
var currentPowerpole;
var currentOvergrowth;
var currentOversag;

var maxZoom = 11;

// Get All AJAX Call
//var root = 'http://107.170.23.85/';
var root = 'http://squibotics.com/';
var url = root + 'API/Marker/getAll/'
token = readToken();
console.log(token);
var markers;

$.post(
  url,
  {
      token: token
  },
  function(data) {
    if(data.success == true)
    {
        console.log(data);
        markers = data.markers;
        console.log(markers);
        initMap();
    }
  }
);

//console.log(markers);