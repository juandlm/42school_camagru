<?php
namespace Camagru\Model;

use Camagru\Core\Model;

class UserManager extends Model
{
	public function newUser(User $user) {
		$sql = "INSERT INTO t_users (usr_login, usr_pwd, usr_name, usr_ppic, usr_email, usr_token)
				VALUES (:usr_login, :usr_pwd, :usr_name, :usr_ppic, :usr_email, :usr_token)";
		$data = $this->db->prepare($sql,
			[':usr_login'	=> $user->usr_login(),
			':usr_pwd'		=> $user->usr_pwd(),
			':usr_name'		=> $user->usr_name(),
			':usr_ppic'		=> $user->usr_ppic(),
			':usr_email'		=> $user->usr_email(),
			':usr_token'		=> $user->usr_token()],
			false);
	}

	public function confirmUser(User $user) {
		$sql = "UPDATE t_users
				SET usr_confirmed = 1, usr_token = null
				WHERE usr_login = :usr_login";
		$data = $this->db->prepare($sql,
			[':usr_login' => $user->usr_login()],
			false);
	}

	public function deactivateUser(User $user) {
		$sql = "UPDATE t_users SET usr_active = 0 WHERE usr_id = :usr_id";
		$data = $this->db->prepare($sql,
			[':usr_id' => $user->usr_id()],
			false);
	}

	public function existsUser($username, $email) {
		$sql = "SELECT *
				FROM t_users
				WHERE usr_login = :usr_login
				OR usr_email = :usr_email";
		$data = $this->db->prepare($sql,
			[':usr_login'	=> $username,
			':usr_email'	=> $email],
			true, false, true);
		return ($data);
	}

	public function getUser(User $user) {
		$sql = "SELECT *
				FROM t_users
				WHERE usr_id = :usr_id
				OR usr_login = :usr_login
				OR usr_email = :usr_email";
		$data = $this->db->prepare($sql,
			[':usr_id'		=> $user->usr_id(),
			':usr_login'	=> $user->usr_login(),
			':usr_email'	=> $user->usr_email()],
			true, true, false);
		return (new \Camagru\Model\User($data));
	}

	public function searchUser($username) {
		$sql = "SELECT usr_login, usr_ppic
				FROM t_users
				WHERE usr_login
				LIKE '%$username%'
				AND usr_active = 1";
		$data = $this->db->prepare($sql, null, true, false, false);
		return ($data);
	}

	public function editUser(User $user) {
		$sql = "UPDATE t_users
				SET usr_login = :usr_login, usr_email = :usr_email, usr_pwd = :usr_pwd, usr_token = :usr_token,
				usr_name = :usr_name, usr_bio = :usr_bio, usr_active = :usr_active
				WHERE usr_id = :usr_id
				OR usr_login = :usr_login
				OR usr_email = :usr_email";
		$data = $this->db->prepare($sql,
			['usr_id'	=> $user->usr_id(),
			'usr_login'	=> $user->usr_login(),
			'usr_email'	=> $user->usr_email(),
			'usr_pwd'	=> $user->usr_pwd(),
			'usr_name'	=> $user->usr_name(),
			'usr_bio'	=> $user->usr_bio(),
			'usr_token'	=> $user->usr_token(),
			'usr_active' => $user->usr_active()],
			false);
	}

	public function editPreferences(User $user) {
		$sql = "UPDATE t_users
				SET usr_cmt_sendmail = :usr_cmt_sendmail, usr_lik_sendmail = :usr_lik_sendmail
				WHERE usr_id = :usr_id";
		$data = $this->db->prepare($sql,
			['usr_id'         => $user->usr_id(),
			'usr_cmt_sendmail' => $user->usr_cmt_sendmail(),
			'usr_lik_sendmail'    => $user->usr_lik_sendmail()],
			false);
	}

	public function updateUserPicture(User $user, $img) {
		$sql = "UPDATE t_users
				SET usr_ppic = :img
				WHERE usr_id = :usr_id";
		$data = $this->db->prepare($sql,
			[':usr_id'	=> $user->usr_id(),
			':img' => $img],
			false);
		return ($data);
	}
}