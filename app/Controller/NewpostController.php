<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;
use Camagru\Lib\Alert;

class NewpostController extends Controller
{
	private $_userData;

	public function __construct() {
		$this->checkAccess("You need to be logged in to accces this page.", URL . "login", false, true);
		$this->_userData = $this->fetchUserData($_SESSION["user_username"]);
	}

    public function index() {
		$this->render("index");
	}

	public function create() {
		$imageManager = new \Camagru\Model\ImageManager();
		$array["created_images"] = $imageManager->getImagesCreated($this->_userData);
		$this->set($array);
		$this->render("create");
	}

	public function upload() {
		$imageManager = new \Camagru\Model\ImageManager();
		$array["saved_images"] = $imageManager->getImagesUploaded($this->_userData);
		$this->set($array);
		$this->render("upload");
	}

	public function processSnapshot() {
		$upload = new \Camagru\Lib\ImageUpload();
		$studioData = json_decode(file_get_contents("php://input"), true);
		if (!empty($studioData)) {
			$this->secureForm($studioData["stickers"]);
			$stickerPath = "public/img/stickers/";
			foreach ($studioData["stickers"] as $k => $v)
				$sticker[$k] = imagecreatefrompng($stickerPath . $v);
			$stickerFrame = imagecreatetruecolor(1280, 720);
			$alphacolor = imagecolorallocate($stickerFrame, 19, 19, 19);
			imagefill($stickerFrame, 0, 0, $alphacolor);
			imagecolortransparent($stickerFrame, $alphacolor);
			foreach ($sticker as $v)
				imagecopy($stickerFrame, $v, 0, 0, 0, 0, 1280, 720);

			$imgData = base64_decode(explode(',', $studioData["img_encoded"])[1]);
			$tmpImg = tempnam(sys_get_temp_dir(), "camagru");
			file_put_contents($tmpImg, $imgData);
			$outputImg = imagecreatefrompng($tmpImg);
			imagecopymerge($outputImg, $stickerFrame, 0, 0, 0, 0, 1280, 720, 100);
		
			ob_start();
			$res = imagepng($outputImg, null, 9);
			$tmpSize = file_put_contents($tmpImg, ob_get_contents());
			ob_end_clean();
			$_FILES["image"] =  [
				"name" => "snapshot.png",
				"type" => "image/png",
				"tmp_name" => $tmpImg,
				"error" => $res === true ? 0 : 1,
				"size" => $tmpSize
			];
			if ($res === true) {
				$ajax = $upload->ajaxUpload($this->_userData->usr_id(), 1, true);
				imagedestroy($outputImg);
				foreach ($sticker as $v)
					imagedestroy($v);
				unset($_FILES["image"]);
				exit ($ajax);
			} else
				Alert::failure_alert("There was a problem processing your image.", URL);
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}

	public function processUpload() {
		$upload = new \Camagru\Lib\ImageUpload();
		exit ($upload->ajaxUpload($this->_userData->usr_id(), 0));
	}

	public function postUpload(string $upl_name = null) {
		if (!empty($upl_name) && !empty($_POST)) {
			$upl_name = $this->secureInput($upl_name);
			$this->secureForm($_POST);
			$img_description = $_POST["img_description"];
			$checkImg = scandir("public/img/userupload");
			foreach ($checkImg as $k => $v) {
				$file_name = explode('.', $v)[0];
				if (strcmp($file_name, $upl_name) === 0)
					$img_name = $checkImg[$k];
			}
			if (!empty($img_name)) {
				$imageManager = new \Camagru\Model\ImageManager();
				$imageData = new \Camagru\Model\Image(
					["img_usr_id" => $this->_userData->usr_id(),
					"img_name" => $img_name,
					"img_description" => $img_description]
				);
				if ($imageManager->newImage($imageData, $img_name)
					&& $imageManager->updateUploadActive($this->_userData, 2, $upl_name)) {
					Alert::success_alert("The image has been posted to your profile.");
					header("Location: " . URL . "profile/view/". $this->_userData->usr_login());
					exit;
				}
			} else
				Alert::failure_alert("This image doesn't exist.", URL);
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}

	public function saveUpload(string $upl_name = null, string $redirect = null) {
		$validRedirects = ["upload", "create"];
	
		if (!empty($upl_name) && !empty($redirect)
			&& in_array($redirect, $validRedirects)) {
			$upl_name = $this->secureInput($upl_name);
			$checkImg = scandir("public/img/userupload");
			foreach ($checkImg as $k => $v) {
				$file_name = explode('.', $v)[0];
				if (strcmp($file_name, $upl_name) === 0)
					$img_name = $checkImg[$k];
			}
			$redirect = "newpost/" . $redirect;
			if (!empty($img_name)) {
				$imageManager = new \Camagru\Model\ImageManager();
				if ($imageManager->updateUploadActive($this->_userData, 1, $img_name)) {
					Alert::success_alert("The image has been saved.");
					header("Location: " . URL . $redirect);
					exit;
				}
			} else
				Alert::failure_alert("This image doesn't exist.", URL . $redirect);
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}

	public function deleteUpload(string $upl_name = null, string $redirect = null) {
		$validRedirects = ["upload", "create", "profile"];

		if (!empty($upl_name) && !empty($redirect)
			&& in_array($redirect, $validRedirects)) {
			$upl_name = $this->secureInput($upl_name);
			$checkImg = scandir("public/img/userupload");
			foreach ($checkImg as $k => $v) {
				$file_name = explode('.', $v)[0];
				if (strcmp($file_name, $upl_name) === 0)
					$img_name = $checkImg[$k];
			}
			if ($redirect !== "profile")
					$redirect = "newpost/" . $redirect;
			if (!empty($img_name)) {
				$imageManager = new \Camagru\Model\ImageManager();
				if ($imageManager->updateUploadActive($this->_userData, 0, $img_name)
					&& unlink("public/img/userupload/" . $img_name)) {
					Alert::success_alert("The image has been deleted.");
					header("Location: " . URL . $redirect);
					exit;
				}
			} else
				Alert::failure_alert("This image doesn't exist.", URL . $redirect);
		} else
			Alert::failure_alert("There was a problem with the data you submitted.", URL);
	}
}
