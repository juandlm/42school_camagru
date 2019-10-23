<?php
	$title = 'Email Preferences';
	$crumb = 'Home/User Panel/' . $title;
?>
<div class="container mx-auto w-100 row">
	<div class="col">
		<div class="card" style="width: 25rem;">
			<img src="<?= URL; ?>public/img/email.jpg" class="card-img-top" alt="...">
			<div class="card-body">
				<h5 class="card-title">You're currently getting notifications for</h5>
				<form action="<?= URL; ?>userpanel/processPreferences" method="POST">
					<div class="form-group">
						<div class="custom-control custom-switch">
							<input type="checkbox" name="pcomments" class="custom-control-input" <?php if (isset($_SESSION["prefComment"]) && $_SESSION["prefComment"] == 1)	echo 'checked';?> id="customSwitch1" >
							<label class="custom-control-label" for="customSwitch1">Photo comments</label>
						</div>
						<div class="custom-control custom-switch">
							<input type="checkbox" name="plikes" class="custom-control-input" <?php if (isset($_SESSION["prefLike"]) && $_SESSION["prefLike"] == 1)	echo 'checked';?> id="customSwitch2">
							<label class="custom-control-label" for="customSwitch2">Photo likes</label>
						</div>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
	<div class="col text-center jumbotron" style="height: 18rem;">
		<p class="lead">Change how you want to be notified</p>
		<hr class="my-4">
		<p>Toggle email notifications for likes and comments on or off.</p>
	</div>
</div>