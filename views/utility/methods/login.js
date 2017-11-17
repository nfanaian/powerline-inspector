
function checkLogin(){
	var uName = document.getElementById("username").value;
	var pWord = document.getElementById("password").value;
	var passHash;
	//window.location.href = "index8.html"; //delete after AJAX is implemented
	passHash = md5(pWord);
	
	//console.log(something);
	var root = 'http://107.170.23.85/api/auth/login/';
	var url = root// + 'API/Marker/getAll/'
	

	$.post(
	  url,
	  {
	    //token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyIjoidGVzdCIsInJlcXVlc3QiOnsicmVxdWVzdCI6ImFwaS0-YXV0aC0-bG9naW4tPnRlc3QtPjVmNGRjYzNiNWFhNzY1ZDYxZDgzMjdkZWI4ODJjZjk5LT4iLCJ0aW1lIjoiMDg6MDE6MDMgUE0iLCJkYXRlIjoiMTAtMjMtMjAxNyJ9LCJjbGllbnRJUCI6eyJpcCI6IjczLjI0Ljk5LjUxIiwiaG9zdG5hbWUiOiJjLTczLTI0LTk5LTUxLmhzZDEuZmwuY29tY2FzdC5uZXQiLCJjaXR5IjoiS2lzc2ltbWVlIiwicmVnaW9uIjoiRmxvcmlkYSIsImNvdW50cnkiOiJVUyIsImxvYyI6IjI4LjMyNjAsLTgxLjM1MTMiLCJvcmciOiJBUzc5MjIgQ29tY2FzdCBDYWJsZSBDb21tdW5pY2F0aW9ucywgTExDIiwicG9zdGFsIjoiMzQ3NDMifX0.LNcIO5MKP5hPUtoy17Ccwren3cbMI6wMeagWa2Ssyp8"
	    user: uName,
	    pw: passHash,
	  },
	  function(data) {
	    if (data.success == false){
			alert("Username or Password is incorrect!");
			console.log(data);
		}else{
			//console.log(data.jwt);
			setToken(data.jwt);
			//console.log(readToken());
			//window.location.href = "index10.html";
			window.location.href = "table2.html";
		}
	  }
	);

	//console.log(readToken("token"));
	
}

// Sets Token returned by server
function setToken(tValue) {

    document.cookie = "token=" + tValue + ";";
}
// Reads Token returned by server
function readToken(){
	var name = "token" + "=";
	// used for special characters
    var decodedCookie = decodeURIComponent(document.cookie);
    // Converts string to array
    var cookieString = decodedCookie.split(';');
    // We only need to check 1st index 
    var c = cookieString[0];
    // If cookie name is token, return it
    if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
    } else{
    	// else return no Token
    	return "No Token Found";
    }
    
    
}
