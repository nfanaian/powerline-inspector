// Keeps track of markers seen
var markerPointer;
// array of markers filtered by user
var filteredMarkers;
// filteredMarkerList seperated by pages
var markerPages;
// entries per page
var entries = 10;
// Keeps track of markers viewed for table functions
var markerIndex = 0;


// Start of post
var root = 'http://107.170.23.85/';
var url = root + 'API/Marker/getAll/'
//var token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGVzdCIsInJlcXVlc3QiOnsicmVxdWVzdCI6ImFwaS0-YXV0aC0-bG9naW4tPnRlc3QtPjVmNGRjYzNiNWFhNzY1ZDYxZDgzMjdkZWI4ODJjZjk5LT4iLCJ0aW1lIjoiMDg6MDE6MDMgUE0iLCJkYXRlIjoiMTAtMjMtMjAxNyJ9LCJjbGllbnRJUCI6eyJpcCI6IjczLjI0Ljk5LjUxIiwiaG9zdG5hbWUiOiJjLTczLTI0LTk5LTUxLmhzZDEuZmwuY29tY2FzdC5uZXQiLCJjaXR5IjoiS2lzc2ltbWVlIiwicmVnaW9uIjoiRmxvcmlkYSIsImNvdW50cnkiOiJVUyIsImxvYyI6IjI4LjMyNjAsLTgxLjM1MTMiLCJvcmciOiJBUzc5MjIgQ29tY2FzdCBDYWJsZSBDb21tdW5pY2F0aW9ucywgTExDIiwicG9zdGFsIjoiMzQ3NDMifX0.LNcIO5MKP5hPUtoy17Ccwren3cbMI6wMeagWa2Ssyp8";
var token = readToken();
console.log(token);
var markers;


$.post(
  url,
  {
   	token: token
  },
  function(data) {
    console.log(data);
    markers = data.markers;
    console.log(markers);
    filteredMarkers = markers;
    sepPages(filteredMarkers);
    generateTable();
  }
);

function sepPages(filteredMarkerList){
  // marker pages
  markerPages = [];
  var currentPage=[];
  var i;
  for(i = 0; i < filteredMarkerList.length; i++){
    if(currentPage.length < entries){
      currentPage.push(filteredMarkerList[i]);
    } 
    if(currentPage.length == entries){
      markerPages.push(currentPage);
      currentPage = [];
    }
  }
  try{
      markerPages.push(currentPage);
      currentPage = [];
  }catch(err){
      console.log(err);
    }

}

function filter(){
	var powerlineFilter;
	var powerpoleFilter;
	var overgrowthFilter;
	var oversagFilter;
	var hasCommentFilter;

  if(document.getElementById("powerlineFilter").checked){
    powerlineFilter = 1;
  } else {
    powerlineFilter = 0;
  }
  if(document.getElementById("powerpoleFilter").checked){
    powerpoleFilter = 1;
  } else {
    powerpoleFilter = 0;
  }
  if(document.getElementById("overgrowthFilter").checked){
    overgrowthFilter = 1;
  } else {
    overgrowthFilter = 0;
  }
  if(document.getElementById("oversagFilter").checked){
    oversagFilter = 1;
  } else {
    oversagFilter = 0;
  }
  if(document.getElementById("hasCommentFilter").checked){
    hasCommentFilter = 1;
  } else {
    hasCommentFilter = 0;
  }

var resultsTable = document.getElementById("table");
	  for(var i = 0; i < resultsTable.rows.length;)
	{   
	   resultsTable.deleteRow(i);
	}

  filteredMarkers = [];
  for(var x in markers){
  	if(powerlineFilter == 0 || (powerlineFilter == 1 && markers[x].powerline == true) ){
  		if(powerpoleFilter == 0 || (powerpoleFilter == 1 && markers[x].powerpole == true) ){
  			if(overgrowthFilter == 0 || (overgrowthFilter == 1 && markers[x].overgrowth == true) ){
  				if(oversagFilter == 0 || (oversagFilter == 1 && markers[x].oversag == true) ){
  					// ADD COMMENT FILTER WHEN IMPLEMENTED IN GET ALL POST CALL
  					filteredMarkers.push(markers[x]);
  				}
  			}
  		}
  	}

  }
  console.log(filteredMarkers);
  console.log("Filter Complete");



}
function filterMarkers(){
	$.post(
  url,
  {
    token: token
  },
  function(data) {
    markers = data.markers;
    filter();
    markerIndex = 0;
    //filteredMarkers = markers;
    sepPages(filteredMarkers);
    generateTable();
  }
);
}

