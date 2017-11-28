
    function createStatus(powerline,powerpole,overgrowth,oversag){
     var status = "purple";
      if((powerline == 1 && powerpole == 1) || (powerline == 0 && powerpole == 1)){
        status = "green";
      }
      if((powerline == 1 && powerpole == 0)){
        status = "yellow";
      }
      if(overgrowth == 1){
        status = "red";
      }
      if((oversag == 1 && overgrowth == 1)||(oversag == 1)){
        status = "orange";
      }
          return status;
    }

    // Used to create single marker object
    function addMarker(map, powerline, powerpole, overgrowth, oversag, latitude, longitude, comment, url,timeAdded){
     
      // checks to see if comment was entered.
      /*if(comment == null){
        comment = "";
      }*/
      var status = createStatus(powerline,powerpole,overgrowth,oversag);
      var justDate = timeAdded.split(" ");
      var date = justDate[0].split("-");

      //console.log(date);
    
      // creates google map location from lat and long
      var location = new google.maps.LatLng(latitude,longitude);

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
      date: justDate[0],
      year: date[0],
      month: date[1],
      day: date[2],
      timeFiltered:false,
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
        infoPanelChange(marker.powerline, marker.powerpole, marker.overgrowth, marker.oversag, marker.latitude, marker.longitude, marker.locationComment, marker.date)
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
     
}
function pictureChange(url)
{
//document.getElementById("myImg").src="http://107.170.23.85/api/marker/getimage/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGVzdCIsInJlcXVlc3QiOnsicmVxdWVzdCI6ImFwaS0-YXV0aC0-bG9naW4tPnRlc3QtPjVmNGRjYzNiNWFhNzY1ZDYxZDgzMjdkZWI4ODJjZjk5LT4iLCJ0aW1lIjoiMDg6MDE6MDMgUE0iLCJkYXRlIjoiMTAtMjMtMjAxNyJ9LCJjbGllbnRJUCI6eyJpcCI6IjczLjI0Ljk5LjUxIiwiaG9zdG5hbWUiOiJjLTczLTI0LTk5LTUxLmhzZDEuZmwuY29tY2FzdC5uZXQiLCJjaXR5IjoiS2lzc2ltbWVlIiwicmVnaW9uIjoiRmxvcmlkYSIsImNvdW50cnkiOiJVUyIsImxvYyI6IjI4LjMyNjAsLTgxLjM1MTMiLCJvcmciOiJBUzc5MjIgQ29tY2FzdCBDYWJsZSBDb21tdW5pY2F0aW9ucywgTExDIiwicG9zdGFsIjoiMzQ3NDMifX0.LNcIO5MKP5hPUtoy17Ccwren3cbMI6wMeagWa2Ssyp8/"+ url +"/";
  document.getElementById("myImg").src="http://squibotics.com/api/marker/getimage/"+ token + "/"+ url +"/";
}

function infoPanelChange(powerline, powerpole, overgrowth, oversag, Latitude, Longitude, comment, timeAdded)
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
  document.getElementById('prevCommentArea').value = comment;
  document.getElementById('commentArea').value="";
  document.getElementById('time').innerHTML = timeAdded;
  console.log("Comment is " + comment);

}
    //google.maps.event.addDomListener(window, 'load', initialize);