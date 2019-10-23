<?php
namespace Camagru\Lib;

class Alert
{
	public static function success_alert($message) {
		$_SESSION['success_alert'] = $message;
	}

	public static function warning_alert($message) {
		$_SESSION['warning_alert'] = $message;
	}

	public static function failure_alert($message, $page) {
		$_SESSION['failure_alert'] = $message;
		header('Location: ' . $page);
		exit;
	}

	public static function js_alert($message) {
		echo '<script type="text/javascript">alert("' . $message . '")</script>';
	}
}