function updateMarkerRow(index)
        { console.log("Starting Update");          
        
          // update marker with new information entered by user
          if(document.getElementById("powerline"+index).checked){
            markerPages[markerIndex][index].powerline = 1;
            //filteredMarkers[index].powerline = 1;
          } else {
            markerPages[markerIndex][index].powerline = 0;
            //filteredMarkers[index].powerline = 0;
          }
          if(document.getElementById("powerpole"+index).checked){
            markerPages[markerIndex][index].powerpole = 1;
            //filteredMarkers[index].powerpole = 1;
          } else {
            markerPages[markerIndex][index].powerpole = 0;
            //filteredMarkers[index].powerpole = 0;
          }
          if(document.getElementById("overgrowth"+index).checked){
            markerPages[markerIndex][index].overgrowth = 1;
            //filteredMarkers[index].overgrowth = 1;
          } else {
            markerPages[markerIndex][index].overgrowth = 0;
            //filteredMarkers[index].overgrowth = 0;
          }
          if(document.getElementById("oversag"+index).checked){
            markerPages[markerIndex][index].oversag = 1;
            //filteredMarkers[index].oversag = 1;
          } else {
            markerPages[markerIndex][index].oversag = 0;
            //filteredMarkers[index].oversag = 0;
          }
          
          
          // NEED TO CHANGE .comment to actual column name in database
          var comment = document.getElementById("commentArea"+index).value;
          //markerPages[markerIndex][index].comment = comment;
          
          // Need to add updatedComment to AJAX call when database and call updated              
          var filename =  filteredMarkers[index].filename;
          var params = filename + "/";

          var val = ['0/','0/','0/','0/'];

          if (document.getElementById("powerline"+index).checked) {
              val[0] = '1/';
          }

          if (document.getElementById("powerpole"+index).checked) {
              val[1] = '1/';
          }

          if (document.getElementById("overgrowth"+index).checked) {
              val[2] = '1/';
          }

          if (document.getElementById("oversag"+index).checked) {
              val[3] = '1/';
          }

          params += val[0] + val[1] + val[2] + val[3];


          var root = "http://107.170.23.85/api/marker/";
          var key = "API_TOKEN_KEY_GOES_HERE";
          var func = "updatemarker";
          
          // AJAX POST REQUEST
          var url = root + func + "/" + params;
          $.post(
              url,
              {
                 token: token
              },
              function(data){
                  //console.log(data);
                  //console.log("Finished Updating");
                  if(data.success == true){
                  alert("Marker was successfully updated");
                  console.log("Update complete");
                  console.log(filteredMarkers[index]);

                  } else {
                    console.log(data);
                    alert("Marker was not updated to database!");
                    console.log("Update Incomplete");
                  }
                  // need to add logic to actually check above
              }
          );
          
          
        }

// End of post
function markerRowChange(index, powerline, powerpole, overgrowth, oversag, Latitude, Longitude, comment)
{ 
  console.log("powerpole"+index);
  if(powerline == true){
    document.getElementById("powerline"+index).checked = true;
  } else {
    document.getElementById("powerline"+index).checked = false;
  }
  if(powerpole == true){
    document.getElementById("powerpole"+index).checked = true;
  } else {
    document.getElementById("powerpole"+index).checked = false;
  }
  if(overgrowth == true){
    document.getElementById("overgrowth"+index).checked = true;
  } else {
    document.getElementById("overgrowth"+index).checked = false;
  }
  if(oversag == true){
    document.getElementById("oversag"+index).checked = true;
  } else {
    document.getElementById("oversag"+index).checked = false;
  }


  document.getElementById("Latitude"+index).innerHTML = Latitude;
  document.getElementById('Longitude'+index).innerHTML = Longitude;
  //document.getElementById('commentArea'+index).value = comment;
  //console.log("Comment is " + comment);

}

