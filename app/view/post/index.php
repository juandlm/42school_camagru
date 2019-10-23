<?php
use Camagru\Lib\Helper;
$title = 'Home';
$crumb = false;
$logged_in = false;
$own_image = false;
$liked = false;
if (!empty($_SESSION['user_id']) && !empty($_SESSION['user_username'])) {
	$logged_in = true;
	if (strcmp($image->img_usr_id, $_SESSION['user_id']) === 0
		&& strcmp($image->usr_login, $_SESSION['user_username']) === 0)
		$own_image = true;
	foreach ($likes as $like) {
		if (strcmp($_SESSION["user_id"], $like->lik_usr_id) === 0) {
			$liked = true;
			break;
		}
	}
}
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
@media (min-width: 992px) {
	.cmg-comments.card {
		border: 0;
		border-top: 1px solid rgba(0,0,0,.125);
		border-right: 1px solid rgba(0,0,0,.125);
		border-bottom: 1px solid rgba(0,0,0,.125);
		border-radius: 0;
		border-top-right-radius: 0.25rem;
		border-bottom-right-radius: 0.25rem;
	}
	.cmg-image.card {
		border-radius: 0;
		border-top-left-radius: 0.25rem;
		border-bottom-left-radius: 0.25rem;
	}
}
@media (max-width: 992px) {
	.cmg-comments.card {
		border: 0;
		border-top: 2px solid rgba(0,0,0,.125);
		border-right: 1px solid rgba(0,0,0,.125);
		border-bottom: 1px solid rgba(0,0,0,.125);
		border-left: 1px solid rgba(0,0,0,.125);
		border-radius: 0;
		border-bottom-right-radius: 0.25rem;
		border-bottom-left-radius: 0.25rem;
	}
	.cmg-image.card {
		border-radius: 0;
		border-top-left-radius: 0.25rem;
		border-top-right-radius: 0.25rem;
	}
	.cmg-post {
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
	}
}
/* Custom Pop */
@-webkit-keyframes cmg-pop {
  50% {
    -webkit-transform: scale(1.2);
    transform: scale(1.2);
  }
}
@keyframes cmg-pop {
  50% {
    -webkit-transform: scale(1.2);
    transform: scale(1.2);
  }
}
.cmg-pop {
  display: inline-block;
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
}
.cmg-pop-click {
  -webkit-animation-name: cmg-pop;
  animation-name: cmg-pop;
  -webkit-animation-duration: 0.3s;
  animation-duration: 0.3s;
  -webkit-animation-timing-function: linear;
  animation-timing-function: linear;
  -webkit-animation-iteration-count: 1;
  animation-iteration-count: 1;
}
#postImage i.fa-thumbs-up {
	bottom: 50%;
	left: 50%;
	opacity: 0;
	text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
	transform: translate(-50%, 50%);
	visibility: hidden;
	transition: all 0.1s linear;
}
.post-interactions i {
	font-size: 1.5em;
}
.post-interactions #commentIcon {
	cursor: pointer;
}
.post-interactions #likeIcon {
	width: 100%;
	height: 100%;
	opacity: 0;
	top: 0;
	left: 0;
	position: absolute;
}
li.cmg-comment {
	display: flex;
}
ul.cmg-comment-list {
	height: 650px;
	width: 100%;
	overflow-y: scroll;
	scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE 10+ */
}
ul.cmg-comment-list::-webkit-scrollbar { /* WebKit */
    width: 0;
    height: 0;
}
#likesModal ul {
	height: 250px;
	scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE 10+ */
}
#likesModal ul::-webkit-scrollbar { /* WebKit */
    width: 0;
    height: 0;
}
#deleteCommentBtn {
	visibility: hidden;
	opacity: 0;
	transition: all 0.3s ease;
	top: 3px;
	right: 3px;
}
.cmg-comments:hover #deleteCommentBtn {
	visibility: visible;
	opacity: 0.3;
	transition: all 0.3s ease;
}
#deleteCommentBtn:hover {
	color: #dc3545;
	opacity: 1!important;
	transition: all 0.3s ease;
}
i.fa-ellipsis-v {
	top: 20px;
	right: 18px;
	position: absolute;
	visibility: visible;
	opacity: 0.3;
	transition: all 0.3s ease;
}
i.fa-ellipsis-v:hover {
	visibility: visible;
	opacity: 1;
	transition: all 0.3s ease;
	cursor: pointer;
}
.cmg-modal-wrapper {
	position: relative;
	overflow: hidden;
	display: inline-block;
	cursor: pointer;
}
.cmg-modal-wrapper input {
	position: absolute;
	left: 0;
	top: 0;
	opacity: 0;
	width: 100%;
	height: 100%;
	cursor: pointer;
}
</style>
<div class="container">
	<div class="cmg-post mx-auto d-flex px-5">
		<div class="card cmg-image flex-grow-1">
			<div class="card-header position-relative p-2">
				<a class="mr-1" href="<?= URL . "profile/view/" . $image->usr_login; ?>">
					<svg viewBox="0 0 1 1" width="40px" height="100%" class="rounded-circle img-thumbnail">
							<image xlink:href="<?= URL . $image->usr_ppic; ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
					</svg>
				</a>
				<a href="<?= URL . "profile/view/" . $image->usr_login; ?>" class="font-weight-bold"><?= $image->usr_login; ?></a>
				<?php if ($own_image): ?>
				<i id="editPostBtn" class="fas fa-ellipsis-v fa-lg"></i>
				<div id="postModal" class="modal text-center d-none" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content p-3">
								<form method="POST" class="modal-body" autocomplete="off">
									<ul class="list-group">
										<li class="list-group-item cmg-modal-wrapper">
											<input id="newDescription" name="new_description" type="text" class="form-control" placeholder="" autocomplete="off" onclick="editDescription('<?= URL; ?>post/editDescription', '<?= $image->img_id; ?>', '<?= $image->img_description; ?>');" value=""><span class="font-weight-bold text-primary">Edit description<span>
										</li>
										<li class="list-group-item cmg-modal-wrapper">
											<input type="submit" name="delete_img" value="<?= $image->img_id; ?>" onclick="deletePost('<?= URL; ?>post/deletePost');"><span class="font-weight-bold text-danger">Delete post</span>
										</li>
										<li class="list-group-item closemodal text-muted">Cancel</li>
									</ul>
								</form>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div id="postImage" class="position-relative">
				<img class="card-img rounded-0" src ="<?= URL . 'public/img/userupload/' . $image->img_name; ?>" alt="">
				<i class="fas fa-thumbs-up fa-5x position-absolute text-white"></i>
			</div>
			<div class="card-body p-3 position-relative">
				<?php if ($logged_in) { ?>
				<div class="post-interactions">
					<form method="POST" id="interactionsForm" class="position-relative d-inline-block" action="<?= URL; ?>post/processLike">
						<i class="far fa-thumbs-up fa-fw text-dark cmg-pop mr-1 pb-2 <?= $liked ? "d-none" : '' ?>"></i>
						<i class="fas fa-thumbs-up fa-fw text-success cmg-pop mr-1 pb-2 <?= $liked ? '' : "d-none" ?>"></i>
						<input id="likeIcon" type="submit" name="lik_img_id" placeholder="" value="<?= $image->img_id ?>">
					</form>
					<span id="commentIcon">
						<i class="far fa-comment fa-fw text-dark"></i>
					</span>
				</div>
				<?php } if (!empty($likes)) { ?>
				<small class="text-muted">Liked by <a id="likesAmount" href="#" class="font-weight-bold text-dark"><?= (($nbLikes = count($likes)) > 1) ? $nbLikes . " people" : $nbLikes . " person"; ?></a></small>
				<div id="likesModal" class="modal d-none" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content p-3">
							<h5 class="modal-title text-center">Likes</h5>
							<div class="modal-body">
								<ul class="list-unstyled list-group-item overflow-auto w-100">
									<?php foreach ($likes as $like): ?>
									<li class="d-flex flex-wrap mb-2">
										<div class="w-100">
											<a class="mr-1" href="<?= URL . 'profile/view/' . $like->usr_login; ?>">
												<svg viewBox="0 0 1 1" width="40px" height="100%" class="rounded-circle img-thumbnail">
													<image xlink:href="<?= URL . $like->usr_ppic ?>" width="100%" height="100%" preserveAspectRatio="xMidYMid slice"/>
												</svg>
											</a>
											<a href="<?= URL . 'profile/view/' . $like->usr_login; ?>" class="font-weight-bold w-100"><?= $like->usr_login; ?></a>
										</div>
										<small class="ml-5 mt-n3 text-muted"><?= $like->usr_name ?></small>
									</li>
									<?php endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<?php } if (!empty($image->img_description)) { ?>
				<p class="card-title mt-2">
					<a href="<?= URL . 'profile/view/' . $image->usr_login; ?>" class="font-weight-bold mr-1"><?= $image->usr_login; ?></a><?= $image->img_description ?>
				</p>
				<?php } ?>
				<p class="card-text mt-4">
					<span class="text-uppercase text-muted" title="<?= $image->img_dtcrea ?>"><small><?= Helper::time_elapsed_string($image->img_dtcrea); ?></small></span>
				</p>
			</div>
		</div>
		<div class="card cmg-comments flex-grow-1">
			<div class="card-body">
				<ul class="cmg-comment-list list-unstyled">
					<?php if (empty($comments)) {
						echo '<li class="text-muted">No comments. Be the first!</li>';
					} else {
						if ($logged_in) {
							foreach ($comments as $key => $comment) {
								if ($comment->usr_login == $_SESSION['user_username']) {
									$own_comment = $comments[$key];
									unset($comments[$key]);
									array_unshift($comments, $own_comment);
								}
							}
						}
						foreach ($comments as $comment): ?>
						<li class="cmg-comment mb-2 d-none position-relative">
							<?php if ($own_image || ($logged_in && strcmp($comment->usr_id, $_SESSION['user_id']) === 0
								&& strcmp($comment->usr_login, $_SESSION['user_username']) === 0)) {
									echo '<form method="POST" action="' . URL . "post/deletecomment"; 
									if ($own_image)
										echo '/1';
									echo '">
										<button id="deleteCommentBtn" type="submit" class="btn position-absolute p-0" name="cmt_id_img_id" value="' . $comment->cmt_img_id . "/" . $comment->cmt_id . '">
											<i class="fa fa-times"></i>
										</button>
									</form>';
							}?>
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
						<?php endforeach; ?>
						<span id="loadMore" class="d-none"><a href="#" class="font-weight-bold text-muted">Load more</a></span>
					<?php } ?>
				</ul>
			</div>
			<?php if ($logged_in) { ?>
			<div class="card-footer cmg-addcomment">
				<form method="POST" action="<?= URL; ?>post/processComment" class="input-group">
					<textarea class="w-25" placeholder="Add a comment..." autocomplete="off" autocorrect="off" name="cmt_body"></textarea>
					<div class="input-group-append">
						<button id="postCommentBtn" class="btn font-weight-bold text-primary" type="submit" name="cmt_img_id" value="<?= $image->img_id ?>" >Post</button>
					</div>
				</form>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= URL; ?>public/js/post.js"></script>