<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class ConfirmController extends Controller
{
    public function processConfirmation($username = null, $token = null) {
		if (!empty($username) && !empty($token)) {
			$user = new \Camagru\Model\User(["usr_login" => $username]);
			$userManager = new \Camagru\Model\UserManager();
			$userData = $userManager->getUser($user);
			if ($userData->usr_confirmed() == '0') {
				if (strcmp($token, $userData->usr_token() === 0)) {
					$userManager->confirmUser($userData);
					Alert::success_alert("Your account is now active, thank you!");
					header("Location: " . URL . "login");
					exit;
				} else
					Alert::failure_alert("Invalid token. Your account couldn't be confirmed.", URL . "login");
			} elseif ($userData->usr_confirmed() == '1') {
				Alert::warning_alert("Your account has already been confirmed.");
				header("Location: " . URL . "login");
				exit;
			} else
				Alert::failure_alert("Something went wrong.", URL . "login");
		} else
			Alert::failure_alert("There was a probem with the data you submitted.", URL);
    }
}
?>