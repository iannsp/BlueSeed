<?php
define( 'SYS_PATH', dirname(__FILE__) );
$pathinfo 	=	pathinfo(SYS_PATH);
define( 'APP_PATH',		$pathinfo['dirname']."/Application/");

require_once SYS_PATH.'/config/system.conf.php';
require_once APP_PATH.'/config/options.conf.php';

function _autoload_($name) {
	global $pathinfo;
	
	$searchpath 	= 	explode('\\', $name);
	$name	= array_pop( $searchpath );
	$searchpath =  $pathinfo['dirname']."/".implode('/',$searchpath)."/";
	try{
		if(file_exists("{$searchpath}{$name}.php")){
	        require_once("{$searchpath}{$name}.php");
		}
	}catch(Exception $E){
		\BlueSeed\View::render('system_notfound');		
	}
}

spl_autoload_register('_autoload_');
