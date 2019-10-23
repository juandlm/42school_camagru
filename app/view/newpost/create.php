<?php
	$title = 'Create a Snapshot';
	$crumb = 'Home/New Post/' . $title;
?>
<style>
#video {
	width: 100%;
	height: 464px;
	border-radius: 5px;
	z-index: 0;
}

.fullStickerWrapper {
	position: relative;
	bottom: 471px;
}

.fullSticker {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 464px;
	background-color: transparent;
}

.screenWrapper {
	width: 100%;
	height: 464px;
	background-color: black;
	border-radius: 5px;
	position: relative;
}

.confirmbtnsWrapper {
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
}

.confirmbtnsWrapper button {
	position: absolute;
	top: 70%;
	visibility: hidden;
	opacity: 0;
	transition: all 0.1s ease;
}

.confirmbtnsWrapper button.btn-success {
	left: 25%;
}

.confirmbtnsWrapper button.btn-danger {
	right: 25%;
}

.confirmbtnsWrapper:hover button{
	visibility: visible;
	opacity: 1;
	transition: all 0.1s ease;
}

.captureButtonWrapper {
	position: relative;
	bottom: 60px;
	right: 10px;
}

.canvas {
	width: 100%;
	height: 464px;
	border-radius: 5px;
}

/* carousel */
.wrapper {
	height: 100px;
	width: 85%;
	position: relative;
	overflow: hidden;
	margin: 0 auto 1rem auto;
}

.button-wrapper {
	width: 100%;
	height: 100%;
	left: 0;
	top: 50px;
	display: flex;
	justify-content: space-between;
	align-items: center;
	position: absolute;
}

.stickerCarousel {
	margin: 0;
	padding: 0;
	list-style: none;
	width: 100%;
	display: flex;
	position: absolute;
	left: 0;
	transition: all 1s ease;
}

.sticker {
	background: #DDDDDD;
	min-width: 100px;
	height: 100px;
	display: inline-block;
	border-radius: 50%;
	margin: 0 0.8rem 0 0.8rem;
}

.sticker input {
	outline: 0;
}

label .fa-check {
	position: absolute;
	bottom: 5%;
	right: 0;
	left: 0;
	font-size: 1.5em;
	text-shadow: 0 0 2px #000;
	visibility: hidden;
	opacity: 0;
	transition: all 0.1s ease;
}

li i.fa-times-circle {
	line-height: 100px;
	color: #AAAAAA;
}

[type=checkbox] { 
	position: absolute;
	opacity: 0;
	width: 0;
	height: 0;
}

li.sticker label{
	cursor: pointer;
}

