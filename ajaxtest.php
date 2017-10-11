<!DOCTYPE html>
<html>

<body>
<h1>hello world</h1>
<script>
	var root = 'https://jsonplaceholder.typicode.com';

	$.ajax({
		url: root + '/posts/1',
		method: 'GET'
	}).then(function(data) {
		console.log(data);
	});
</script>
</body>
</html>
