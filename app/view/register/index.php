<?php
	$title = 'Register';
	$crumb = 'Home/' . $title;
?>
<div class="container row mx-auto">
	<div class="col-xl-6 mb-4">
		<form action="<?= URL; ?>register/processRegistration" method="POST">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Username</label>
				<div class="col-sm-10">
					<div class="input-group">
						<div class="input-group-prepend">
						<span class="input-group-text">@</span>
						</div>
						<input type="username" class="form-control" name="username" placeholder="Your username" value="<?= (isset($_SESSION['save_username'])) ? $_SESSION['save_username'] : '' ?>" required autofocus>
					</div>
					<small class="form-text text-muted fa-xs">
						<ul class="text-left fa-ul">
							<li>
								<i class="fa-li fa fa-check text-info"></i>Must be between 2 and 20 characters long
							</li>
							<li>
								<i class="fa-li fa fa-check text-info"></i>Can only contain alphanumeric (aA-zZ and 0-9) and underscore (_) characters
							</li>
						</ul>
					</small>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
				<input type="email" class="form-control" name="email" placeholder="me@email.com" value="<?= (isset($_SESSION['save_email'])) ? $_SESSION['save_email'] : '' ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-10">
				<input type="password" class="form-control" name="password" placeholder="Password" required>
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
				</div>
			</div>
			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
				<div class="col-sm-10">
				<input type="password" class="form-control" name="passwordconfirm" placeholder="Confirm your password" required>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-10">
				<div class="form-check">
					<small class="form-text text-muted pb-3">
						<input class="form-check-input" type="checkbox" name="toscheck" required>
						<label class="form-check-label" for="toscheck">
						I accept the <a href ="<?= URL; ?>home/termsofservice">Terms of Service</a>.
						</label>
					</small>
				</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-10">
				<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</form>
	</div>
	<div class="col text-center">
		<img src="<?= URL . 'public/img/register.png'; ?>" class="img-fluid">
	</div>
</div>