<?php
if (!empty($_SESSION['success_alert'])) {
	echo '<div class="alert alert-success container" id="alert_s" role="alert">' .
		$_SESSION['success_alert'] .
    '</div>';
	$_SESSION['success_alert'] = null;
} elseif (!empty($_SESSION['warning_alert'])) {
	echo '<div class="alert alert-warning container" id="alert" role="alert">' .
		$_SESSION['warning_alert'] . 
    '</div>';
	$_SESSION['warning_alert'] = null;
} elseif (!empty($_SESSION['failure_alert'])) {
	echo '<div class="alert alert-danger container" id="alert" role="alert">' .
		$_SESSION['failure_alert'] . 
    '</div>';
	$_SESSION['failure_alert'] = null;
}
