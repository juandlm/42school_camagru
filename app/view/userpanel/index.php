<?php
	$title = 'User Panel';
	$crumb = 'Home/' . $title;
?>
<div class="container-fluid">
    <div class="row text-center">
		<div class="col">
			<a href ="<?= URL; ?>userpanel/emailpreferences" class="hvr-icon-bob">
				<div class="card text-white bg-dark">
					<div class="card-body">
						<i class="fas fa-envelope fa-7x my-3 hvr-icon"></i>
						<h5>Email preferences</h5>
						<hr class="border-top border-white w-75">
						<p class="font-weight-light">Change how you want to be notified</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col">
			<a href ="<?= URL; ?>userpanel/editaccount" class="hvr-icon-bob">
				<div class="card text-white bg-dark">
					<div class="card-body">
						<i class="fas fa-user-edit fa-7x my-3 hvr-icon"></i>
						<h5>Edit account</h5>
						<hr class="border-top border-white w-75">
						<p class="font-weight-light">Change your account information</p>
					</div>
				</div>
			</a>
		</div>
		<div class="col">
			<a href ="<?= URL; ?>userpanel/deactivateaccount" class="hvr-icon-bob">
				<div class="card text-white bg-dark">
					<div class="card-body">
						<i class="fas fa-user-slash fa-7x my-3 hvr-icon"></i>
						<h5>Deactivate account</h5>
						<hr class="border-top border-white w-75">
						<p class="font-weight-light">Disable your profile and pictures</p>
					</div>
				</div>
			</a>
		</div>
    </div>
</div>