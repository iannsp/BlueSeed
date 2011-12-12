<?php
/*
 * get information about directory BS Framework are
 */
define( 'SYS_PATH', __DIR__ );

/*
 * load the BS Framework configuration
 */
require_once SYS_PATH.'/Config/system.conf.php';
/**
 *
 * autoload to BS Framework Objects
 * @param string $name
 */
function _bsautoload_($name) {
	$pathinfo     =    pathinfo(__DIR__ );
    $searchpath     =     explode('\\', $name);
    $name    = array_pop( $searchpath );
    $searchpath =  $pathinfo['dirname'].DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR,$searchpath).DIRECTORY_SEPARATOR;
    try{
        if(file_exists("{$searchpath}{$name}.php")){
            require_once("{$searchpath}{$name}.php");
        }
    }catch(Exception $E){
        \BlueSeed\View::render('system_notfound');
    }
}

/**
 * register this autoload function in spl_registers
 */
spl_autoload_register('_bsautoload_');