// generates table elements
function generateTable() {
  console.log(markerPages);
  markerIndex = 0;
	var currentPage = markerPages[markerIndex];
  var i;
	for(i=0;i<currentPage.length;i++){
    try{
    	//console.log(markers[i]);
    	var filename = currentPage[i].filename;
        var table = document.getElementById("table");
        var row = table.insertRow(0);
        var cell1 = row.insertCell(0);
        var image = "http://107.170.23.85/api/marker/getimage/"+ token + "/"+ filename +"/";
        cell1.innerHTML = 
        '<div id="infoRow">'+
    	'<div id="info">'+
      '<input class="css-checkbox" type="checkbox" name="powerline" id="powerline'+i+'" value="False">'+
    	'<label for="powerline'+i+'" class="css-label">Powerline</label>'+
    	'<input class="css-checkbox" type="checkbox" name="powerpole" id="powerpole'+i+'" value="False">'+
      '<label for="powerpole'+i+'" class="css-label">Powerpole</label>'+
      '<input class="css-checkbox" type="checkbox" name="overgrowth" id="overgrowth'+i+'" value="False">'+
    	'<label for="overgrowth'+i+'" class="css-label">Overgrowth</label>'+
    	'<input class="css-checkbox" type="checkbox" name="oversag" id="oversag'+i+'" value="False">'+
    	'<label for="oversag'+i+'" class="css-label">Oversag</label>'+
    	'<br>'+
        '<label>Latitude: </label>'+
    	'<label id="Latitude'+i+'">29.32226</label>'+
    	'<br>'+
    	'<label>Longitude: </label>'+
    	'<label id="Longitude'+i+'">-81.29545646</label>'+
    	'<br>'+
    	'<textarea class="commentArea" id="commentArea'+i+'" rows="3" placeholder="Enter notes about the current location"></textarea>'+
        '<br>'+
    	'<button type="button" class="button" id="button" onclick="updateMarkerRow('+i+')">Update</button>'+
    	'</div>'+
    	'<div id="imgDiv">'+
    	'<img src= '+image+' id="image'+i+'" class="image" >'+
    	'</div>'+
    	'</div>';
    	
    	 markerRowChange(i, currentPage[i].powerline, currentPage[i].powerpole, currentPage[i].overgrowth, currentPage[i].oversag, currentPage[i].latitude, currentPage[i].longitude, 1/*currentPage[i].comment*/);

    	   // Get the modal
    		var modal = document.getElementById('myModal');

    		// Get the image and insert it inside the modal
    		var img = document.getElementById("image"+i);
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
        //cell1.innerHTML = "NEW CELL1";
        //cell1.innerHTML = '<button type="button">Click Me!</button>';
        //markerIndex = 1;
    }
    catch(err){
      console.log("Failed to get 10 items from array : " + err);
      break;
    }
  } 
}

function nextPage() {
  console.log(markerPages);
  try{
    console.log("current page is " + markerIndex);
     if(markerIndex < markerPages.length){
      markerIndex++;
    } else {
      alert("No Further Entries Exist!");
      return;
    }

    var currentPage = markerPages[markerIndex];
    var length = currentPage.length;

    var resultsTable = document.getElementById("table");
      for(var i = 0; i < resultsTable.rows.length;){   
         resultsTable.deleteRow(i);
      }
      var i;
      for(i=0;i<length;i++){
        
          //console.log(markers[i]);
          var filename = currentPage[i].filename;
            var table = document.getElementById("table");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var image = "http://107.170.23.85/api/marker/getimage/"+ token + "/"+ filename +"/";
            cell1.innerHTML = 
            '<div id="infoRow">'+
          '<div id="info">'+
          '<input class="css-checkbox" type="checkbox" name="powerline" id="powerline'+i+'" value="False">'+
          '<label for="powerline'+i+'" class="css-label">Powerline</label>'+
          '<input class="css-checkbox" type="checkbox" name="powerpole" id="powerpole'+i+'" value="False">'+
          '<label for="powerpole'+i+'" class="css-label">Powerpole</label>'+
          '<input class="css-checkbox" type="checkbox" name="overgrowth" id="overgrowth'+i+'" value="False">'+
          '<label for="overgrowth'+i+'" class="css-label">Overgrowth</label>'+
          '<input class="css-checkbox" type="checkbox" name="oversag" id="oversag'+i+'" value="False">'+
          '<label for="oversag'+i+'" class="css-label">Oversag</label>'+
          '<br>'+
            '<label>Latitude: </label>'+
          '<label id="Latitude'+i+'">29.32226</label>'+
          '<br>'+
          '<label>Longitude: </label>'+
          '<label id="Longitude'+i+'">-81.29545646</label>'+
          '<br>'+
          '<textarea class="commentArea" id="commentArea'+i+'" rows="3" placeholder="Enter notes about the current location"></textarea>'+
            '<br>'+
          '<button type="button" class="button" id="button" onclick="updateMarkerRow('+i+')">Update</button>'+
          '</div>'+
          '<div id="imgDiv">'+
          '<img src= '+image+' id="image'+i+'" class="image" >'+
          '</div>'+
          '</div>';
          
           markerRowChange(i, currentPage[i].powerline, currentPage[i].powerpole, currentPage[i].overgrowth, currentPage[i].oversag, currentPage[i].latitude, currentPage[i].longitude, 1/*currentPage[i].comment*/);

             // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal
            var img = document.getElementById("image"+i);
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
            //cell1.innerHTML = "NEW CELL1";
            //cell1.innerHTML = '<button type="button">Click Me!</button>';
            
            console.log(i);

            //scrolls user to top of page
            window.scroll({ top: 170, left: 0, behavior: 'smooth' });
            

        
      }
        
    }
    catch(err){
      console.log("Failed to get 10 items from array : " + err);
      alert("No Further Entries Exist!");
    }
    
}



