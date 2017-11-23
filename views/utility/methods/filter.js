// Filter Event Listeners
var Gcheckbox = document.querySelector("input[id=poi-Green]");
Gcheckbox.checked = true;
Gcheckbox.addEventListener( 'change', function() {
    if(this.checked) {
        for(var x in markerArray){
          if(markerArray[x].status == "green" && markerArray[x].timeFiltered == false){
            markerArray[x].setVisible(true);
          } 
      }
    } else {
        for(var x in markerArray){
          if(markerArray[x].status == "green" && markerArray[x].timeFiltered == false){
            markerArray[x].setVisible(false);
          }
      }
    }
});

var Ycheckbox = document.querySelector("input[id=poi-Yellow]");
Ycheckbox.checked = true;
Ycheckbox.addEventListener( 'change', function() {
    if(this.checked) {
        for(var x in markerArray){
          if(markerArray[x].status == "yellow" && markerArray[x].timeFiltered == false){
            markerArray[x].setVisible(true);
          } 
      }
    } else {
        for(var x in markerArray){
          if(markerArray[x].status == "yellow" && markerArray[x].timeFiltered == false){
            markerArray[x].setVisible(false);
          }
      }
    }
});

var Rcheckbox = document.querySelector("input[id=poi-Red]");
Rcheckbox.checked = true;
Rcheckbox.addEventListener( 'change', function() {
    if(this.checked) {
        for(var x in markerArray){
          if(markerArray[x].status == "red" && markerArray[x].timeFiltered == false){
            markerArray[x].setVisible(true);
          } 
      }
    } else {
        for(var x in markerArray){
          if(markerArray[x].status == "red" && markerArray[x].timeFiltered == false){
            markerArray[x].setVisible(false);
          }
      }
    }
});


function timeFilter(){
    
    var date = document.getElementById('dateArea').value;
    if(date != ""){
    //Tests if entered date is in correct format  
    var regex = /^[0-9]{4}.[0-9]{2}.[0-9]{2}$/i;
    console.log("answer is "+ regex.test(date));
    if(regex.test(date) == false){
      alert("Please enter the date in the correct format. YYYY-MM-DD");
      return;
    }
    
    //changes background of time entry label  
    document.getElementById("timeEntryLabel").style.backgroundColor = "#4ea0da";
    var justDate = date.split(" "); //May have to delete if no space in date
    var date = justDate[0].split("-");
    var year = date[0];
    var month = date[1];
    var day = date[2];

    //tests if day and month are correct values
    if(month>12||day>31){
      alert("Please enter a correct date.");
      return;
    }
    console.log(date);
    for(var x in markerArray){
      //tests year
      if(markerArray[x].year < year)
      {
        markerArray[x].setVisible(false);
        markerArray[x].timeFiltered = true;
        
      }
      else if(markerArray[x].year == year)
      {
       
        if(markerArray[x].month < month)
        {
          markerArray[x].setVisible(false);
          markerArray[x].timeFiltered = true;
        }
        else if(markerArray[x].month == month)
        {
      
          if(markerArray[x].day < day)
          {
        
            markerArray[x].setVisible(false);
            markerArray[x].timeFiltered = true;
           
            
          }else
          {
            markerArray[x].timeFiltered = false;
            if(shouldItBeVisible(markerArray[x]))
            {
              markerArray[x].setVisible(true);
            }
          }
        }else
        {
          markerArray[x].timeFiltered = false;
          if(shouldItBeVisible(markerArray[x]))
          {
              markerArray[x].setVisible(true);
          }
        }
      }else
      {
        markerArray[x].timeFiltered = false;
        if(shouldItBeVisible(markerArray[x]))
        {
              markerArray[x].setVisible(true);
        }
      }

    }


console.log("no");
  }else{
    document.getElementById("timeEntryLabel").style.backgroundColor = "#3386c0";
    console.log("is it checked");
    for(var x in markerArray){
     /* if(Ycheckbox.checked == true){
        if(markerArray[x].status == "yellow"){
            markerArray[x].setVisible(true);
            markerArray[x].timeFilter = false;
        }
        
      }*/
      markerArray[x].timeFiltered = false;
      if(shouldItBeVisible(markerArray[x])){
        markerArray[x].setVisible(true);
      }
    }
  }

}

function shouldItBeVisible(marker){
  if(marker.status == "yellow" && Ycheckbox.checked == true ||
        marker.status == "green" && Gcheckbox.checked == true ||
        marker.status == "red" && Rcheckbox.checked == true){
        return true;
  }else {
    return false;
  }
}