// Filter Event Listeners
var Gcheckbox = document.querySelector("input[id=poi-Green]");
Gcheckbox.checked = true;
Gcheckbox.addEventListener( 'change', function() {
    if(this.checked) {
        for(var x in markerArray){
          if(markerArray[x].status == "green"){
            markerArray[x].setVisible(true);
          } 
      }
    } else {
        for(var x in markerArray){
          if(markerArray[x].status == "green"){
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
          if(markerArray[x].status == "yellow"){
            markerArray[x].setVisible(true);
          } 
      }
    } else {
        for(var x in markerArray){
          if(markerArray[x].status == "yellow"){
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
          if(markerArray[x].status == "red"){
            markerArray[x].setVisible(true);
          } 
      }
    } else {
        for(var x in markerArray){
          if(markerArray[x].status == "red"){
            markerArray[x].setVisible(false);
          }
      }
    }
});
// End of Filter Event Listeners