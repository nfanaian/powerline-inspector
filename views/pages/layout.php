<!-- Any non-api API request gets this generic html layout -->
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<link href="/views/pages/layout.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<!-- Site Header -->
		<div class="site-header">
		</div>

		<!-- Site Main -->
		<div class="site-main">
			<?php require_once('routes.php'); ?>

		</div>

		<!-- Site Footer -->
		<div class="site-footer">
			<div id="copyright">
				Copyright &copy Team Dragon
			</div>
		</div>

	</body>
</html>