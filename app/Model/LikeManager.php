<?php
namespace Camagru\Model;

use Camagru\Core\Model;

class LikeManager extends Model
{
	public function countPostLikes($img_id) {
		$sql = "SELECT *
				FROM t_likes
				WHERE lik_img_id = :img_id
				AND lik_active = 1";
		$data = $this->db->prepare($sql,
			[':img_id' => $img_id],
			true, false, true);
		return ($data);
	}

	public function fetchPostLikes($img_id) {
		$sql = "SELECT lik_usr_id, usr_login, usr_name, usr_ppic, lik_img_id, lik_dtcrea
				FROM t_likes
				LEFT JOIN t_users ON usr_id = lik_usr_id
				WHERE lik_img_id = :img_id
				AND lik_active = 1
				ORDER BY lik_dtcrea DESC";
		$data = $this->db->prepare($sql,
			[':img_id' => $img_id],
			true, false, false);
		return ($data);
	}

	public function checkLike($usr_id, $img_id) {
		$sql = "SELECT *
				FROM t_likes
				WHERE lik_usr_id = :usr_id
				AND lik_active = 1
				AND lik_img_id = :img_id";
		$data = $this->db->prepare($sql,
			[':usr_id' => $usr_id,
			':img_id'     => $img_id],
		true, false, true);
		return ($data);
	}

	public function toggleLike($usr_id, $img_id, $active) {
		$sql = "INSERT INTO t_likes (lik_usr_id, lik_img_id, lik_dtcrea)
				VALUES (:usr_id, :img_id, NOW())
				ON DUPLICATE KEY UPDATE lik_active = :active";
		$data = $this->db->prepare($sql,
			[':usr_id' => $usr_id,
			':img_id' => $img_id,
			':active' => $active],
			false);
		return ($data);
	}
}