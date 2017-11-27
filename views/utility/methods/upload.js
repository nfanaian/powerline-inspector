function submitFile()
{
    var loginButton = document.getElementById("loginButton");
	//disable submit button
	loginButton.disabled = true;
	// get file submitted from user
	var submittedFile = document.getElementById("file");
	// change text on button to inform user
	loginButton.innerHTML = "Submitting File...";

    var _progress = document.getElementById('_progress');

    if(submittedFile.files.length === 0){
        return;
    }

    var data = new FormData();
    data.append('file', submittedFile.files[0]);

    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4){
            try {
                var resp = JSON.parse(request.response);
            } catch (e){
                var resp = {
                    status: 'error',
                    data: 'Unknown error occurred: [' + request.responseText + ']'
                };
            }
            console.log(resp.status + ': ' + resp.data);
        }
    };

    request.upload.addEventListener('progress', function(e){
        loginButton.innerHTML = "Uploading...\t" + Math.ceil(e.loaded/e.total) * 100 + '%';
    }, false);

    request.upload.addEventListener('load', function(e){
        loginButton.innerHTML = "File successfully uploaded";
    }, false);


    request.open('POST', 'http://squibotics.com/api/upload/');
    request.send(data);

//alert("File has been uploaded successfully.");
//alert("File was not submitted.");
}