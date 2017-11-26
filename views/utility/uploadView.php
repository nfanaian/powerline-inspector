<title>Upload Page</title>
<link rel="stylesheet" href="/views/utility/styles/loginStyle1.css">
<link rel="stylesheet" href="/views/utility/styles/uploadStyle.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="/views/utility/methods/login.js"></script>
<script src="/views/utility/methods/upload.js"></script>
<img class="source-image" src="/views/utility/images/PowerLinesBackgroundColor.jpg" alt=""/>

<div class="Box">
	<!--	<h2>Video Upload</h2> -->
	<h2>Drag and drop or select video file to upload.</h2>
	<div class="main-content-wrapper">
		<div class="main-content">
			<div class="file-input">
				<input type="file" name="file" id="file">
				<span class="input-value" id="inputBox">Browse Files</span>
			</div>
			<button class="button" id="loginButton" type="button" onclick="submitFile()" disabled='true' ><span>Submit File</span></button>
		</div>
	</div>
</div>

<script type="text/javascript">
	var inputValue = "";
	$(function(){
		$('.file-input > input').on('change',function(){
			//var inputValue = $(this).val();
			inputValue = document.getElementById("file").files[0];
			//inputValue.replace(pattern, "");
			console.log(inputValue.name);
			$('.input-value').html(inputValue.name);
			document.getElementById("loginButton").disabled = false;
		});
	});
</script>