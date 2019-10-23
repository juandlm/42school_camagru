<?php
namespace Camagru\Model;

use Camagru\Core\Model;

class ImageManager extends Model
{
	public function newUpload($usr_id, $upl_path, $upl_type) {
		$sql = "INSERT INTO t_uploads (upl_usr_id, upl_url, upl_type)
				VALUES (:usr_id, :upl_path, :upl_type)";
		$data = $this->db->prepare($sql,
			[':usr_id' => $usr_id,
			':upl_path' => $upl_path,
			':upl_type' => $upl_type],
			false, false, false);
		return ($data);
	}

	public function updateUploadActive(User $user, $upl_active, $upl_name) {
		$sql = "UPDATE t_uploads
				SET upl_active = :upl_active
				WHERE upl_url LIKE '%$upl_name%'
				AND upl_usr_id = :usr_id";
		$data = $this->db->prepare($sql,
			[':usr_id' => $user->usr_id(),
			':upl_active' => $upl_active], 
			false);
		return ($data);
	}

	public function getImagesUploaded(User $user) {
		$sql = "SELECT *
				FROM t_uploads
				WHERE upl_usr_id = :usr_id
				AND upl_type = 0
				AND upl_active = 1";
		$data = $this->db->prepare($sql,
			[':usr_id' => $user->usr_id()],
			true);
		return ($data);
	}

	public function getImagesCreated(User $user) {
		$sql = "SELECT *
				FROM t_uploads
				WHERE upl_usr_id = :usr_id
				AND upl_type = 1
				AND upl_active = 1";
		$data = $this->db->prepare($sql,
			[':usr_id' => $user->usr_id()],
			true);
		return ($data);
	}

	public function newImage(Image $image, $img_name) {
		$sql = "INSERT INTO t_images (img_usr_id, img_upl_id, img_name, img_description, img_dtcrea)
				VALUES (:img_usr_id, (SELECT upl_id FROM t_uploads WHERE upl_url LIKE '%$img_name%'),
						:img_name, :img_description, NOW())";
		$data = $this->db->prepare($sql,
			[':img_usr_id' => $image->img_usr_id(),
			':img_name' => $image->img_name(),
			':img_description' => $image->img_description()],
			false);
		return ($data);
	}

	public function deactivateImage(Image $image) {
		$sql = "UPDATE t_images
				SET img_active = 0
				WHERE img_id = :img_id";
		$data = $this->db->prepare($sql,
			[':img_id' => $image->img_id()],
			false);
		return ($data);
	}

	public function updateImageDescription(Image $image) {
		$sql = "UPDATE t_images
				SET img_description = :img_description
				WHERE img_id = :img_id
				AND img_usr_id = :img_usr_id";
		$data = $this->db->prepare($sql,
			[':img_description' => $image->img_description(),
			':img_id' => $image->img_id(),
			':img_usr_id' => $image->img_usr_id()],
			false);
		return ($data);
	}

	public function fetchAllImages($imageByPage, $start) {
		$sql = "SELECT img_id, img_usr_id, img_name, img_description, img_dtcrea, usr_login, usr_ppic
				FROM t_images
				LEFT JOIN t_users ON img_usr_id = usr_id
				WHERE img_active = 1
				GROUP BY img_name
				ORDER BY img_dtcrea DESC
				LIMIT " . $start . "," . $imageByPage;
		$data = $this->db->query($sql, true, false);
		return ($data);
	}

	public function fetchProfileImages(User $user) {
		$sql = "SELECT img_id, img_usr_id, img_name, img_description, img_dtcrea, usr_login, usr_ppic
				FROM t_images
				LEFT JOIN t_users ON img_usr_id = usr_id
				WHERE img_active = 1
				AND img_usr_id = :usr_id
				GROUP BY img_name
				ORDER BY img_dtcrea DESC";
		$data = $this->db->prepare($sql,
			[':usr_id' => $user->usr_id()],
			true);
		return ($data);
	}

	public function fetchImage($img_id) {
		$sql = "SELECT img_id, img_usr_id, img_name, img_description, img_dtcrea, usr_login, usr_ppic
				FROM t_images
				LEFT JOIN t_users ON img_usr_id = usr_id
				WHERE img_id = :img_id";
		$data = $this->db->prepare($sql,
			[':img_id' => $img_id],
			true, true, false);
		return ($data);
	}

	public function getImageName(Image $image) {
		$sql = "SELECT img_name
				FROM t_images
				WHERE img_id = :img_id";
		$data = $this->db->prepare($sql,
			[':img_id' => $image->img_id()],
			true, true, false);
		return ($data);
	}

	public function checkImageActive($img_id) {
		$sql = "SELECT *
				FROM t_images
				WHERE img_id = :img_id
				AND img_active = 1";
		$data = $this->db->prepare($sql,
			['img_id' => $img_id],
			true, false, true);
		return ($data);
	}

	public function checkImageOwnership(Image $image) {
		$sql = "SELECT *
				FROM t_images
				WHERE img_id = :img_id
				AND img_usr_id = :img_usr_id";
		$data = $this->db->prepare($sql,
			[':img_id' => $image->img_id(),
			':img_usr_id' => $image->img_usr_id()],
			true, false, true);
		return $data;
	}

	public function countTotalImages() {
		$sql = "SELECT *
				FROM t_images
				WHERE img_active = 1";
		$data = $this->db->query($sql, true, false, true);
		return $data;
	}
}