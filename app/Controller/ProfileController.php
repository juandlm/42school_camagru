<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class ProfileController extends Controller
{
	private $_userData;

	public function __construct() {
		if (!empty($_SESSION["user_id"]) && !empty($_SESSION["user_username"]))
			$this->_userData = $this->fetchUserData();
	}

    public function index($username = false) {
		$this->view($username);
	}
	
	public function view($username = false) {
		if (empty($username) && !empty($_SESSION["user_id"]) && !empty($_SESSION["user_username"])) {
			$username = $_SESSION["user_username"];
			header("Location: " . URL . "profile/view/" . $username);
		} else if (empty($username) && empty($_SESSION["user_id"]) && empty($_SESSION["user_username"])) {
			Alert::warning_alert("No user information provided.");
			header("Location: " . URL);
			exit;
		}
		$userManager = new \Camagru\Model\UserManager();
		if ($userManager->existsUser($username, 'NULL') == 0)
			Alert::failure_alert("The user you requested does not exist.", URL);
		$userData = $this->fetchUserData($username);
		if ($userData->usr_active() == 0)
			Alert::failure_alert("The user's account you requested is not active.", URL);
		$imageManager = new \Camagru\Model\ImageManager();
		$array = [
			"username" => $username,
			"images" => $imageManager->fetchProfileImages($userData),
			"name" => $userData->usr_name(),
			"bio" => $userData->usr_bio(),
			"profilepic" => $userData->usr_ppic(),
			"membersince" => $userData->usr_dtcrea(),
		];
		$this->set($array);
		$this->render("index");
	}
	
	public function processEdit() {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		$userManager = new \Camagru\Model\UserManager();
		$profilename = null;
		$profilebio = null;

		if (!empty($_POST)) {
			$this->secureForm($_POST);
			if (strlen($_POST["profilename"]) <= 20) {
				$profilename = $_POST["profilename"];
				if (strlen($profilename) < 1)
					$profilename = $this->_userData->usr_login();
			} else {
				Alert::warning_alert("Your display name cannot be longer than 20 characters.");
				header("Location: " . URL . "profile/view/" . $this->_userData->usr_login());
				exit;
			}
			if (strlen($_POST["profilebio"]) <= 100) {
				$profilebio = $_POST["profilebio"]; 
			} else {
				Alert::warning_alert("Your bio cannot be longer than 100 characters.");
				header("Location: " . URL . "profile/view/" . $this->_userData->usr_login());
				exit;
			}
			$editProfile = new \Camagru\Model\User([
				"usr_id"	=> $_SESSION["user_id"],
				"usr_login" => $this->_userData->usr_login(),
				"usr_email"	=> $this->_userData->usr_email(),
				"usr_pwd"	=> $this->_userData->usr_pwd(),
				"usr_name"	=> $profilename,
				"usr_bio"	=> $profilebio,
				"usr_active" => $this->_userData->usr_active(),
			]);
			$userManager->editUser($editProfile);
			header("Location: .");
			exit;
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", '.');
	}

	public function uploadProfilePicture() {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		$userManager = new \Camagru\Model\UserManager();
		$upload = new \Camagru\Lib\ImageUpload();
		$ajax_response = $upload->ajaxUpload($this->_userData->usr_id(), 2);
		$userManager = new \Camagru\Model\UserManager();
		if ($userManager->updateUserPicture($this->_userData, $upload->img_path))
			exit ($ajax_response);
		else
			Alert::failure_alert("Your profile picture couldn't be changed.",
			URL . "profile/view/" . $this->_userData->usr_login());
	}

	public function resetProfilePicture() {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		$userManager = new \Camagru\Model\UserManager();
		$userManager = new \Camagru\Model\UserManager();
		if ($userManager->updateUserPicture($this->_userData, "public/img/nopic.png")) {
			Alert::success_alert("Your profile picture was successfully reset.");
			header("Location: " . URL . "profile/view/" . $this->_userData->usr_login());
			exit;
		}
		else
			Alert::failure_alert("Your profile picture couldn't be reset.",
			URL . "profile/view/" . $this->_userData->usr_login());
	}
}
