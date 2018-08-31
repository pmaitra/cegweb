<?php

defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
defined('DB_USER')      ? null : define('DB_USER', 'cegweb1');
defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'cegweb123');
defined('DB_NAME')      ? null : define('DB_NAME', 'phptrain_ssp-live');

function getConnection() {
    $dbhost="localhost";
    $dbuser="cegweb1";
    $dbpass="cegweb123";
    $dbname="phptrain_ssp-live";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}