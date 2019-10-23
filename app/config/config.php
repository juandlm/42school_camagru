<?php
define("ENVIRONMENT", "prod");
define("CAMAGRU_OS", stristr(php_uname('s'), "win") ? "WIN" : "OTHER");

if (ENVIRONMENT == "dev") {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

date_default_timezone_set("Europe/Paris");
mb_internal_encoding("UTF-8");
mb_http_output("UTF-8");

$workDir = dirname($_SERVER["SCRIPT_NAME"]);
$workDir .= (substr($workDir, -1) === DIRECTORY_SEPARATOR) ? '' : '/';

define("URL_PROTOCOL", "//");
define("URL_DOMAIN", $_SERVER["HTTP_HOST"]);
define("URL_SUB_FOLDER", $workDir);
define("URL", URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

require_once(APP . "config/database.php");

define("DB_DSN", $DB_DSN);
define("DB_USER", $DB_USER);
define("DB_PASS", $DB_PASSWORD);