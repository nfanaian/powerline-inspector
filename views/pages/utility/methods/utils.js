// ** GLOBAL VARIABLES
var root = "http://107.170.23.85/";
var root_self = window.location.href.split("/")[0] + "//" + window.location.href.split("/")[2] + "/";
console.log(root);
console.log(window.getCookie());


/** Logout user
 * Deletes JWT api token from cookies
 * and redirects user to root page
 */
function logout()
{
    window.delCookie();
    window.location.href = window.root;
}


/**
 *  COOKIE FUNCTIONS
 */
function delCookie()
{
    var d = new Date();
    d.setTime(d.getTime() - (24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = "token=" + ";path=/";//";" + expires + ";path=/";
}

function setCookie(cvalue)
{
    var exdays = 1;
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = "token=" + cvalue + ";path=/";//";" + expires + ";path=/";
}

function getCookie() {
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