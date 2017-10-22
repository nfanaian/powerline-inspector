// Root of current url (this way I can grab http://localhost/ or http://IP.ADDRESS/
// Therefore all HTML/Javascript can run locally/offline as long as API Webservice is up
var root = window.location.href.split("/")[0] + "//" + window.location.href.split("/")[2] + "/";

window.onload = init_page();

function init_page()
{
    // Debugging, might be better to check token and go straight to maps
    window.delCookie("token");
    //window.enterListener();
}

function enterListener()
{
    var userBox = document.getElementById("username");
    var pwBox = document.getElementById("psw");

    userBox.addEventListener("keypress", function(event) {
        event.preventDefault();
        if (event.keyCode == 13) {
            document.getElementById("button").click();
        }
    });

    pwBox.addEventListener("keypress", function(event) {
        event.preventDefault();
        if (event.keyCode == 13) {
            document.getElementById("button").click();
        }
    });
}

function delCookie(cname)
{
    var cvalue = "";
    var d = new Date();
    d.setTime(d.getTime() - (24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";path=/";//";" + expires + ";path=/";
}

function setCookie(cname, cvalue)
{
    var exdays = 1;
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";path=/";//";" + expires + ";path=/";
}

function login()
{
    document.getElementById("button").disabled = true;
    document.getElementById("button").setAttribute("value", "...");

    var apiRoot = "http://107.170.23.85/api/";
    var apiController = "auth/";
    var apiFunc = "login/";

    var user = document.getElementById("username").value;
    var pw = document.getElementById("psw").value;

    var params = user + "/" + pw + "/";

    /* AJAX REQUEST
     * User Authentication
     */
    var url = apiRoot + apiController + apiFunc;//+ params;
    $.post(
        url,
        {
            user: user,
            pw: pw
        },
        function(data){
            console.log(data);

            // Authentication successful
            if (data.success == true)
            {
                console.log(data.jwt);
                document.getElementById("button").setAttribute("value", "User authenticated");
                window.setCookie('token', data.jwt);
                window.location.href = "http://107.170.23.85/utility/mapviewer/";

            // Authentication failure
            } else {
                document.getElementById("button").disabled = false;
                document.getElementById("button").setAttribute("value", "Try Again");
            }
        }
    );
}