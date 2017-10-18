
<html>

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		var root = 'https://jsonplaceholder.typicode.com';
		var request = '/posts/1';
		root = 'http://107.170.23.85/';
		request = '/api/test/hello/';

		var obj;
		$.get(root+"api/test/hello/", function(data){
			console.log(data);
			obj = jQuery.parseJSON(data);
		});
		alert(obj);
	</script>
</head>
<body>
</body>
</html>
