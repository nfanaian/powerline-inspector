function deleteToken(){
	var name = 'Token'
	document.cookie = name +'=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

function delCookie()
{
    var d = new Date();
    d.setTime(d.getTime() - (24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = "token=" + ";path=/";//";" + expires + ";path=/";
}

function logout()
{
    window.delCookie();
    window.location.href = "http://squibotics.com/utility/login/";
}