<?php
namespace BlueSeed;

/**
 * 
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 *
 */

class Service{
    const OK=200;
    const NOCONTENT=204;
    const BADREQUEST=400;
    
    public static function Header($ID){
        header("HTTP/1.0 {$ID}");
    }
}
?>