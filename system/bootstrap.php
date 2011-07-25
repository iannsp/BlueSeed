<?php
session_start();
define( 'APP_PATH', dirname(__FILE__).'/' );

require_once 'config/system.conf.php';

parse_ini_file('config/db.conf');

function _autoload_($name) {
	if(file_exists(APP_PATH."class/{$name}.php")){
        require_once(APP_PATH."class/{$name}.php");
    }
	else if(file_exists(APP_PATH."controller/{$name}.php")){
        require_once(APP_PATH."controller/{$name}.php");
    }
    else if(file_exists(INTERFACE_PATH."{$name}.php")){
        require_once(INTERFACE_PATH."{$name}.php");
    }
}
spl_autoload_register('_autoload_');
$systimezone= new DateTimeZone('America/Sao_Paulo');
Registry::RegistryVar('timezone', $systimezone);
