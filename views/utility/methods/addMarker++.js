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
    function createStatus(powerline,powerpole,overgrowth,oversag){
      var status = "yellow";
      // creates "Status" based on received data
      if((powerline == 1)&&(powerpole == 1)){
        if((overgrowth == 1)||(oversag == 1)){
          status = "red";
        }else{
          status = "green"
        }

      }
          return status;
    }

    // Used to create single marker object
    function addMarker(map, powerline, powerpole, overgrowth, oversag, latitude, longitude, comment, url){
     
      // checks to see if comment was entered.
      /*if(comment == null){
        comment = "";
      }*/
      var status = createStatus(powerline,powerpole,overgrowth,oversag);
    /*
      var status = "yellow";
      // creates "Status" based on received data
      if((powerline == 1)&&(powerpole == 1)){
        if((overgrowth == 1)||(oversag == 1)){
          status = "red";
        }else{
          status = "green"
        }

      }
    */

      // creates google map location from lat and long
      var location = new google.maps.LatLng(longitude,latitude);

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
      locationComment: comment,
      powerline: powerline,
      powerpole: powerpole,
      overgrowth: overgrowth,
      oversag: oversag,
      latitude: latitude,
      longitude: longitude,
      url: url,      
      index: 0,
      status: status,
      changed1: 0,      
      });


      google.maps.event.addListener(marker, 'click', function(){
        //document.getElementById('box').innerHTML = marker.index;
        console.log(marker.url);
        pictureChange(marker.url);
        infoPanelChange(marker.powerline, marker.powerpole, marker.overgrowth, marker.oversag, marker.latitude, marker.longitude, marker.locationComment)
        if (selected == 0) {originalIcon = marker.getIcon();
        marker.setIcon(blueimage);
        selected = 1;
        selMarker = marker;
        } else {
          //console.log(selMarker);
          selMarker.setIcon(originalIcon); 
          originalIcon = marker.getIcon();
          marker.setIcon(blueimage);
          selMarker = marker;
        }
      });
      marker.index = markerArray.length;
      var place = markerArray.push(marker);
      /*// checks points status and sends it to correct array with correct index number
      if (status == 'green'){
        marker.index = greenArray.length;
        var place = greenArray.push(marker);
      } else if(status == 'yellow'){
        marker.index = yellowArray.length;
        var place = yellowArray.push(marker);
      }else{
        marker.index = redArray.length;
        var place = redArray.push(marker);
      }
      */
}
function pictureChange(url)
{
//document.getElementById("myImg").src="http://107.170.23.85/api/marker/getimage/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGVzdCIsInJlcXVlc3QiOnsicmVxdWVzdCI6ImFwaS0-YXV0aC0-bG9naW4tPnRlc3QtPjVmNGRjYzNiNWFhNzY1ZDYxZDgzMjdkZWI4ODJjZjk5LT4iLCJ0aW1lIjoiMDg6MDE6MDMgUE0iLCJkYXRlIjoiMTAtMjMtMjAxNyJ9LCJjbGllbnRJUCI6eyJpcCI6IjczLjI0Ljk5LjUxIiwiaG9zdG5hbWUiOiJjLTczLTI0LTk5LTUxLmhzZDEuZmwuY29tY2FzdC5uZXQiLCJjaXR5IjoiS2lzc2ltbWVlIiwicmVnaW9uIjoiRmxvcmlkYSIsImNvdW50cnkiOiJVUyIsImxvYyI6IjI4LjMyNjAsLTgxLjM1MTMiLCJvcmciOiJBUzc5MjIgQ29tY2FzdCBDYWJsZSBDb21tdW5pY2F0aW9ucywgTExDIiwicG9zdGFsIjoiMzQ3NDMifX0.LNcIO5MKP5hPUtoy17Ccwren3cbMI6wMeagWa2Ssyp8/"+ url +"/";
  document.getElementById("myImg").src="http://107.170.23.85/api/marker/getimage/"+ token + "/"+ url +"/";
}

function infoPanelChange(powerline, powerpole, overgrowth, oversag, Latitude, Longitude, comment)
{ 
  
  if(powerline == 1){
    document.getElementById("powerline").checked = true;
  } else {
    document.getElementById("powerline").checked = false;
  }
  if(powerpole == 1){
    document.getElementById("powerpole").checked = true;
  } else {
    document.getElementById("powerpole").checked = false;
  }
  if(overgrowth == 1){
    document.getElementById("overgrowth").checked = true;
  } else {
    document.getElementById("overgrowth").checked = false;
  }
  if(oversag == 1){
    document.getElementById("oversag").checked = true;
  } else {
    document.getElementById("oversag").checked = false;
  }


  document.getElementById('Latitude').innerHTML = Latitude;
  document.getElementById('Longitude').innerHTML = Longitude;
  document.getElementById('commentArea').value = comment;
  console.log("Comment is " + comment);

}
    //google.maps.event.addDomListener(window, 'load', initialize);