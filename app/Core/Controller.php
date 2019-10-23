<?php
namespace Camagru\Core;

use Camagru\Lib\Helper;
use Camagru\Lib\Alert;

class Controller
{
	public $vars = [];
	public $layout = "default";

	protected function set($array) {
		$this->vars = array_merge($this->vars, $array);
	}

	protected function render($filename) {
		$view = 'view/' . strtolower(str_replace('Controller', '', Helper::get_class_name(get_class($this)))) . '/';
		extract($this->vars);
		ob_start();
		require(APP . $view . $filename . '.php');
		$content_for_layout = ob_get_clean();
		if ($this->layout == false)
			$content_for_layout;
		else
			require(APP . 'view/_templates/' . $this->layout . '.php');
	}

	protected function secureInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return ($data);
	}

	protected function secureForm(&$form) {
		foreach ($form as $key => $value)
			$form[$key] = $this->secureInput($value);
	}

	protected function checkAccess($message, $redirect, $loggedin = false, $verifyIdentity = false) {
		if ($loggedin === false)
			if (empty($_SESSION['user_username']) || empty($_SESSION['user_id']))
				Alert::failure_alert($message, $redirect);
		elseif ($loggedin === true
				&& !empty($_SESSION['user_username']) && !empty($_SESSION['user_id'])) {
			Alert::warning_alert($message, $redirect);
			header('Location: ' . $redirect);
			exit;
		}
		if ($verifyIdentity === true) {
			$userData = $this->fetchUserData($_SESSION['user_username']);
			$checkuser = ['id' => $userData->usr_id(), 'username' =>  $userData->usr_login()];
			if (strcmp($checkuser['id'], $_SESSION['user_id']) != 0
				|| strcmp($checkuser['username'], $_SESSION['user_username']) != 0)
				$this->disconnect();
		}
	}

	private function initUser($username = false) {
		$id = null;
		if (empty($username)) {
			$id = $_SESSION['user_id'];
			$username = $_SESSION['user_username'];
		}
		$user = new \Camagru\Model\User([
			'usr_id'       => $id,
			'usr_login' => $username
		]);
		return ($user);
	}

	protected function fetchUserData($username = false) {
		$user = $this->initUser($username);
		$userManager = new \Camagru\Model\UserManager();
		$userData = $userManager->getUser($user);
		return ($userData);
	}

	public function disconnect($redirect = false) {
		session_destroy();
		setcookie('auth', '', time() - 3600, null, null, false, true);
		if ($redirect)
			header('Location: ' . URL . $redirect);
		else
			header('Location: ' . URL);
		exit;
	}
}
