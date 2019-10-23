<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;

class SearchController extends Controller
{
    public function index() {
		if (!empty($_POST)) {
			$this->secureForm($_POST);
			$query = $_POST["search"];
			$userManager = new \Camagru\Model\UserManager();
			$result["users"] = $userManager->searchUser($query);
			$this->set($result);
			$this->render("index");
		} else
			Alert::failure_alert("Your search query can't be empty.", '.');
	}
}
