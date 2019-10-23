<?php
namespace Camagru\Lib;

class Mail
{
	private $email;
	private $from_name = "Camagru";
	private $from_mail = "jde-la-m@student.le-101.fr";
	private $host = "http:" . URL;

	public function __construct($email) {
		if (!empty($email))
			$this->email = $email;
	}
	
	public function registrationMail($username, $token) {
		$mail_subject = "Camagru account confirmation";
		$mail_link = $this->host . "confirm/processConfirmation/" . $username . '/' . $token;
		$mail_message = '
			<div style="background-color: #343a40; width: 100%; height: 40px; text-align: center; color: white;">
			<h3 style="padding: 10px;">Welcome to Camagru!</h3>
			</div>
			<div style="text-align: center;">
			<p>We are happy to have you on board. In order to confirm your account, please click this button:</p>
			<p>
			<br>
			<a href="' . $mail_link . '" role="button" style="background-color: #FFD700; padding: 10px; border-radius: 5px; text-decoration: none; color: white;" >Confirm Account</a>
			<br><br>
			</p>
			<small>If you have problems accessing the button, you can also paste this link into your browser: <a href="' . $mail_link . '">' . $mail_link . '</a></small>
			<br><br>
			<p>Looking forward to see more of you!</p>
			<p><img src="https://i.imgur.com/F5Gc1T8.png" width="100px" height="auto" alt="Camagru"/></p>
			</div>';
		$this->sendMail($mail_subject, $mail_message);
	}

	public function forgotPasswordMail($username, $token) {
		$mail_subject = "Reset your password";
		$mail_link = $this->host . "login/resetpassword/" . $username . '/' . $token;
		$mail_message = '
			<div style="background-color: #343a40; width: 100%; height: 40px; text-align: center; color: white;">
			<h3 style="padding: 10px;">Reset your password</h3>
			</div>
			<div style="text-align: center;">
			<p>You have requested to reset your password. In order to do so, please click this button:</p>
			<p>
			<br>
			<a href="' . $mail_link . '" role="button" style="background-color: #FFD700; padding: 10px; border-radius: 5px; text-decoration: none; color: white;" >Reset Password</a>
			<br><br>
			</p>
			<small>If you have problems accessing the button, you can also paste this link into your browser: <a href="' . $mail_link . '">' . $mail_link . '</a></small>
			<br><br>
			<p>If this wasn\'t you, please ignore this email.</p>
			<p><img src="https://i.imgur.com/F5Gc1T8.png" width="100px" height="auto" alt="Camagru"/></p>
			</div>';
		$this->sendMail($mail_subject, $mail_message);
	}

	public function newCommentMail($commenter, $imageOwnerLogin, $imageId, $commentBody) {
		$mail_subject = "Someome commented on your post";
		$mail_link = $this->host . "post/view/" . $imageId;
		$mail_message = '
			<div style="background-color: #343a40; width: 100%; height: 40px; text-align: center; color: white;">
			<h3 style="padding: 10px;">You got a new comment, ' . $imageOwnerLogin . '! 💬</h3>
			</div>
			<div style="text-align: center;">
			<p><b>' . $commenter . '</b> commented on your post, here\'s what they said:</p>
			<p>
			<br>
			<a href="' . $mail_link . '" role="button" style="background-color: #DDDDDD; padding: 20px 100px; border-radius: 5px; text-decoration: none; color: black; font-style: italic; font-size: 11px;" >' . $commentBody . '</a>
			<br><br>
			</p>
			<small>Access your post directly <a href="' . $mail_link . '">' . $mail_link . '</a></small>
			<br><br>
			<p>Looking forward to see more of you!</p>
			<p><img src="https://i.imgur.com/F5Gc1T8.png" width="100px" height="auto" alt="Camagru"/></p>
			</div>';
		$this->sendMail($mail_subject, $mail_message);
	}

	public function newLikeMail($liker, $imageOwnerLogin, $imageId) {
		$mail_subject = "Someome liked your post";
		$mail_link = $this->host . "post/view/" . $imageId;
		$mail_message = '
			<div style="background-color: #343a40; width: 100%; height: 40px; text-align: center; color: white;">
			<h3 style="padding: 10px;">You got a new like, ' . $imageOwnerLogin . '! 👍</h3>
			</div>
			<div style="text-align: center;">
			<p><b>' . $liker . '</b> liked your post</p>
			<small>Access your post directly <a href="' . $mail_link . '">' . $mail_link . '</a></small>
			<br><br>
			<p>Looking forward to see more of you!</p>
			<p><img src="https://i.imgur.com/F5Gc1T8.png" width="100px" height="auto" alt="Camagru"/></p>
			</div>';
		$this->sendMail($mail_subject, $mail_message);
	}

	private function sendMail($mail_subject, $mail_message) {
		$encoding = "utf-8";
		$subject_preferences = array(
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\r\n"
		);
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: ".$this->from_name." <".$this->from_mail."> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: ".date("r (T)")." \r\n";
		$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);
	
		mail($this->email, $mail_subject, $mail_message, $header);
	}
}