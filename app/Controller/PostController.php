<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class PostController extends Controller
{
	private $_userData;

	public function __construct() {
		if (!empty($_SESSION["user_id"]) && !empty($_SESSION["user_username"]))
			$this->_userData = $this->fetchUserData();
	}

	public function index($img_id = false) {
		$this->view($img_id);
	}

	public function view($img_id = false) {
		if (empty($img_id)) {
			Alert::warning_alert("No image information provided.");
			header("Location: " . URL);
			exit;
		} else {
			$imageManager = new \Camagru\Model\ImageManager();
			if ($imageManager->checkImageActive($img_id) == 0)
				Alert::failure_alert("The image you requested does not exist.", URL);
			$commentManager = new \Camagru\Model\CommentManager();
			$likeManager = new \Camagru\Model\LikeManager();
			$array["image"] = $imageManager->fetchImage($img_id);
			$array["comments"] = $commentManager->fetchPostComments($img_id);
			$array["likes"] = $likeManager->fetchPostLikes($img_id);
			$this->set($array);
			$this->render("index");
		}
	}

	public function editDescription() {	
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		$this->secureForm($_POST);
		$tmp = explode('/', $_POST["new_description"]);
		$imageId = $tmp[0];
		if (!empty($imageId)) {
			$newDescription = $tmp[1];
			$imageManager = new \Camagru\Model\ImageManager();
			$imageData = new \Camagru\Model\Image([
				"img_id" => $imageId,
				"img_description" => $newDescription,
				"img_usr_id" => $_SESSION["user_id"]
			]);
			if ($imageManager->checkImageOwnership($imageData)) {
				if ($imageManager->updateImageDescription($imageData)) {
					Alert::success_alert("Your image's description was successfully updated.");
					header("Location: " . URL . "post/view/". $imageId);
				} else
					Alert::failure_alert("Your image couldn't be deleted.", URL . "post/view/". $imageId);
			} else
				Alert::failure_alert("There was a problem validating the image.", URL . "post/view/". $imageId);
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}

	public function deletePost() {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		if (!empty($_POST) && !empty($_POST["delete_img"])) {
			$this->secureForm($_POST);
			$imageManager = new \Camagru\Model\ImageManager();
  			$imageData = new \Camagru\Model\Image([
				"img_id" => $_POST["delete_img"],
				"img_usr_id" => $_SESSION["user_id"]
			]);
			if ($imageManager->checkImageOwnership($imageData)) {
				$imageName = $imageManager->getImageName($imageData);
				if (unlink("public/img/userupload/" . $imageName->img_name)
					&& $imageManager->updateUploadActive($this->_userData, 0, $imageName->img_name)
					&& $imageManager->deactivateImage($imageData)) {
					Alert::success_alert("Your post was successfully deleted.");
		  			header("Location: " . URL . "profile/view/". $this->_userData->usr_login());
				} else
					Alert::failure_alert("Your post couldn't be deleted.", URL . "profile/view/". $this->_userData->usr_login());
			} else
				Alert::failure_alert("There was a problem validating the image.", URL . "profile/view/". $this->_userData->usr_login());
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
    }

	public function processComment() {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			if (!empty($_POST["cmt_body"])) {
				$imageId = intval($_POST["cmt_img_id"]);
				$commentBody = $_POST["cmt_body"];
				$imageManager = new \Camagru\Model\ImageManager();
				$userManager  = new \Camagru\Model\UserManager();
				if ($imageManager->checkImageActive($imageId)) {
					$commentManager = new \Camagru\Model\CommentManager();
					if ($commentManager->newComment($this->_userData->usr_id(), $imageId, $commentBody)) {
						$imageOwnerLogin = $imageManager->fetchImage($imageId)->usr_login;
						$imageOwner = new \Camagru\Model\User(
							['usr_login' => $imageOwnerLogin]
						);
						$imageOwnerInfo = $userManager->getUser($imageOwner);
						if ($imageOwnerInfo->usr_cmt_sendmail() == 1
							&& $this->_userData->usr_login() != $imageOwnerLogin) {
							$sendMail = new \Camagru\Lib\Mail($imageOwnerInfo->usr_email());
							$sendMail->newCommentMail($this->_userData->usr_login(), $imageOwnerLogin, $imageId, $commentBody);
						}
						header('Location: ' . URL . "post/view/" . $imageId);
					} else
						Alert::failure_alert("Your comment couldn't be posted.", URL . "post/view/" . $imageId);
				} else
					Alert::failure_alert("This image doesn't exist.", URL . "post/view/" . $imageId);
			} else
				Alert::failure_alert("You can't post an empty comment.", URL . "post/view/" . $_POST["cmt_img_id"]);
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}

	public function deleteComment(int $img_owner = null) {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$data = explode('/', $_POST["cmt_id_img_id"]);
			$imageId = intval($data[0]);
			$commentId = intval($data[1]);
			$commentManager = new \Camagru\Model\CommentManager();
			$imageManager = new \Camagru\Model\ImageManager();
			$imageData = new \Camagru\Model\Image([
				"img_id"     => $imageId,
				"img_usr_id" => $_SESSION['user_id']
			]);
			$ownership = null;
			$ownership = $img_owner === 1 ? $imageManager->checkImageOwnership($imageData)
			: $commentManager->checkCommentOwnership($commentId, $this->_userData->usr_id());
			if ($ownership) {
				if ($commentManager->deactivateComment($commentId, $imageId))
					header('Location: ' . URL . "post/view/" . $imageId);
				else	
					Alert::failure_alert("Your comment couldn't be deleted.", URL . "post/view/" . $imageId);
			} else
				Alert::failure_alert("There was a problem validating the comment.", URL . "post/view/" . $imageId);
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}

	public function processLike() {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$imageId = intval($_POST["lik_img_id"]);
			$imageManager = new \Camagru\Model\ImageManager();
			$userManager  = new \Camagru\Model\UserManager();
			if ($imageManager->checkImageActive($imageId)) {
				$likeManager = new \Camagru\Model\LikeManager();
				$toggleLike = $likeManager->checkLike($this->_userData->usr_id(), $imageId);
				switch ($toggleLike) {
					case 0:
						$imageOwnerLogin = $imageManager->fetchImage($imageId)->usr_login;
						$imageOwner = new \Camagru\Model\User(['usr_login' => $imageOwnerLogin]);
						$imageOwnerInfo = $userManager->getUser($imageOwner);
						if ($imageOwnerInfo->usr_lik_sendmail() == 1
							&& $this->_userData->usr_login() != $imageOwnerLogin) {
							$sendMail = new \Camagru\Lib\Mail($imageOwnerInfo->usr_email());
							$sendMail->newLikeMail($this->_userData->usr_login(), $imageOwnerLogin, $imageId);
						}
						$likeManager->toggleLike($this->_userData->usr_id(), $imageId, 1);
						break;
					case 1:
						$likeManager->toggleLike($this->_userData->usr_id(), $imageId, 0);
						break;
				}
				header('Location: ' . URL . "post/view/" . $imageId);
			}
			else
				Alert::failure_alert("This image doesn't exist.", URL . "post/view/" . $imageId);
		}
		else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}
}