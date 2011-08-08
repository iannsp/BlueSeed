<?php
require_once '../BlueSeed/bootstrap.php';

require_once APP_PATH.'/Config/options.conf.php';

define('PEAR_PATH',					APP_PATH.'/Vendor/Pear/');
define('LOCALE_PATH'			, 	APP_PATH."/Locale/");

BlueSeed\Session::start();
$systimezone= new DateTimeZone('America/Sao_Paulo');
BlueSeed\Registry::setVar('timezone', $systimezone);

$database = BlueSeed\Database::getInstance();
$database->loadfromConf(APP_PATH.'Config/db.conf');
