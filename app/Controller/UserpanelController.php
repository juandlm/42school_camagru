<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class UserpanelController extends Controller
{
	private $_userData;

	public function __construct() {
		$this->checkAccess("You need to be logged in to accces this page.", "login");
		$this->_userData = $this->fetchUserData($_SESSION["user_username"]);
	}

	public function index() {
		$this->render("index");
	}

	public function emailPreferences() {
		$_SESSION["prefComment"] = $this->_userData->usr_cmt_sendmail();
		$_SESSION["prefLike"] = $this->_userData->usr_lik_sendmail();
		$this->render("emailpreferences");
		unset($_SESSION["prefComment"], $_SESSION["prefLike"]);
	}
	
	public function editAccount() {
		$this->render("editaccount");
	}

	public function deactivateAccount() {
		$this->render("deactivateaccount");
	}

	public function processPreferences() {
		$this->secureForm($_POST);
		$userManager = new \Camagru\Model\UserManager();
		$pcomments = (int)(!empty($_POST["pcomments"]) && $_POST["pcomments"] == "on");
		$plikes = (int)(!empty($_POST["plikes"]) && $_POST["plikes"] == "on");
		if (($this->_userData->usr_cmt_sendmail() != $pcomments) ||  $this->_userData->usr_lik_sendmail() != $plikes) {
			$editPreferences = new \Camagru\Model\User([
				"usr_id"	=> $_SESSION["user_id"],
				"usr_cmt_sendmail"	=> $pcomments,
				"usr_lik_sendmail"	=> $plikes]);
			$userManager->editPreferences($editPreferences);
			Alert::success_alert("Your email preferences were successfully changed.");
			header("Location: emailpreferences");
			exit;
		} else {
			Alert::warning_alert("You didn't change anything in your email preferences.");
			header("Location: emailpreferences");
			exit;
		}
	}

	public function processEdit() {
		$newpassword = null;
		$newusername = null;
		$newemail = null;
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$userManager = new \Camagru\Model\UserManager();
			if (!empty($_POST["password"])) {
				$oldpassword = $_POST["password"];
				if (password_verify($oldpassword, $this->_userData->usr_pwd())) {
					if (!empty($_POST["new_password"]) && !empty($_POST["cnew_password"])) {
						if ($_POST["cnew_password"] === $_POST["new_password"]) {
							$newpassword = $_POST["new_password"];
							if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{6,16}$/", $newpassword))
								$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
							else
								Alert::failure_alert("Passwords must be between 6 and 16 characters long and contain at least one uppercase letter, one lowercase letter and one digit.", "editaccount");
						} else
							Alert::failure_alert("The new passwords you entered don't match.", "editaccount");
					} elseif (!empty($_POST["new_username"])) {
						if (preg_match("/^[a-z\d_]{2,20}$/i", $_POST["new_username"])) {
							if ($_POST["new_username"] == $this->_userData->usr_login())
								Alert::failure_alert("This is your current username.", "editaccount");
							if ($userManager->existsUser($_POST["new_username"], "NULL") == 0) {
								$newusername = $_POST["new_username"];
							} else
								Alert::failure_alert("This username is already in use.", "editaccount");
						} else
							Alert::failure_alert("Usernames must be between 2 and 20 characters long and can only contain alphanumeric and underscore characters.", "editaccount");
					} elseif (!empty($_POST["new_email"])) {
						if (filter_var($_POST["new_email"], FILTER_VALIDATE_EMAIL)) {
							if ($_POST["new_email"] == $this->_userData->usr_email())
								Alert::failure_alert("This is your current email address.", "editaccount");
							if ($userManager->existsUser("NULL", $_POST["new_email"]) == 0)
								$newemail = $_POST["new_email"];
							else
								Alert::failure_alert("This email address is already in use.", "editaccount");
						} else
							Alert::failure_alert("The email address you entered is not valid", "editaccount");
					}
				} else
					Alert::failure_alert("The current password you entered is incorrect.", "editaccount");
			} else
				Alert::failure_alert("You didn't enter your current password.", "editaccount");
			$editUser = new \Camagru\Model\User([
				"usr_id"       => $_SESSION["user_id"],
				"usr_login" => isset($newusername) ? $newusername : $this->_userData->usr_login(),
				"usr_email"    => isset($newemail) ? $newemail : $this->_userData->usr_email(),
				"usr_pwd" => isset($newpassword) ? $newpassword : $this->_userData->usr_pwd(),
				"usr_active" => $this->_userData->usr_active()
			]);
			$userManager->editUser($editUser);
			Alert::success_alert("Your information was successfully changed. Please log in again.");
			unset($_SESSION["user_username"], $_SESSION["user_id"]);
			session_commit();
			$this->disconnect("login");
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", "editaccount");
	}

	public function processDeactivation() {
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$userManager = new \Camagru\Model\UserManager();
			if (!empty($_POST["confirmcheck"])) {
				if (!empty($_POST["password"])) {
					if (password_verify($_POST["password"], $this->_userData->usr_pwd())) {
						$userManager->deactivateUser($this->_userData);
						Alert::warning_alert("Your account is no longer active. Come back soon!");
						unset($_SESSION["user_username"], $_SESSION["user_id"]);
						session_commit();
						$this->disconnect();
					} else
						Alert::failure_alert("The current password you entered is incorrect.", "deactivateaccount");
				} else
					Alert::failure_alert("You didn't enter your current password.", "deactivateaccount");
			} else
				Alert::failure_alert("You didn't check the box to confirm the deactivation.", "deactivateaccount");
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", "deactivateaccount");
	}
}
?>