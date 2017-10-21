
<html>

<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		var root = 'https://jsonplaceholder.typicode.com';
		var request = '/posts/1';
		root = 'http://107.170.23.85/';
		request = 'api/marker/getimage/';

		//59677536bd647_046.jpg
		var url = root+request;
		$.get(url, function(data){
			console.log(data);
		});

	</script>
</head>
<body>
<img src="">
</body>
</html>
