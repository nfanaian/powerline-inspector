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
var token = readToken();
console.log(token);
var markers;

$.post(
  url,
  {
    //token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGVzdCIsInJlcXVlc3QiOnsicmVxdWVzdCI6ImFwaS0-YXV0aC0-bG9naW4tPnRlc3QtPjVmNGRjYzNiNWFhNzY1ZDYxZDgzMjdkZWI4ODJjZjk5LT4iLCJ0aW1lIjoiMDg6MDE6MDMgUE0iLCJkYXRlIjoiMTAtMjMtMjAxNyJ9LCJjbGllbnRJUCI6eyJpcCI6IjczLjI0Ljk5LjUxIiwiaG9zdG5hbWUiOiJjLTczLTI0LTk5LTUxLmhzZDEuZmwuY29tY2FzdC5uZXQiLCJjaXR5IjoiS2lzc2ltbWVlIiwicmVnaW9uIjoiRmxvcmlkYSIsImNvdW50cnkiOiJVUyIsImxvYyI6IjI4LjMyNjAsLTgxLjM1MTMiLCJvcmciOiJBUzc5MjIgQ29tY2FzdCBDYWJsZSBDb21tdW5pY2F0aW9ucywgTExDIiwicG9zdGFsIjoiMzQ3NDMifX0.LNcIO5MKP5hPUtoy17Ccwren3cbMI6wMeagWa2Ssyp8"
      token: token
  },
  function(data) {
    console.log(data);
    markers = data.markers;
    console.log(markers);
	 initMap();
  }
);

//console.log(markers);