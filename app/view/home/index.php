<?php
use Camagru\Lib\Helper;
$title = 'Home';
$crumb = 'Public Gallery';
$logged_in = false;
if (!empty($_SESSION['user_id']) && !empty($_SESSION['user_username']))
	$logged_in = true;
?>

<style>
.cmg-addcomment textarea {
	height: calc(1.5em + .75rem + 2px);
	padding: .375rem .75rem;
	border-style: none;
	border-color: Transparent;
	overflow: hidden;
	outline: none;
	resize: none;
	position: relative;
	-ms-flex: 1 1 auto;
	flex: 1 1 auto;
	background-color: transparent;
}
@media (min-width: 768px) {
	.cmg-comments.card {
		border: 0;
		border-top: 1px solid rgba(0,0,0,.125);
		border-right: 1px solid rgba(0,0,0,.125);
		border-bottom: 1px solid rgba(0,0,0,.125);
		border-radius: 0;
		border-top-right-radius: 0.25rem;
		border-bottom-right-radius: 0.25rem;
	}
	.cmg-post.card {
		border-radius: 0;
		border-top-left-radius: 0.25rem;
		border-bottom-left-radius: 0.25rem;
	}
}

.post-interactions .fas.fa-fw {
	font-size: 1.5em;
}
</style>
<div class="container">
	<?php foreach ($images as $key => $image): ?>
	<div class="row no-gutters mb-4">
		<div class="col-md-6">
			<div class="card cmg-post">
				<div class="card-header p-2">
					<a class="mr-1" href="<?= URL . 'profile/view/' . $image->usr_login; ?>">
						<svg viewBox="0 0 1 1" width="40px" height="100%" class="rounded-circle img-thumbnail">
								<image xlink:href="<?= URL . $image->usr_ppic; ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
						</svg>
					</a>
					<a href="<?= URL . 'profile/view/' . $image->usr_login; ?>" class="font-weight-bold"><?= $image->usr_login; ?></a>
				</div>
				<a href="<?= URL . 'post/view/' . $image->img_id; ?>" title="">
					<img class="card-img rounded-0" src ="<?= URL . 'public/img/userupload/' . $image->img_name; ?>" alt="">
				</a>
				<div class="card-body p-3">
					<div class="post-interactions hvr-bob">
						<a href="<?= $logged_in ? URL . "post/view/" . $image->img_id : URL . "login"; ?>"><i class="fas fa-thumbs-up fa-fw text-dark cmg-pop mr-1 pb-2 hvr-icon"></i></a>
						<a href="<?= $logged_in ? URL . "post/view/" . $image->img_id : URL . "login"; ?>" class=""><i class="fas fa-comment fa-fw text-dark hvr-icon"></i></a>
					</div>
					<?php if (!empty($image->likes)) { ?>
					<br><small class="text-muted">Liked by <a href="<?= URL . "post/view/" . $image->img_id; ?>" class="font-weight-bold text-dark"><?= (($nbLikes = $image->likes) > 1) ? $nbLikes . " people" : $nbLikes . " person"; ?></a></small>
					<?php } if (!empty($image->img_description)) { ?>
					<p class="card-title mt-2 mb-0">
						<a href="<?= URL . 'profile/view/' . $image->usr_login; ?>" class="font-weight-bold mr-1 mb-0"><?= $image->usr_login; ?></a><?= $image->img_description ?>
						<br>
					</p>
					<?php } if (!empty($image->comments)) { ?>
					<div class="m-0 d-md-none"><a href="<?= URL . 'post/view/' . $image->img_id; ?>" class="font-weight-bold text-muted fa-sm">View all comments</a></div>
					<p class="card-text mt-4 d-md-none">
						<a href="#" class="font-weight-bold mr-1"><?= $image->comments[0]->usr_login ?></a><?= $image->comments[0]->cmt_body ?>
					</p>
					<?php } ?>
					<br><a href="<?= URL . 'post/view/' . $image->img_id; ?>" class="text-uppercase text-muted" title="<?= $image->img_dtcrea ?>"><small><?= Helper::time_elapsed_string($image->img_dtcrea); ?></small></a>
				</div>
			</div>
		</div>
		<div class="col-md-6 d-none d-md-block">
			<div class="card h-100 cmg-comments">
				<div class="card-body">
					<ul class="list-unstyled">
						<?php if (empty($image->comments)) {
							echo '<li class="text-muted">No comments. Be the first!</li>';
						} else {
						if ($logged_in) {
							foreach ($image->comments as $key => $comment) {
								if ($comment->usr_login == $_SESSION['user_username']) {
									$own_comment = $image->comments[$key];
									unset($image->comments[$key]);
									array_unshift($image->comments, $own_comment);
								}
							}
						}
						foreach ($image->comments as $comment): ?>
						<li class="cmg-comment mb-2 position-relative">
							<p class="card-text">
								<a class="mr-1" href="<?= URL . 'profile/view/' . $comment->usr_login; ?>">
									<svg viewBox="0 0 1 1" width="40px" height="100%" class="rounded-circle img-thumbnail">
										<image xlink:href="<?= URL . $comment->usr_ppic ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
									</svg>
								</a>
								<a href="<?= URL . 'profile/view/' . $comment->usr_login; ?>" class="font-weight-bold mr-2"><?= $comment->usr_login; ?></a><span><?= $comment->cmt_body; ?></span>
								<br>
								<small class="text-muted font-weight-light ml-5" title="<?= $comment->cmt_dtcrea ?>"><?= Helper::time_elapsed_string($comment->cmt_dtcrea); ?></small>
							</p>
						</li>
						<?php endforeach;
						if (count($image->comments) == 4) { ?>
						<a href="<?= URL . 'post/view/' . $image->img_id; ?>" class="font-weight-bold text-muted">See more</a>
						<?php } ?>
					<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach;
	if (!empty($pages)):?>
	<nav>
		<ul class="pagination justify-content-center">
			<form method="POST" class="form-inline" action=".">
				<li id="previousBtn" class="page-item <?= $pages["current"] == 1 ? "disabled" : '' ?>">
					<button name="page" class="page-link" type="submit" value="<?= ($pages["current"] - 1) ?>">
						<span><i class="fas fa-chevron-left fa-xs"></i></span>
					</button>
				</li>
				<?php for ($i = 1; $i <= $pages["total"]; $i++) { ?>
				<li value="<?= $i ?>" class="pageBtn page-item <?= $pages["current"] == $i ? "active" : '' ?>">
					<button name="page" class="page-link" type="submit" value="<?= $i ?>">
						<?= $i ?>
					</button>
				</li>
				<?php } ?>
				<li id="nextBtn" class="page-item <?= $pages["current"] == $pages["total"] ? "disabled" : '' ?>">
					<button name="page" class="page-link" type="submit" value="<?= ($pages["current"] + 1) ?>">
						<span><i class="fas fa-chevron-right fa-xs"></i></span>
					</button>
				</li>
			</form>
		</ul>
	</nav>
	<?php endif; ?>
</div>