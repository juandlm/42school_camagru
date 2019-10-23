<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class RegisterController extends Controller
{
	public function __construct() {
		$this->checkAccess("You're already logged in.", URL, true);
	}

    public function index() {
        $this->render("index");
	}

	public function processRegistration() {
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$username = $_POST["username"];
			$email = $_POST["email"];
			$password = $_POST["password"];
			$passwordconfirm = $_POST["passwordconfirm"];
			if (!empty($_POST["toscheck"])) {
				if (preg_match("/^[a-z\d_]{2,20}$/i", $username)) {
					$_SESSION["save_username"] = $username;
					if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$_SESSION["save_email"] = $email;
						$userManager = new \Camagru\Model\UserManager();
						$userExists = $userManager->existsUser($username, $email);
						if ($userExists == 0) {
							if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{6,16}$/", $password)) {
						    	if ($password === $passwordconfirm) {
						    		$password = password_hash($password, PASSWORD_DEFAULT);
									$token = bin2hex(random_bytes(16));
						    		$new_user = new \Camagru\Model\User([
										"usr_login"	=> $username,
										"usr_pwd"	=> $password,
										"usr_name"	=> $username,
										"usr_ppic"	=> "public/img/nopic.png",
										"usr_email"	=> $email,
										"usr_token"	=> $token
						    		]);
									$userManager->newUser($new_user);
						    		$sendMail = new \Camagru\Lib\Mail($email);
						    		$sendMail->registrationMail($username, $token);
									$_SESSION["save_username"] = null;
									$_SESSION["save_email"] = null;
									$this->render("success");
						   			exit;
						   		} else
									Alert::failure_alert("The passwords you entered don't match.", '.');
						   	} else
								Alert::failure_alert("Passwords must be between 6 and 16 characters long and contain at least one uppercase letter, one lowercase letter and one digit.", '.');
						} else {
							$_SESSION["save_username"] = null;
							$_SESSION["save_email"] = null;
							Alert::failure_alert("This username or email address is already in use.", '.');
					    }
				    } else
						Alert::failure_alert("The email address you entered is not valid.", '.');
				} else
					Alert::failure_alert("Usernames must be between 2 and 20 characters long and can only contain alphanumeric and underscore characters.", '.');
			} else
				Alert::failure_alert("You have to accept the Terms of Service in order to register.", '.');
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", '.');
	}
}