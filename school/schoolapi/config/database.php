<?php

defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
defined('DB_USER')      ? null : define('DB_USER', 'phptrain_ssp-live');
defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'D6yoIxlu_Fy6');
defined('DB_NAME')      ? null : define('DB_NAME', 'phptrain_ssp-live');

function getConnection() {
    $dbhost="localhost";
    $dbuser="phptrain_ssp-live";
    $dbpass="D6yoIxlu_Fy6";
    $dbname="phptrain_ssp-live";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
