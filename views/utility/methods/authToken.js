var root = 'http://squibotics.com/';
//have to change url
var url = root + 'API/auth/authpage/';
var token = readToken();

//send user back to login if token is empty
$.post(
    url,
    {
        token: token
    },
    function(data)
    {
        if(data.success == false)
        {
            //document.location.href = "http://squibotics.com/utility/login/";
        } else{
            console.log("Token authenticated");
        }
    }
);

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