[type=checkbox]:checked ~ i {
	visibility: visible;
	opacity: 1;
	transition: all 0.1s ease;
}
.user-uploads i.fa-check-circle,
.user-uploads i.fa-times-circle {
	bottom: 20px;
	visibility: hidden;
	opacity: 0;
	transition: all 0.1s ease;
}
.user-uploads i.fa-check-double {
	top: 12px;
	right: 12px;
	text-shadow: 0 0 1px #000;
}
.user-uploads:hover i { 
	visibility: visible;
	opacity: 1;
	transition: all 0.1s ease;
}
.user-uploads i.fa-check-circle {
	left: 30%;
}
.user-uploads i.fa-times-circle {
	right: 30%;
}
</style>
<div class="container">
	<div class="row" >
		<div class="col-xl-9 text-center">
			<div class="container-fluid position-relative">
				<div class="button-wrapper">
					<button class="btn btn-light" data-action="slideLeft"><i class="fas fa-angle-left"></i></button>
					<button class="btn btn-light" data-action="slideRight"><i class="fas fa-angle-right"></i></button>
				</div>
			</div>
			<div class="wrapper">
				<ul class="stickerCarousel" data-target="stickerCarousel">
					<li class="sticker" data-target="sticker">
						<a href="#" alt="No sticker" id="clearStickers"><i class="fas fa-times-circle fa-3x hvr-buzz-out"></a></i>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="cat">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/cat_thumb.png" alt="Cat">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="100">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/100_thumb.png" alt="100">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="pepe">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/pepe_thumb.png" alt="Pepe">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="jake">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/jake_thumb.png" alt="Jake">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="finn">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/finn_thumb.png" alt="Finn">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="pikachu">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/pikachu_thumb.png" alt="Pikachu">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="noel">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/noel_thumb.png" alt="Noel">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="dwi">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/dwi_thumb.png" alt="Deal with it">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
					<li class="sticker" data-target="sticker">
						<label class="position-relative">
							<input type="checkbox" name="sticker" value="poop">
							<img class="img-fluid rounded-circle hvr-bounce-out" src="<?= URL; ?>public/img/stickers/poop_thumb.png" alt="Poop">
							<i class="fas fa-check text-success"></i>
						</label>
					</li>
				</ul>
			</div>
			<div class="screenWrapper" id="screenWrapper">
				<canvas class="canvas d-none" id="canvas" width="1280" height="720"></canvas>
				<video id="video" autoplay></video>
				<div class="fullStickerWrapper">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/cat.png" id="catSticker" alt="Cat">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/100.png" id="100Sticker" alt="100">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/pepe.png" id="pepeSticker" alt="Pepe">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/jake.png" id="jakeSticker" alt="Jake">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/finn.png" id="finnSticker" alt="Finn">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/pikachu.png" id="pikachuSticker" alt="Pikachu">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/noel.png" id="noelSticker" alt="Noel">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/dwi.png" id="dwiSticker" alt="Deal with it">
					<img class="d-none fullSticker" src="<?= URL; ?>public/img/stickers/poop.png" id="poopSticker" alt="Poop">
				</div>
				<div class="confirmbtnsWrapper d-none" id="confirmbtnsWrapper">
					<button class="btn btn-success" onclick="processSnapshot('y');"><i class="fas fa-check fa-3x fa-fw"></i></button>
					<button class="btn btn-danger" onclick="processSnapshot('n');"><i class="fas fa-times fa-3x fa-fw"></i></button>
				</div>
				<p class="small text-muted text-right">You can also <a href="<?= URL; ?>newpost/upload">upload an image</a>.</p>
			</div>
			<div class="text-right captureButtonWrapper">
				<button type="button" id="captureButton" class="btn btn-outline-dark rounded-pill" onclick="snapshot();" disabled>Locked</button>
			</div>
			<div id="uploadResult" class="card mb-4 d-none">
				<div class="card-body">
					<div id="uploadedImg" class="container-fluid p-5 bg-dark rounded-top">
						<img src="" class="img-thumbnail" alt="">
					</div>
					<div id="uploadResultDiag" class="container w-75">
						<p class="card-text mt-3">What a masterpiece! What do you want to do with it?</p>
						<a href="#" role="button" class="btn btn-success hvr-icon-float-away m-2" id="postBtn"><i class="fas fa-check-double hvr-icon mr-2"></i>Post to your profile</a>
						<a href="#" role="button" class="btn btn-info hvr-icon-up m-2" id="saveBtn"><i class="fas fa-save hvr-icon mr-2"></i>Save for later</a>
						<a href="#" role="button" class="btn btn-danger hvr-icon-sink-away m-2" id="deleteBtn"><i class="fas fa-trash-alt hvr-icon mr-2"></i>Delete</a>
					</div>
					<div id="confirmPostDiag" class="pt-3 container-fluid d-none">
						<form method="POST" class="input-group input-group-lg" autocomplete="off">
							<input type="text" class="form-control mr-2" name="img_description" placeholder="Enter a description for your post or leave this empty" autocomplete="off">
							<a href="#" role="button" class="btn btn-success hvr-icon-float-away m-1" id="confirmPostBtn"><i class="fas fa-check-double fa-fw hvr-icon"></i></a>
							<a href="#" role="button" class="btn btn-danger hvr-icon-buzz-out m-1" id="cancelPostBtn"><i class="fas fa-times fa-fw hvr-icon"></i></a>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3">
		<div class="jumbotron p-4">
				<h4 class="mb-3">Your saved creations</h4>
				<div class="d-flex flex-column">
				<?php if (empty($created_images))
					echo '<span class="text-muted">You have no saved snapshots, go to your profile to see the ones you\'ve posted.</span>';
				foreach (array_reverse($created_images) as $created_image) {
					$img_name = explode('/', $created_image->upl_url);
					$img_name = preg_replace("/.jpg|.jpeg|.png/", "", end($img_name));
					echo '<div class="container" style="max-width: 300px;">
						<div class="container position-relative user-uploads p-0">
							<form method="POST" id="postForm">
								<input id="postDescription" type="text" name="img_description" class="d-none" value="">
								<a role="button" href="#" onclick="postSavedImage(\'' . $img_name . '\');">
									<i class="fas fa-check-circle fa-2x bg-success rounded-circle text-white position-absolute hvr-grow" title="Post to profile"></i>
								</a>
							</form>
							<a role="button" href="./deleteupload/' . $img_name . '/upload">
								<i class="fas fa-times-circle fa-2x bg-danger rounded-circle text-white position-absolute hvr-grow" title="Delete"></i>
							</a>
							<img class="img-thumbnail mb-2" src="' . URL . $created_image->upl_url . '">
						</div>
					</div>';
				} ?>
				</div>
				<div class="mt-4 mb-2">
					<a class="btn btn-primary" href="<?= URL; ?>profile/view" role="button">View your profile</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= URL; ?>public/js/stickerCarousel.js"></script>
<script type="text/javascript" src="<?= URL; ?>public/js/studio.js"></script>