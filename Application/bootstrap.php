<?php
require_once '../BlueSeed/bootstrap.php';

require_once APP_PATH.'/Config/options.conf.php';
define('PEAR_PATH',					APP_PATH.'/vendor/Pear/');
define('LOCALE_PATH'			, 	APP_PATH."/locale/");

BlueSeed\Session::start();
$systimezone= new DateTimeZone('America/Sao_Paulo');
BlueSeed\Registry::setVar('timezone', $systimezone);

$database = BlueSeed\Database::getInstance();
$database->loadfromConf(APP_PATH.'config/db.conf');
