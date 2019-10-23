<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class LoginController extends Controller
{
	public function __construct() {
		$this->checkAccess("You're already logged in.", URL, true);
	}

    public function index() {
        $this->render("index");
	}

	public function forgotPassword() {
		$this->render("forgotpassword");
	}

	public function resetPassword($username = null, $token = null) {
		if (!empty($username) && !empty($token)) {
			$array["username"] = $username;
			$array["token"] = $token;
			$this->set($array);
			$this->render("resetpassword");
		} else
			Alert::failure_alert("There was a probem with the data you submitted.", URL);
	}

    public function processLogin() {
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$username = $_POST["username"];
			$password = $_POST["password"];
			$tryUserLogin = new \Camagru\Model\User(["usr_login" => $username]);
			$userManager = new \Camagru\Model\UserManager();
			$loginData = $userManager->getUser($tryUserLogin);
			if ($username == $loginData->usr_login()) {
				$_SESSION["save_username"] = $username;
				if (password_verify($password, $loginData->usr_pwd())) {
					if ($loginData->usr_confirmed() == '0') {
						$token = bin2hex(random_bytes(16));
						$loginData->setUsr_token($token);
						$userManager->editUser($loginData);
				    	$send_mail = new \Camagru\Lib\Mail($loginData->usr_email());
				    	$send_mail->registrationMail($loginData->usr_login(), $loginData->usr_token());
						Alert::warning_alert("Your account has not been verified, we have sent another confirmation e-mail in order for you to verify it. Make sure to check your Spam folder.");
						header("Location: .");
						exit;
					} else {
						$_SESSION["save_username"] = null;
						$_SESSION["user_id"] = $loginData->usr_id();
						$_SESSION["user_username"] = $loginData->usr_login();
						if (isset($_POST["remember"])) 
							setcookie("auth", $loginData->usr_id() . "---" . sha1($loginData->usr_login() . $loginData->usr_pwd() . $_SERVER["REMOTE_ADDR"]), time() + 3600 * 24 * 365, null, null, false, true);
						if ($loginData->usr_active() == 0) {
							$loginData->setUsr_active(1);
							$userManager->editUser($loginData);
							Alert::success_alert("Your account has been reactivated. Welcome back!");
						} else
							Alert::success_alert("You are now logged in.");
						header("Location: " . URL);
						exit;
					}
				} else
					Alert::failure_alert("The password you entered is incorrect.", '.');
			} else
				Alert::failure_alert("This user does not exist.", '.');
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", '.');
	}

	public function processForgotPassword() {
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$email = $_POST["email"];
			$token = bin2hex(random_bytes(16));
			$user = new \Camagru\Model\User(["usr_email" => $email]);
			$userManager = new \Camagru\Model\UserManager();
			$userData = $userManager->getUser($user);
			if ($userManager->existsUser('NULL', $email) == 1) {
				$userData->setUsr_token($token);
				$userManager->editUser($userData);
				$new_mail = new \Camagru\Lib\Mail($userData->usr_email());
				$new_mail->forgotPasswordMail($userData->usr_login(), $userData->usr_token());
			}
			Alert::success_alert("If an account is associated with this email address, an email has been sent.");
			header("Location: forgotpassword");
			exit();
		}
		else
			Alert::failure_alert("There was a problem with the data you submitted.", '.');
	}

	public function processResetPassword($username = null, $token = null) {
		if (!empty($_POST) && !empty($username) && !empty($token)) {
			$this->secureForm($_POST);
			$user = new \Camagru\Model\User(["usr_login" => $username]);
			$userManager = new \Camagru\Model\UserManager();
			$userData = $userManager->getUser($user);
			if ($userManager->existsUser($username, "NULL") && strcmp($token, $userData->usr_token() === 0)) {
				if ($_POST["cnew_password"] === $_POST["new_password"]) {
					$newpassword = $_POST["new_password"];
					if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{6,16}$/", $newpassword))
						$newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
					else
						Alert::failure_alert("Passwords must be between 6 and 16 characters long and contain at least one uppercase letter, one lowercase letter and one digit.", URL . "login/resetpassword/" . $username . '/' . $token);
				} else
					Alert::failure_alert("The new passwords you entered don't match.", URL . "login/resetpassword/" . $username . '/' . $token);
				$userData->setUsr_token(NULL);
				$userData->setUsr_pwd($newpassword);
				$userManager->editUser($userData);
				Alert::success_alert("Your password has been reset, you can now log back in.");
				header("Location: " . URL . "login");
				exit;
			} else
				Alert::failure_alert("Invalid token. Your account couldn't be confirmed.", URL . "login");
		} else
			Alert::failure_alert("There was a probem with the data you submitted.", URL);
	}
}