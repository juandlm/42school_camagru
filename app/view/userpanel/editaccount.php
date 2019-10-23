<?php
	$title = 'Edit Account';
	$crumb = 'Home/User Panel/' . $title;
?>
<div class="container mx-auto w-75">
	<small class="form-text text-muted pb-3">In order to edit your account data, simply fill the fields corresponding to the information you'd like to change.</small>
	<form action="<?= URL; ?>userpanel/processEdit" method="POST">
		<div class="form-group mb-5">
			<label>Enter your password</label><span class="ml-2 badge badge-info">Required</span>
			<input type="password" name="password" class="form-control" placeholder="Your current password" required autofocus>
		</div>
		<div class="form-group">
			<label>Change your username</label>
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="inputUsernamePrepend">@</span>
				</div>
				<input type="username" class="form-control" name="new_username" placeholder="Username">
			</div>
		</div>
		<div class="form-group">
			<label>Change your email address</label>
			<div class="input-group">
				<input type="email" class="form-control" name="new_email" id="inputUsername" placeholder="mail@example.com">
			</div>
		</div>
		<div class="form-group">
			<label>Change your password</label>
			<input type="password" name="new_password" class="form-control" id="exampleInputPassword1" placeholder="New password">
		</div>
		<small class="form-text text-muted fa-xs">
			<ul class="text-left fa-ul">
				<li>
					<i class="fa-li fa fa-check text-info"></i>Must be between 6 and 16 characters long
				</li>
				<li>
					<i class="fa-li fa fa-check text-info"></i>Must contain at least one uppercase letter, one lowercase letter and one digit
				</li>
			</ul>
		</small>		
		<div class="form-group">
			<label>Confirm your new password</label>
			<input type="password" name="cnew_password" class="form-control" id="exampleInputPassword1" placeholder="New password">
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>