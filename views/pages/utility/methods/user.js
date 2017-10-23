function login()
{
    document.getElementById("login-btn").disabled = true;
    document.getElementById("login-btn").setAttribute("value", "...");

    var apiRoot = "http://107.170.23.85/api/";
    var apiController = "auth/";
    var apiFunc = "login/";

    var user = document.getElementById("username").value;
    var pw = document.getElementById("psw").value;

    pw = md5(pw);

    /* AJAX REQUEST
     * User Authentication
     */
    var url = apiRoot + apiController + apiFunc;
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
                window.setCookie(data.jwt); // SAVE JWT_API-KEY IN COOKIE
                console.log(data.jwt);
                document.getElementById("login-btn").setAttribute("value", "User authenticated");
                window.location.href = "http://107.170.23.85/utility/mapviewer/";

                // Authentication failure
            } else {
                document.getElementById("login-btn").disabled = false;
                document.getElementById("login-btn").setAttribute("value", "Try Again");
            }
        }
    );
}