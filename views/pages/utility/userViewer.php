<meta name="description" content="Project Dragon - User Viewer">

<!-- CSS -->
<link href="/views/pages/utility/styles.css" rel="stylesheet" type="text/css">

<!-- Javascripts-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src = "http://www.myersdaily.org/joseph/javascript/md5.js"></script>
<script type="text/javascript" src="/views/pages/utility/methods/utils.js"></script>
<script type="text/javascript" src="/views/pages/utility/methods/user.js"></script>

<div id="info">
	<div id="header">
		<h1>Project Dragon Demo</h1>
	</div>
	<div class="block">
		<input class="input" type="text" id="username" name="username" placeholder="Username" maxlength="20" autocomplete="on" autofocus required>
	</div>
	<div class="block">
		<input class="input" type="password" id="psw" name="psw" placeholder="Password" maxlength="20" required>
		<!-- For later: pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" -->
	</div>
	<div class="block">
		<form>
			<input id="login-btn" class="btn" type="submit" value="Log In" onclick="login()">
		</form>
	</div>
</div>