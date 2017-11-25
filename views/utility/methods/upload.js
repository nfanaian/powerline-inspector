function submitFile(){
	//disable submit button
	document.getElementById("loginButton").disabled = true;
	// get file submitted from user
	var submittedFile = document.getElementById("file").files[0];
	// change text on button to inform user
	document.getElementById("loginButton").innerHTML = "Submitting File...";

	// Add API call here!
	console.log("File is: "+submittedFile);

    var token = readToken();
    var root = 'http://squibotics.com/';
    //have to change url
    var url = root + 'API/auth/decode/' + token + '/';

    $.post(
      url,
      {
          token: token,
          file: submittedFile
      },
      function(data) {
        if(data.success == true){
            document.getElementById("loginButton").innerHTML= "Submit File";
            document.getElementById("loginButton").disabled = false;
            document.getElementById("inputBox").innerHTML = "Browse Files";
            alert("File has been uploaded successfully.");
        } else {
            console.log(data);
            document.getElementById("loginButton").innerHTML= "Submit File";
            document.getElementById("loginButton").disabled = false;
            document.getElementById("inputBox").innerHTML = "Browse Files";
            alert("File was not submitted.");
        }
      }
    );


}