function prevPage() {
  console.log(markerPages);
  try{
    console.log("current page is " + markerIndex);
      if(markerIndex > 0){
      markerIndex--;
    } else {
      alert("No Further Entries Exist!");
      return;
    }


    var currentPage = markerPages[markerIndex];
    var length = currentPage.length;

    var resultsTable = document.getElementById("table");
      for(var i = 0; i < resultsTable.rows.length;){   
         resultsTable.deleteRow(i);
      }
      var i;
      for(i=0;i<length;i++){
        
          //console.log(markers[i]);
          var filename = currentPage[i].filename;
            var table = document.getElementById("table");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var image = "http://107.170.23.85/api/marker/getimage/"+ token + "/"+ filename +"/";
            cell1.innerHTML = 
            '<div id="infoRow">'+
          '<div id="info">'+
          '<input class="css-checkbox" type="checkbox" name="powerline" id="powerline'+i+'" value="False">'+
          '<label for="powerline'+i+'" class="css-label">Powerline</label>'+
          '<input class="css-checkbox" type="checkbox" name="powerpole" id="powerpole'+i+'" value="False">'+
          '<label for="powerpole'+i+'" class="css-label">Powerpole</label>'+
          '<input class="css-checkbox" type="checkbox" name="overgrowth" id="overgrowth'+i+'" value="False">'+
          '<label for="overgrowth'+i+'" class="css-label">Overgrowth</label>'+
          '<input class="css-checkbox" type="checkbox" name="oversag" id="oversag'+i+'" value="False">'+
          '<label for="oversag'+i+'" class="css-label">Oversag</label>'+
          '<br>'+
            '<label>Latitude: </label>'+
          '<label id="Latitude'+i+'">29.32226</label>'+
          '<br>'+
          '<label>Longitude: </label>'+
          '<label id="Longitude'+i+'">-81.29545646</label>'+
          '<br>'+
          '<textarea class="commentArea" id="commentArea'+i+'" rows="3" placeholder="Enter notes about the current location"></textarea>'+
            '<br>'+
          '<button type="button" class="button" id="button" onclick="updateMarkerRow('+i+')">Update</button>'+
          '</div>'+
          '<div id="imgDiv">'+
          '<img src= '+image+' id="image'+i+'" class="image" >'+
          '</div>'+
          '</div>';
          
           markerRowChange(i, currentPage[i].powerline, currentPage[i].powerpole, currentPage[i].overgrowth, currentPage[i].oversag, currentPage[i].latitude, currentPage[i].longitude, 1/*currentPage[i].comment*/);

             // Get the modal
            var modal = document.getElementById('myModal');

            // Get the image and insert it inside the modal
            var img = document.getElementById("image"+i);
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
            //cell1.innerHTML = "NEW CELL1";
            //cell1.innerHTML = '<button type="button">Click Me!</button>';
            
            console.log(i);

            //scrolls user to top of page
            window.scroll({ top: 170, left: 0, behavior: 'smooth' });
            

        
      }
        
    }
    catch(err){
      console.log("Failed to get 10 items from array : " + err);
      alert("No Further Entries Exist!");
    }
    
}