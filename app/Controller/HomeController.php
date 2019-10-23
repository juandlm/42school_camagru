<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class HomeController extends Controller
{
	public function index() {
		$page = empty($_POST["page"]) ? '1' : $this->secureInput($_POST["page"]);
		$imageManager = new \Camagru\Model\ImageManager();
		$imagesByPage = 5;
		$totalImages = $imageManager->countTotalImages();
		$totalPages = (int)ceil($totalImages / $imagesByPage);
		if ($page > 0 && $page <= $totalPages)
			$currentPage = intval($page);
		else
			Alert::failure_alert("Invalid page.", URL);
		$start = ($currentPage - 1) * $imagesByPage;
		$likeManager = new \Camagru\Model\LikeManager();
		$commentManager = new \Camagru\Model\CommentManager();
		$array["images"] = $imageManager->fetchAllImages($imagesByPage, $start);
		foreach ($array["images"] as $value) {
			$value->{"comments"} = $commentManager->previewPostComments($value->img_id, $imagesByPage);
			$value->{"likes"} = $likeManager->countPostLikes($value->img_id);
		}
		$array["pages"] = ["total" => $totalPages, "current" => $currentPage];
		$this->set($array);
		$this->render("index");
	}

	public function termsOfService() {
        $this->render("tos");
	}
}
