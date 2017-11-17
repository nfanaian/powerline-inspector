<meta name="description" content="Project Dragon - User Viewer">

<!-- CSS -->
<link href="/views/seniordesign/styles/styles.css" rel="stylesheet" type="text/css">

<!-- Javascripts-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/views/seniordesign/js/resources/md5.min.js"></script>
<script type="text/javascript" src="/views/seniordesign/js/utils.js"></script>
<script type="text/javascript" src="/views/seniordesign/js/user.js"></script>

<div class="info">
	<div id="header">
		<h1>Project Dragon Demo</h1>
	</div>
	<div class="info block">
		<input class="input" type="text" id="username" name="username" placeholder="Username" maxlength="20" autocomplete="off" autofocus required>
	</div>
	<div class="info block">
		<input class="input" type="password" id="psw" name="psw" placeholder="Password" maxlength="25" required>
		<!-- For later: pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" -->
	</div>
	<div class="info block">
		<form>
			<input id="login-btn" class="btn" type="submit" value="Log In" onclick="login()">
		</form>
	</div>
</div>