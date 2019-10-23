<?php
	$title = 'Search Results';
	$crumb = $title;
?>
<h2>Users</h2>
<div class="row text-center text-lg-left">
	<?php
		if (empty($users)) {
			echo '<div class="mt-3 col-lg-3 col-md-4 col-6">';
			echo '<p class="text-muted">No results.</p>';
			echo '</div>';
		}
		foreach ($users as $user) {
			echo '<div class="mt-3 col-lg-3 col-md-4 col-6">';
			echo '<a href="' . URL . 'profile/view/' . $user->usr_login . '" class="d-inline mb-4 h-100">';
			echo '<img class="img-fluid img-thumbnail"';
			echo 'src ="' . ($user->usr_ppic != "nopic.png" ? $user->usr_ppic : URL . 'public/img/nopic.png') . '" alt="">';
			echo '</a>';
			echo '<h6 class="text-center mt-1">' . $user->usr_login . '</h6>';
			echo '</div>';
		}
	?>
</div>
<h2 class="mt-3">Hashtags</h2>
<p class="text-muted">No results.</p>