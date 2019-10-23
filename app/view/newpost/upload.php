<?php
	$title = 'Upload an Image';
	$crumb = 'Home/New Post/' . $title;
?>
<style>
.faux-hvr-grow {
	display: inline-block;
	vertical-align: middle;
	-webkit-transform: perspective(1px) translateZ(0);
	transform: perspective(1px) translateZ(0);
	box-shadow: 0 0 1px rgba(0, 0, 0, 0);
	-webkit-transition-duration: 0.3s;
	transition-duration: 0.3s;
	-webkit-transition-property: transform;
	transition-property: transform;
	-webkit-transform: scale(1.1);
	transform: scale(1.1);
}
[type="file"]{
	position: absolute;
	left: 0;
	top: 0;
	opacity: 0;
	width: 100%;
	height: 100%;
	cursor: pointer;
}
#uploadedImg img {
	height: 40vh;
	width: auto;
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
		<div class="col-lg-8">
			<div class="card mb-4 text-center">
				<div id="uploadResult" class="card-body d-none">
					<div id="uploadedImg" class="container-fluid p-5 bg-dark rounded-top">
						<img src="" class="img-thumbnail" alt="">
					</div>
					<div id="uploadResultDiag" class="container w-75">
						<p class="card-text mt-3">Upload complete! What do you want to do now?</p>
						<a href="#" role="button" class="btn btn-success hvr-icon-float-away m-2" id="postBtn">
							<i class="fas fa-check-double hvr-icon mr-2"></i>Post to your profile
						</a>
						<a href="#" role="button" class="btn btn-info hvr-icon-up m-2" id="saveBtn">
							<i class="fas fa-save hvr-icon mr-2"></i>Save for later
						</a>
						<a href="#" role="button" class="btn btn-danger hvr-icon-sink-away m-2" id="deleteBtn">
							<i class="fas fa-trash-alt hvr-icon mr-2"></i>Delete
						</a>
					</div>
					<div id="confirmPostDiag" class="pt-3 container-fluid d-none">
						<form method="POST" class="input-group input-group-lg" autocomplete="off">
							<input type="text" class="form-control mr-2" name="img_description" placeholder="Enter a description for your post or leave this empty" autocomplete="off">
							<a href="#" role="button" class="btn btn-success hvr-icon-float-away m-1" id="confirmPostBtn">
								<i class="fas fa-check-double fa-fw hvr-icon"></i>
							</a>
							<a href="#" role="button" class="btn btn-danger hvr-icon-buzz-out m-1" id="cancelPostBtn">
								<i class="fas fa-times fa-fw hvr-icon"></i>
							</a>
						</form>
					</div>
				</div>
				<div id="uploadInput" class="card-body">
					<div id="dropzone" class="container position-relative w-75 p-5 mx-auto border--silver rounded hvr-grow" style="border-style: dashed;">
						<label>
							<i class="fas fa-file-export fa-3x silver"></i>
							<p class="m-0 mt-3 gray"><b>Choose an image</b> or drag it here.</p>
							<input type="file" name="imageToUpload" id="imgUl" accept="image/*" title="">
						</label>
					</div>
					<div class="container">
						<p class="card-text mt-3">Upload an image from your storage for the world to see!</p>
						<ul class="text-left fa-ul">
							<li>
								<i class="fa-li fa fa-info-circle text-primary"></i>Maximum image size is <b>2MB</b>.
							</li>
							<li>
								<i class="fa-li fa fa-info-circle text-primary"></i>Only <b>.jp(e)g</b> and <b>.png</b> images are allowed.
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="jumbotron p-4">
				<h4 class="mb-3">Your saved uploads</h4>
				<div class="d-flex flex-column">
				<?php if (empty($saved_images))
					echo '<span class="text-muted">You have no saved images, go to your profile to see the ones you\'ve posted.</span>';
				foreach (array_reverse($saved_images) as $saved_image) {
					$img_name = explode('/', $saved_image->upl_url);
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
							<img class="img-thumbnail mb-2" src="' . URL . $saved_image->upl_url . '">
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
<script type="text/javascript" src="<?= URL; ?>public/js/upload.js"></script>