<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Project Dragon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link href="/views/pages/imageViewer/styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="container">
	<div id="header">
	</div>
	<div id="main">
		<form method="post" action="/category/imageViewer">
			<input hidden name="file" value="<?= $this->model->filename; ?>">
			<button name="delete">Delete</button>

 			<div id="viewer" style="<?= $this->model->dets_img; ?>">
				<img src="<?= "/img/" . $this->model->filename; ?>" alt="<?= $this->model->filename; ?>">
			</div>

			<?= $this->model->submit_mobile; ?>
			<div id="details">
				<div style="<?= $this->model->dets_mobile ?>">
					<label for="powerline">
						<span class="text">Powerline</span><br/>
						<input type="checkbox" name="powerline" value="1" />
					</label>
				</div>
				<div style="<?= $this->model->dets_mobile ?>">
					<label for="powerpole">
						<span class="text">Powerpole</span><br/>
						<input type="checkbox" name="powerpole" value="1" />
					</label>
				</div>
				<div style="<?= $this->model->dets_mobile ?>">
					<label for="vegetation">
						<span class="text">Vegatation</span><br/>
						<input type="checkbox" name="vegetation" value="1" />
					</label>
				</div>
				<div style="<?= $this->model->dets_mobile ?>">
					<label for="oversag">
						<span class="text">Oversag</span><br/>
						<input type="checkbox" name="oversag" value="1" />
					</label>
				</div>
				<div style="<?= $this->model->dets_mobile ?>">
					<label for="damage">
						<span class="text">Damage</span><br/>
						<input type="checkbox" name="damage" value="1" />
					</label>
				</div>
			</div>
			<?= $this->model->submit_desktop; ?>
		</form>
	</div>
	<div id="info">
		<?= $this->model->info ?>
	</div>
	<?= $this->model->footer ?>
</div>
</body>
</html>
