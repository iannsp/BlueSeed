<?php
/*
 * get information about directory BS Framework are
 */
define( 'SYS_PATH', dirname(__FILE__) );
$pathinfo     =    pathinfo(SYS_PATH);

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
    global $pathinfo;
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
