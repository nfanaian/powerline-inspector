<meta name="description" content="Project Dragon">
<link href="/views/seniordesign/styles/imageView.css" rel="stylesheet" type="text/css">
	<form method="post" action="/utility/imageViewer">
		<input hidden name="file" value="<?= $this->model->filename; ?>">
		<button name="delete">Delete</button>

        <div id="viewer" style="<?= $this->model->dets_img; ?>">
			<img src="<?= "/img/" . $this->model->filename; ?>" alt="<?= $this->model->filename; ?>">
		</div>

		<?= $this->model->submit_mobile; ?>
		<div id="details">
			<div style="<?= $this->model->dets_mobile ?>">
				<label for="powderline">
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
	<div id="info">
		<?= $this->model->info ?>
	</div>