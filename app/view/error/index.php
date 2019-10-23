<?php
	$title = '404';
	$crumb = false;
	?>
<style>
	body {
	padding: 0;
	margin: 0;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	}
	#notfound {
	position: relative;
	height: 80vh;
	}
	#notfound .notfound {
	position: absolute;
	left: 50%;
	top: 50%;
	-webkit-transform: translate(-50%, -50%);
	-ms-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	}
	.notfound {
	max-width: 520px;
	width: 100%;
	line-height: 1.4;
	text-align: center;
	}
	.notfound .notfound-404 {
	position: relative;
	height: 240px;
	}
	.notfound .notfound-404 h1 {
	position: absolute;
	left: 50%;
	top: 50%;
	-webkit-transform: translate(-50%, -50%);
	-ms-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	font-size: 252px;
	font-weight: 900;
	margin: 0px;
	color: #262626;
	letter-spacing: -40px;
	margin-left: -20px;
	}
	.notfound .notfound-404 h1>span {
	text-shadow: -8px 0px 0px #fff;
	}
	.notfound .notfound-404 h3 {
	position: relative;
	font-size: 16px;
	font-weight: 700;
	text-transform: uppercase;
	color: #262626;
	margin: 0px;
	letter-spacing: 3px;
	padding-left: 6px;
	}
	.notfound h2 {
	font-size: 20px;
	font-weight: 400;
	color: #000;
	margin-top: 0px;
	margin-bottom: 25px;
	}
	@media only screen and (max-width: 767px) {
	.notfound .notfound-404 {
	height: 200px;
	}
	.notfound .notfound-404 h1 {
	font-size: 200px;
	}
	}
	@media only screen and (max-width: 480px) {
	.notfound .notfound-404 {
	height: 162px;
	}
	.notfound .notfound-404 h1 {
	font-size: 162px;
	height: 150px;
	line-height: 162px;
	}
	.notfound h2 {
	font-size: 16px;
	}
	}
</style>
<div id="notfound">
	<div class="notfound">
		<div class="notfound-404">
			<h3>Woops! Page not found</h3>
			<h1><span>4</span><span>0</span><span>4</span></h1>
		</div>
		<h2>We're sorry, but the page you requested was not found.</h2>
		<a class="btn btn-primary" href="<?= URL; ?>" role="button">Go back home</a>
	</div>
</div>