<meta name="description" content="Project Dragon - User Viewer">

<!-- CSS -->
<link href="/views/pages/utility/styles.css" rel="stylesheet" type="text/css">

<!-- Javascripts-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/views/pages/utility/user.js"></script>

<div id="info">
	<div id="header">
		<h1>Project Dragon Demo</h1>
	</div>
	<div class="block">
		<input class="input" type="text" id="username" name="username" placeholder="Username" maxlength="20" autocomplete="on" autofocus required>
	</div>
	<div class="block">
		<input class="input" type="text" id="psw" name="psw" placeholder="Password" maxlength="20" required>
		<!-- For later: pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" -->
	</div>
	<div class="block">
		<input id="button" class="btn" type="button" value="Log In" onclick="login()">
	</div>
</div>