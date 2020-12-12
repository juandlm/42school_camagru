<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Camagru - 
		<?php
			if ($title == 'Home')
				echo 'Your face is worth seeing';
			else
				echo $title; ?>
	</title>
	<link rel="apple-touch-icon" sizes="180x180" href="<?= URL; ?>public/img/ico/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= URL; ?>public/img/ico/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= URL; ?>public/img/ico/favicon-16x16.png">
	<link rel="manifest" href="<?= URL; ?>public/img/ico/site.webmanifest">
	<link rel="mask-icon" href="<?= URL; ?>public/img/ico/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="<?= URL; ?>public/img/ico/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="<?= URL; ?>public/img/ico/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<link href="<?= URL; ?>public/css/style.css" rel="stylesheet">
	<link href="<?= URL; ?>public/css/hover.css" rel="stylesheet">
	<link href="<?= URL; ?>public/css/colors.css" rel="stylesheet">
</head>
<style>
.navbar-collapse.collapse {
	display: none;
}
.cmg-nav-btns .badge-info {
	top: -5px;
}
</style>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top p-0 px-4">
		<a class="navbar-brand logo" href="<?= URL; ?>">Camagru</a>
		<button class="navbar-toggler mobile-btn" type="button" data-toggle="collapse" data-target=".cmg-collapse">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="navbar-collapse collapse">
				<div class="mx-auto my-2">
					<form method="POST" class="form-inline input-group" action="<?= URL; ?>search" style="width: 250px;">
						<input class="form-control" type="search" placeholder="Explore" name="search" required>
						<div class="input-group-append">
							<button class="btn btn-light" type="submit"><i class="fas fa-search"></i></button>
						</div>
					</form>
				</div>
				<?php if (!empty($_SESSION['user_username'])) { ?>
				<div class="cmg-nav-btns my-3">
					<a class="btn btn-light mr-3 position-relative" href="<?= URL; ?>newpost" role="button">
						<i class="far fa-image fa-lg fa-fw"></i><span class="badge badge-info position-absolute"><i class="fas fa-plus"></i></span>
					</a>
					<label class="cmg-dropdown m-0">
						<div class="btn btn-light">
							<i class="fas fa-user mr-2"></i><?= $_SESSION['user_username']; ?>
						</div>
						<input type="checkbox" class="cmg-dropdown-input">
						<ul class="cmg-dropdown-menu">
							<li><a class="dropdown-item" href="<?= URL; ?>profile"><i class="fas fa-id-badge mr-2"></i>My Profile</a></li>
							<li><a class="dropdown-item" href="<?= URL; ?>newpost"><i class="fas fa-plus-square mr-2"></i>New Post</a></li>
							<li><a class="dropdown-item" href="<?= URL; ?>userpanel"><i class="fas fa-cog mr-2"></i>Settings</a></li>
							<div class="dropdown-divider"></div>
							<li><a class="nav-link" href="<?= URL; ?>userpanel/disconnect"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
						</ul>
					</label>
				</div>
				<?php } else { ?>
				<div class="my-3">
					<a class="btn btn-light mr-3" href="<?= URL; ?>login" role="button">Login</a>
					<a class="btn btn-light" href="<?= URL; ?>register" role="button">Register</a>
				</div>
				<?php } ?>
		</div>
	</nav>
	<main role="main" class="container">
		<div class="starter-template">
			<?php if ($crumb) { ?>
			<nav>
				<ol class="breadcrumb">
					<?php
						$crumb = explode('/', $crumb);
						foreach ($crumb as $k) {
							echo '<li class="breadcrumb-item ';
							if ($k == end($crumb))
								echo 'active">' . $k;
							else {
								echo '"><a href="' . URL;
								if ($k != $crumb[0])
									echo strtolower(str_replace(' ', '', $k)) . '/';
								echo '">';
								echo $k . '</a>';
							}
							echo '</li>';
						}
						?>
				</ol>
			</nav>
			<hr class="my-3">
			<?php }
			include('alerts.php');
			echo $content_for_layout;
			?>
		</div>
	</main>
	<footer class="navbar fixed-bottom navbar-dark bg-dark">
		<span class="navbar-text copyright">
		<img alt="footer logo" id="footer-logo" class="mx-2" src="<?= URL; ?>public/img/logo.svg">Camagru © 2019<span class="mx-2">-</span><a href="https://juan.digital">Juan De la Mata</a>
		</span>
	</footer>
</body>
<script src="<?= URL; ?>public/js/alerts.js"></script>
<script>
// Navbar and dropdowns
var toggle = document.getElementsByClassName('navbar-toggler')[0],
    collapse = document.getElementsByClassName('navbar-collapse')[0],
    dropdowns = document.getElementsByClassName('cmg-dropdown');;

// Toggle if navbar menu is open or closed
function toggleMenu() {
	collapse.classList.toggle('collapse');
	collapse.classList.toggle('in');
}

// Close all dropdown menus
function closeMenus() {
    for (var j = 0; j < dropdowns.length; j++)
		dropdowns[j].getElementsByClassName('cmg-dropdown-input')[0].checked = false;
}

// Close dropdowns when screen becomes big enough to switch to open by hover
function closeMenusOnResize() {
    if (document.body.clientWidth >= 768) {
        closeMenus();
        collapse.classList.add('collapse');
        collapse.classList.remove('in');
    }
}

// Event listeners
window.addEventListener('resize', closeMenusOnResize, false);
toggle.addEventListener('click', toggleMenu, false);
</script>
</html>