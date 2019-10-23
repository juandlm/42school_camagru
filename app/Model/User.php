<?php
namespace Camagru\Model;

class User
{
	private $_usr_id;
	private $_usr_login;
	private $_usr_email;
	private $_usr_pwd;
	private $_usr_name;
	private $_usr_bio;
	private $_usr_ppic;
	private $_usr_token;
	private $_usr_confirmed;
	private $_usr_active;
	private $_usr_cmt_sendmail;
	private $_usr_lik_sendmail;
	private $_usr_dtcrea;

	public function __construct($data) {
		if (!empty($data))
			$this->hydrate($data);
	}

	public function hydrate($data) {
		foreach ($data as $key => $value) {
    		$method = 'set' . ucfirst($key);  
	    	if (method_exists($this, $method))
	      		$this->$method($value);
	    }
	}

	public function usr_id() {				return ($this->_usr_id); }
	public function usr_login() {			return ($this->_usr_login); }
	public function usr_email() {			return ($this->_usr_email); }
	public function usr_pwd() { 			return ($this->_usr_pwd); }
	public function usr_name() { 			return ($this->_usr_name); }
	public function usr_bio() { 			return ($this->_usr_bio); }
	public function usr_ppic() { 			return ($this->_usr_ppic); }
	public function usr_token() { 			return ($this->_usr_token); }
	public function usr_confirmed() { 		return ($this->_usr_confirmed); }
	public function usr_active() { 			return ($this->_usr_active); }
	public function usr_cmt_sendmail() { 	return ($this->_usr_cmt_sendmail); }
	public function usr_lik_sendmail() { 	return ($this->_usr_lik_sendmail); }
	public function usr_dtcrea() { 			return ($this->_usr_dtcrea); }

	public function setUsr_id($usr_id) {
		$this->_usr_id = (int) $usr_id;
	}

	public function setUsr_login($usr_login) {
		if (is_string($usr_login) && strlen($usr_login) >= 2 && strlen($usr_login) <= 25)
			$this->_usr_login = $usr_login;
	}

	public function setUsr_email($usr_email) {
		if (filter_var($usr_email, FILTER_VALIDATE_EMAIL))
			$this->_usr_email = $usr_email;
	}

	public function setUsr_pwd($usr_pwd) {
		if (preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $usr_pwd))
			$this->_usr_pwd = $usr_pwd;
	}

	public function setUsr_name($usr_name) {
		if (is_string($usr_name))
			$this->_usr_name = $usr_name;
	}

	public function setUsr_bio($usr_bio) {
		if (is_string($usr_bio))
			$this->_usr_bio = $usr_bio;
	}

	public function setUsr_ppic($usr_ppic) {
		if (is_string($usr_ppic))
			$this->_usr_ppic = $usr_ppic;
	}

	public function setUsr_token($usr_token) {
		if (is_string($usr_token) || is_null($usr_token))
			$this->_usr_token = $usr_token;
	}

	public function setUsr_confirmed($usr_confirmed) {
		if ($usr_confirmed == 0 || $usr_confirmed == 1)
			$this->_usr_confirmed = (int) $usr_confirmed;
	}

	public function setUsr_active($usr_active) {
		if ($usr_active == 0 || $usr_active == 1)
			$this->_usr_active = (int) $usr_active;
	}

	public function setUsr_cmt_sendmail($usr_cmt_sendmail) {
		if ($usr_cmt_sendmail == 0 || $usr_cmt_sendmail == 1)
			$this->_usr_cmt_sendmail = (int) $usr_cmt_sendmail;
	}

	public function setUsr_lik_sendmail($usr_lik_sendmail) {
		if ($usr_lik_sendmail == 0 || $usr_lik_sendmail == 1)
			$this->_usr_lik_sendmail = (int) $usr_lik_sendmail;
	}

	public function setUsr_dtcrea($usr_dtcrea) {
		if (is_string($usr_dtcrea))
			$this->_usr_dtcrea = $usr_dtcrea;
	}
}