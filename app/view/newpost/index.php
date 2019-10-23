<?php
	$title = 'New Post';
	$crumb = 'Home/' . $title;
?>
<style>
	.hvr-grow a {
		text-decoration: none;
	}
</style>
<div class="container-fluid">
    <div class="row text-center">
		<div class="col">
			<a href ="<?= URL; ?>newpost/create" class="hvr-icon-bob">
				<div class="card text-white bg-dark">
					<div class="card-body">
						<i class="fas fa-camera fa-7x my-3 hvr-icon"></i>
						<h5>Create a snapshot</h5>
						<hr class="border-top border-white w-75">
						<p class="font-weight-light">Reveal the artist within you in the studio and take original photos with fun stickers!</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col">
			<a href ="<?= URL; ?>newpost/upload" class="hvr-icon-bob">
				<div class="card text-white bg-dark">
					<div class="card-body">
						<i class="fas fa-upload fa-7x my-3 hvr-icon"></i>
						<h5>Upload an image</h5>
						<hr class="border-top border-white w-75">
						<p class="font-weight-light">Not feeling creative? That's okay. You can also post existing pictures <small class="text-muted">(Terms of Service apply)</small></p>
					</div>
				</div>
			</a>
		</div>
    </div>
</div>