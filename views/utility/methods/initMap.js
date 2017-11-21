// creates map
function initMap() {

	console.log(markers);
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: {lat: 28.6024, lng: -81.2001},
   // provides styling for map
    /*styles: [
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
          */
  });

      var ctaLayer = new google.maps.KmlLayer({
          url: 'bufferedRoads_CopyFeatures1_.kmz',
          map: map
        }); 

// used to add from points array to map
for(var x in markers) {
  // Will delete when comments are enabled in Database.
  //console.log(markers[x]);
  var testComment = "";
  addMarker(map, markers[x].powerline, markers[x].powerpole, markers[x].overgrowth, markers[x].oversag, markers[x].latitude, markers[x].longitude,markers[x].comment, markers[x].filename, markers[x].timeAdded); 
  
  }

    // on click of map, revert previously selected marker to original color, deselect marker.
    console.log(selected);
    google.maps.event.addListener(map, 'click', function(){
        console.log(selMarker);
          if (selected == 1){
            document.getElementById('commentArea').placeholder= "Enter notes about the current location.";
            document.getElementById('commentArea').value="";
            document.getElementById("myImg").src="images/awaitingImage.jpg";
            document.getElementById("powerline").checked = false;
            document.getElementById("powerpole").checked = false;
            document.getElementById("overgrowth").checked = false;
            document.getElementById("oversag").checked = false;
            document.getElementById('Latitude').innerHTML = '';
            document.getElementById('Longitude').innerHTML = '';
            document.getElementById('time').innerHTML = '';
            selMarker.setIcon(originalIcon); 
            //selMarker.icon = originalIcon;
            selected = 0;
            selMarker = null;
            originalIcon = null;
          }
          if(selected == 0){
            console.log(markerArray);
          }
    });


    google.maps.event.addListener(map, 'zoom_changed', function() {
      zoomLevel = map.getZoom();
      if (zoomLevel < maxZoom) {
          //set markers to invisible
          //forloop to set each markers .setMap(null)
          for(var x in markerArray){
            markerArray[x].setMap(null);
          }
      } else if(zoomLevel >= maxZoom) {
          //Set Markers visible
          //forloop to set each markers .setMap(map)
          for(var x in markerArray){
            markerArray[x].setMap(map);
          }
      }
    });


    //adds eventListener to Update button
    document.getElementById("button").addEventListener("click", update);

        // Uses updated values to "update marker"
        function update()
        { console.log("Starting Update");

          if(selected == 0){
          return;
          }
          
          markerArray[selMarker.index].changed1 = 1;
          
        /*// set original marker to invisible
          if(selMarker.status == "green"){
            greenArray[selMarker.index].changed1 = 1;
            greenArray[selMarker.index].setVisible(false);
          }
          if(selMarker.status == "yellow"){
            yellowArray[selMarker.index].changed1 = 1
            yellowArray[selMarker.index].setVisible(false);
          }
          if(selMarker.status == "red"){
            redArray[selMarker.index].changed1 = 1
            redArray[selMarker.index].setVisible(false);
          }
        */
          // update new marker with
          if(document.getElementById('powerline').checked){
            selMarker.powerline = 1;
          } else {
            selMarker.powerline = 0;
          }
          if(document.getElementById('powerpole').checked){
            selMarker.powerpole = 1;
          } else {
            selMarker.powerpole = 0;
          }
          if(document.getElementById('overgrowth').checked){
            selMarker.overgrowth = 1;
          } else {
            selMarker.overgrowth = 0;
          }
          if(document.getElementById('oversag').checked){
            selMarker.oversag = 1;
          } else {
            selMarker.oversag = 0;
          }

          var newStatus = createStatus(selMarker.powerline,selMarker.powerpole,selMarker.overgrowth,selMarker.oversag);

          // Edited to affect single array instead of multiple arrays
          markerArray[selMarker.index].powerline = selMarker.powerline;
          markerArray[selMarker.index].powerpole = selMarker.powerpole;
          markerArray[selMarker.index].overgrowth = selMarker.overgrowth;
          markerArray[selMarker.index].oversag = selMarker.oversag;
          markerArray[selMarker.index].locationComment = document.getElementById("commentArea").value;
          markerArray[selMarker.index].status = newStatus;
          markerArray[selMarker.index].icon = 'http://maps.google.com/mapfiles/ms/icons/' + newStatus + '-dot.png';
          markerArray[selMarker.index].setIcon(markerArray[selMarker.index].icon);
          

          //selMarker.locationComment = document.getElementById("commentArea").value;
          //addMarker(map, selMarker.powerline, selMarker.powerpole, selMarker.overgrowth, selMarker.oversag, selMarker.latitude, selMarker.longitude, selMarker.locationComment, selMarker.url);
          
          // Need to add updatedComment to AJAX call when database and call updated              
          var updatedComment = selMarker.locationComment;
          var filename = selMarker.url;
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


          var root = "http://squibotics.com/api/marker/";
          var key = "API_TOKEN_KEY_GOES_HERE";
          var func = "updatemarker";
          
          // AJAX POST REQUEST
          var url = root + func + "/" + params;
          $.post(
              url,
              {
                 // token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGVzdCIsInJlcXVlc3QiOnsicmVxdWVzdCI6ImFwaS0-YXV0aC0-bG9naW4tPnRlc3QtPjVmNGRjYzNiNWFhNzY1ZDYxZDgzMjdkZWI4ODJjZjk5LT4iLCJ0aW1lIjoiMDg6MDE6MDMgUE0iLCJkYXRlIjoiMTAtMjMtMjAxNyJ9LCJjbGllbnRJUCI6eyJpcCI6IjczLjI0Ljk5LjUxIiwiaG9zdG5hbWUiOiJjLTczLTI0LTk5LTUxLmhzZDEuZmwuY29tY2FzdC5uZXQiLCJjaXR5IjoiS2lzc2ltbWVlIiwicmVnaW9uIjoiRmxvcmlkYSIsImNvdW50cnkiOiJVUyIsImxvYyI6IjI4LjMyNjAsLTgxLjM1MTMiLCJvcmciOiJBUzc5MjIgQ29tY2FzdCBDYWJsZSBDb21tdW5pY2F0aW9ucywgTExDIiwicG9zdGFsIjoiMzQ3NDMifX0.LNcIO5MKP5hPUtoy17Ccwren3cbMI6wMeagWa2Ssyp8"
                    token: token
              },
              function(data){
                  //console.log(data);
                  //console.log("Finished Updating");
                  if(data.success == true){
                  alert("Marker was successfully updated");
                  console.log("Update complete");
                  } else {
                    console.log(data);
                    alert("Marker was not updated to database!");
                    console.log("Update Incomplete");
                  }
                  // need to add logic to actually check above
              }
          );
          
          // This code resets global variables after marker update (resets picture viewer)
            document.getElementById('commentArea').value= "";
            document.getElementById("myImg").src="images/awaitingImage.jpg";
            document.getElementById("powerline").checked = false;
            document.getElementById("powerpole").checked = false;
            document.getElementById("overgrowth").checked = false;
            document.getElementById("oversag").checked = false;
            document.getElementById('Latitude').innerHTML = '';
            document.getElementById('Longitude').innerHTML = '';
            //selMarker.setIcon(originalIcon);  I dont think its needed...
            selected = 0;
            selMarker = null;
            originalIcon = null;
            //alert("Marker was successfully updated"); //remove once AJAX Call is working
        }
  
}