<?php 
	$title = 'Login';
	$crumb = 'Home/' . $title;
?>
<div class="container row mx-auto">
	<div class="col text-center mb-4">
		<img src="<?= URL . 'public/img/login.png'; ?>" class="img-fluid">
	</div>
	<div class="col-md-6">
		<form action="<?= URL; ?>login/processLogin" method="POST">
			<div class="form-group">
				<label for="exampleInputUsername1">Username</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text" id="inputUsernamePrepend">@</span>
					</div>
					<input type="username" name="username" class="form-control" id="exampleInputUsername1" placeholder="Enter username" required autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
			</div>
			<small id="passwordHelp" class="form-text text-muted pb-3">Forgot your password? <a href="<?= URL; ?>login/forgotpassword">Click here.</a></small>
			<div class="form-group form-check">
				<input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Remember me</label>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</div>