<?php
namespace Camagru\Model;

use Camagru\Core\Model;

class CommentManager extends Model
{
	public function previewPostComments($img_id, $amount) {
		$sql = "SELECT usr_id, usr_login, usr_ppic, cmt_id, cmt_usr_id, cmt_img_id, cmt_body, cmt_dtcrea
				FROM t_comments
				LEFT JOIN t_users ON usr_id = cmt_usr_id
				WHERE cmt_img_id = :img_id
				AND cmt_active = 1
				ORDER BY cmt_dtcrea DESC
				LIMIT " . $amount;
		$data = $this->db->prepare($sql,
			['img_id' => $img_id],
			true, false, false);
		return ($data);
	}

	public function fetchPostComments($img_id) {
		$sql = "SELECT usr_id, usr_login, usr_ppic, cmt_id, cmt_usr_id, cmt_img_id, cmt_body, cmt_dtcrea
				FROM t_comments
				LEFT JOIN t_users ON usr_id = cmt_usr_id
				WHERE cmt_img_id = :img_id
				AND cmt_active = 1
				ORDER BY cmt_dtcrea DESC";
		$data = $this->db->prepare($sql,
			['img_id' => $img_id],
			true, false, false);
		return ($data);
	}

	public function newComment($usr_id, $img_id, $comment) {
		$sql = "INSERT INTO t_comments (cmt_usr_id, cmt_img_id, cmt_body, cmt_dtcrea)
				VALUES (:id_user, :id_image, :body, NOW())";
		$data = $this->db->prepare($sql,
			[':id_user' => $usr_id,
			':id_image' => $img_id,
			':body' => $comment],
			false);
		return ($data);
	}

	public function deactivateComment($cmt_id, $img_id) {
		$sql = "UPDATE t_comments
				SET cmt_active = 0
				WHERE cmt_id = :cmt_id
				AND cmt_img_id = :img_id";
		$data = $this->db->prepare($sql,
			['cmt_id' => $cmt_id,
			'img_id' => $img_id],
			false);
		return ($data);
	}

	public function checkCommentOwnership($cmt_id, $usr_id) {
		$sql = "SELECT *
				FROM t_comments
				WHERE cmt_id = :cmt_id
				AND cmt_usr_id = :usr_id";
		$data = $this->db->prepare($sql,
			[':cmt_id' => $cmt_id,
			':usr_id' => $usr_id],
			true, false, true);
		return ($data);
	}
}