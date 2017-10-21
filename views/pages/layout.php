<!-- Any non-api API request gets this generic html layout -->
<html>
	<head>
		<title></title>
		<meta charset="UTF-8">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link href="/views/pages/layout.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="container">
			<div id="header">
			</div>
			<div id="main">
				<?php require_once('routes.php'); ?>
			</div>
			<div id="footer">
				<label id="copyright">Copyright &copy Team Dragon</label>
			</div>
		</div>
	</body>
</html>