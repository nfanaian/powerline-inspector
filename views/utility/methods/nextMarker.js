


function nextGreenMarker(){
	var selectedMarkerIndex;
	if(selMarker  == null){
		selectedMarkerIndex = -1;
	}else{
		selectedMarkerIndex = selMarker.index;
	}

	var Index = greenPointer;
	var size = markerArray.length;
	
	console.log("index is: " + Index);
	console.log("size is: " + size);
	for(Index;Index<size;Index++){
		if(markerArray[Index].status == "green" && selectedMarkerIndex != Index ){ //&& selMarker.index != greenIndex
			//PRESENTS MARKER
			nextEvent(Index);
			greenPointer = Index;
			console.log(markerArray[Index].url);
			console.log(Index);
			break;
		}
		if(Index>=size-1){
			greenPointer = 0;
			alert("No more Green Markers Found");
		}
	}
}

function previousGreenMarker(){
	var selectedMarkerIndex;
	if(selMarker  == null){
		selectedMarkerIndex = -1;
	}else{
		selectedMarkerIndex = selMarker.index;
	}

	var Index;
	if(greenPointer == 0){
		Index = markerArray.length-1;
	}else{
		Index = greenPointer;
	}

	console.log("index is: " + Index);
	for(Index;Index >= 0;Index--){
		if(markerArray[Index].status == "green" && selectedMarkerIndex != Index){
			//PRESENTS MARKER
			nextEvent(Index);
			greenPointer = Index;
			console.log(markerArray[Index].url);
			console.log(Index);
			if(Index == 0){
			greenPointer = 0;
			alert("No more Green Markers Found");
			}
			break;
		}

		if(Index == 0){
			greenPointer = 0;
			alert("No more Green Markers Found");
		}
	}
}

function nextYellowMarker(){
	var selectedMarkerIndex;
	if(selMarker  == null){
		selectedMarkerIndex = -1;
	}else{
		selectedMarkerIndex = selMarker.index;
	}

	var Index = yellowPointer;
	var size = markerArray.length;
	
	console.log("index is: " + Index);
	console.log("size is: " + size);
	for(Index;Index<size;Index++){
		if(markerArray[Index].status == "yellow" && selectedMarkerIndex != Index ){ //&& selMarker.index != greenIndex
			//PRESENTS MARKER
			nextEvent(Index);
			yellowPointer = Index;
			console.log(markerArray[Index].url);
			console.log(Index);
			break;
		}
		if(Index>=size-1){
			yellowPointer = 0;
			alert("No more Yellow Markers Found");
		}
	}
}

function previousYellowMarker(){
	var selectedMarkerIndex;
	if(selMarker  == null){
		selectedMarkerIndex = -1;
	}else{
		selectedMarkerIndex = selMarker.index;
	}

	var Index;
	if(yellowPointer == 0){
		Index = markerArray.length-1;
	}else{
		Index = yellowPointer;
	}

	console.log("index is: " + Index);
	for(Index;Index >= 0;Index--){
		if(markerArray[Index].status == "yellow" && selectedMarkerIndex != Index){
			//PRESENTS MARKER
			nextEvent(Index);
			yellowPointer = Index;
			console.log(markerArray[Index].url);
			console.log(Index);
			if(Index == 0){
			yellowPointer = 0;
			alert("No more Yellow Markers Found");
			}
			break;
		}

		if(Index == 0){
			yellowPointer = 0;
			alert("No more Yellow Markers Found");
		}
	}
}

function nextRedMarker(){
	var selectedMarkerIndex;
	if(selMarker  == null){
		selectedMarkerIndex = -1;
	}else{
		selectedMarkerIndex = selMarker.index;
	}

	var Index = redPointer;
	var size = markerArray.length;
	
	console.log("index is: " + Index);
	console.log("size is: " + size);
	for(Index;Index<size;Index++){
		if(markerArray[Index].status == "red" && selectedMarkerIndex != Index ){ //&& selMarker.index != greenIndex
			//PRESENTS MARKER
			nextEvent(Index);
			redPointer = Index;
			console.log(markerArray[Index].url);
			console.log(Index);
			break;
		}
		if(Index>=size-1){
			redPointer = 0;
			alert("No more Red Markers Found");
		}
	}
}

function previousRedMarker(){
	var selectedMarkerIndex;
	if(selMarker  == null){
		selectedMarkerIndex = -1;
	}else{
		selectedMarkerIndex = selMarker.index;
	}

	var Index;
	if(redPointer == 0){
		Index = markerArray.length-1;
	}else{
		Index = redPointer;
	}

	console.log("index is: " + Index);
	for(Index;Index >= 0;Index--){
		if(markerArray[Index].status == "red" && selectedMarkerIndex != Index){
			//PRESENTS MARKER
			nextEvent(Index);
			redPointer = Index;
			console.log(markerArray[Index].url);
			console.log(Index);
			if(Index == 0){
			redPointer = 0;
			alert("No more Red Markers Found");
			}
			break;
		}

		if(Index == 0){
			redPointer = 0;
			alert("No more red Markers Found");
		}
	}
}

// displays marker information when using search arrows
function nextEvent(index){
		console.log(markerArray[index].url);
		var url = markerArray[index].url;
       	document.getElementById("myImg").src="http://107.170.23.85/api/marker/getimage/"+ token + "/"+ url +"/";
        
        infoPanelChange(markerArray[index].powerline, markerArray[index].powerpole, markerArray[index].overgrowth, markerArray[index].oversag, markerArray[index].latitude, markerArray[index].longitude, markerArray[index].locationComment)
        
        if (selected == 0) {
        originalIcon = markerArray[index].getIcon();
        markerArray[index].setIcon(blueimage);
        selected = 1;
        selMarker = markerArray[index];
        } else {
          //console.log(selMarker);
          selMarker.setIcon(originalIcon); 
          originalIcon = markerArray[index].getIcon();
          markerArray[index].setIcon(blueimage);
          selMarker = markerArray[index];
        }
}
