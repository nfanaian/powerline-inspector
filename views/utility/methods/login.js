function checkLogin()
{
	var uName = document.getElementById("username").value;
	var pWord = document.getElementById("password").value;
	var passHash;
	
	passHash = md5(pWord);
	
	var url = 'http://squibotics.com/api/auth/login/';

	$.post(
	  url,
	  {
	    user: uName,
	    pw: passHash,
	  },
	  function(data) {
	    if (data.success == false){
			alert("Username or Password is incorrect!");
			console.log(data);
		}else{
			console.log(data);
			setToken(data.jwt);
			window.location.href = "http://squibotics.com/utility/mapviewer/";
		}
	  }
	);
}

// Sets Token returned by server
function setToken(tValue)
{
    var exdays = 1;
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = "token=" + tValue + ";path=/";//";" + expires + ";path=/";
}

// Reads Token returned by server
function readToken() {
    var name = "token=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}