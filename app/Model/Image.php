<?php
namespace Camagru\Model;

class Image
{
	private $_img_id;
	private $_img_usr_id;
	private $_img_name;
	private $_img_description;
	private $_img_active;
	private $_img_dtcrea;

	public function __construct($data) {
		$this->hydrate($data);
	}

	public function hydrate($data) {
		foreach ($data as $key => $value) {
    		$method = 'set' . ucfirst($key);  
	    	if (method_exists($this, $method))
	      		$this->$method($value);
	    }
	}

	public function img_id() {		return ($this->_img_id); }
	public function img_usr_id() {	return ($this->_img_usr_id); }
	public function img_name() {	return ($this->_img_name); }
	public function img_description() {	return $this->_img_description; }
	public function img_active() {	return ($this->_img_active); }
	public function img_dtcrea() {	return ($this->_img_dtcrea); }

	public function setImg_id($img_id) {
		$this->_img_id = (int) $img_id;
	}

	public function setImg_usr_id($img_usr_id) {
		$this->_img_usr_id = (int) $img_usr_id;
	}

	public function setImg_name($img_name) {
		if (is_string($img_name) && strlen($img_name) <= 255)
			$this->_img_name = $img_name;
	}

	public function setImg_description($img_description) {
		if (is_string($img_description) && strlen($img_description) <= 1024)
			$this->_img_description = $img_description;
	}

	public function setImg_active($img_active) {
		$this->_img_active = (int) $img_active;
	}

	public function setImg_dtcrea($img_dtcrea) {
		if ($img_dtcrea instanceof DateTime)
            $this->_img_dtcrea = $img_dtcrea;
	}
}