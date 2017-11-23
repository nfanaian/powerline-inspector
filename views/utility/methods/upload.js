

function submitFile(){
	//disable submit button
	document.getElementById("loginButton").disabled = true;
	// get file submitted from user
	var submittedFile = document.getElementById("file").files[0];
	// change text on button to inform user
	document.getElementById("loginButton").innerHTML = "Submitting File...";

	// Add API call here!
	console.log("File is: "+submittedFile);

		var root = 'http://squibotics.com/';
		//have to change url
		var url = root + 'API/Marker/getAll/'+ "/" + submittedFile;
		var token = readToken();
		//console.log(token);
		

		$.post(
		  url,
		  {
		    //token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGVzdCIsInJlcXVlc3QiOnsicmVxdWVzdCI6ImFwaS0-YXV0aC0-bG9naW4tPnRlc3QtPjVmNGRjYzNiNWFhNzY1ZDYxZDgzMjdkZWI4ODJjZjk5LT4iLCJ0aW1lIjoiMDg6MDE6MDMgUE0iLCJkYXRlIjoiMTAtMjMtMjAxNyJ9LCJjbGllbnRJUCI6eyJpcCI6IjczLjI0Ljk5LjUxIiwiaG9zdG5hbWUiOiJjLTczLTI0LTk5LTUxLmhzZDEuZmwuY29tY2FzdC5uZXQiLCJjaXR5IjoiS2lzc2ltbWVlIiwicmVnaW9uIjoiRmxvcmlkYSIsImNvdW50cnkiOiJVUyIsImxvYyI6IjI4LjMyNjAsLTgxLjM1MTMiLCJvcmciOiJBUzc5MjIgQ29tY2FzdCBDYWJsZSBDb21tdW5pY2F0aW9ucywgTExDIiwicG9zdGFsIjoiMzQ3NDMifX0.LNcIO5MKP5hPUtoy17Ccwren3cbMI6wMeagWa2Ssyp8"
		      token: token,
		      file: submittedFile,
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