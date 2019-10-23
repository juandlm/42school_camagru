<?php
	$title = $name . " (@" . $username . ")";
	$crumb = false;
	$own_profile = false;
	if (!empty($_SESSION['user_id']) && !empty($_SESSION['user_username'])
		&& (strstr($_SERVER['REQUEST_URI'], $_SESSION['user_username']) == $_SESSION['user_username']))
		$own_profile = true;
?>
<style>
.cmg-profile-info {
	font-size: 12px;
}
.cmg-profile-info span {
	font-size: 15px;
	font-weight: 600;
}
.upload-btn-wrapper {
	position: relative;
	overflow: hidden;
	display: inline-block;
}
.upload-btn-wrapper input {
	position: absolute;
	left: 0;
	top: 0;
	opacity: 0;
	width: 100%;
	height: 100%;
	cursor: pointer;
}
@media (max-width: 992px) {
	.profile-head {
		width: 75%!important;
	}
}
</style>
<div class="jumbotron">
	<form method="POST" action="<?= URL; ?>profile/processEdit" class="mb-2">
		<div class="row">
			<div class="col-lg-4">
				<div class="container text-center mb-3">
					<a <?= $own_profile ? 'id="pPic" href="#"' : ''; ?>>
						<svg viewBox="0 0 1 1" width="75%" height="75%" class="rounded-circle">
							<image id="pPicImg" xlink:href="<?= URL . $profilepic; ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
						</svg>
						<div id="pPicSpinner" class="m-5 spinner-border text-primary d-none" role="status"></div>
					</a>
					<?php if ($own_profile) { ?>
					<div id="pPicModal" class="modal d-none" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content p-3">
								<h5 class="modal-title">Change profile picture</h5>
								<div class="modal-body">
									<ul class="list-group">
										<li class="list-group-item upload-btn-wrapper"><input type="file" name="imageToUpload" id="imgUl" accept="image/*" title=""><span class="font-weight-bold text-primary">Upload a picture<span></li>
										<li class="list-group-item upload-btn-wrapper"><input type="button" onclick="window.location='<?= URL; ?>profile/resetProfilePicture';"><span class="font-weight-bold text-danger">Delete your current picture</span></li>
										<li class="list-group-item closemodal text-muted">Cancel</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="profile-head mx-auto mx-lg-0">
					<div id="profileTitle">
						<h5 id="userName"><?= $name; ?></h5>
						<h6 id ="userBio" class="text-primary font-weight-light"><?= $bio; ?></h6>
						<input id="editNameField" name="profilename" class="form-control mb-1 d-none" type="text" placeholder="Display name" value="<?= $name; ?>">
						<input id="editBioField" name="profilebio" class="form-control form-control-sm d-none" type="text" placeholder="Bio" value="<?= $bio; ?>">
					</div>
					<?php if ($own_profile) {?>
					<div id="profilebtns" class="mt-2 mb-3">
						<button id="editBtn" type="button" class="btn btn-outline-primary btn-sm">Edit Profile</button>
						<button id="saveBtn" type="submit" class="btn btn-primary btn-sm d-none">Save</button>
						<button id="cancelBtn" type="button" class="btn btn-danger btn-sm d-none">Cancel</button>
					</div>
					<?php } ?>
					<div class="cmg-profile-info text-muted">
						<p class="text-uppercase">Member since: <span><?= date("Y-m-d", strtotime($membersince)); ?></span></p>
						<!-- <p class="text-uppercase">Followers: <span>99M</span></p>
						<p class="text-uppercase">Following: <span>0</span></p> -->
					</div>
				</div>
			</div>
		</div>
	</form>
	<hr>
	<div class="d-flex flex-wrap">
	<?php
	foreach ($images as $image) {
		echo '<div class="p-1 p-lg-3" style="flex: 0 0 calc(100%/3);">
				<a href="'. URL . 'post/view/' . $image->img_id . '">
					<svg viewBox="0 0 1 1">
						<image xlink:href="' . URL . 'public/img/userupload/' . $image->img_name . '" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
					</svg>
				</a>
			</div>';
	}
	?>
	</div>
</div>
<script type="text/javascript">
var userNameValue = "<?= $name; ?>",
	userBioValue = "<?= $bio; ?>";
</script>
<script type="text/javascript" src="<?= URL; ?>public/js/profile.js"></script>
<script type="text/javascript" src="<?= URL; ?>public/js/upload.js"></script>