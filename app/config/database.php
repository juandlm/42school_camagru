<?php
$DB_USER = 'root';
$DB_PASSWORD = CAMAGRU_OS == "WIN" ? 'root' : 'rootpass';
$DB_NAME = 'db_camagru';
$DB_HOST = CAMAGRU_OS == "WIN" ? 'localhost' : 'mysql';
$DB_DSN = 'mysql:dbname=' . $DB_NAME . ';host=' . $DB_HOST . ';charset=utf8mb4';