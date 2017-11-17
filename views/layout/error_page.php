<?php

// DEBUG Console.log() of error message
// You could instead use an HTML template to provide the error to the user
// But as of now this is just a redirect page
if (true)
{
	?>
	<script type="application/javascript">
		console.log("Status: " + <?= $this->model->output["status"]; ?>);
	</script>
	<?php
}
?>

<!-- Add a javascript redirect onload -->
<?php
	// Check 'redirect' has been set & is true
	$r = $this->model->output["redirect"];

	if (isset($r)? ($r? true: false): false)
	{
		?>
		<script type="application/javascript">
			function redirect()
			{
				var url = window.location.href.split("/")[0] + "//" + window.location.href.split("/")[2] + "/";
				window.location.href = url;
			}
			window.onload = redirect();
		</script>
		<?php
	}
?>