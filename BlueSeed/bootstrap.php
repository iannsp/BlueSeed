<?php
define( 'SYS_PATH', dirname(__FILE__) );
$pathinfo 	=	pathinfo(SYS_PATH);

require_once SYS_PATH.'/Config/system.conf.php';
function _bsautoload_($name) {
	global $pathinfo;
	$searchpath 	= 	explode('\\', $name);
	$name	= array_pop( $searchpath );
	$searchpath =  $pathinfo['dirname'].DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR,$searchpath).DIRECTORY_SEPARATOR;
	try{
		if(file_exists("{$searchpath}{$name}.php")){
	        require_once("{$searchpath}{$name}.php");
		}
	}catch(Exception $E){
		\BlueSeed\View::render('system_notfound');
	}
}

spl_autoload_register('_bsautoload_');
