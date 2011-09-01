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

Final class View{
	public static $data = Array();
	public static function gotoRoot(){
	    View::redirect('/',true);
	}
	public static function render($__name__){
			extract(self::$data);
		if (self::renderExists( $__name__ ) )
			require self::getRenderPath($__name__);
		else
			throw New \Exception ("render {$__name__} n�o existe");
	}
	private static function getRenderPath($__name__){
		$__name__ = str_replace('_','/', $__name__);
		return VIEW_PATH."{$__name__}.php" ;
	}
	public static function renderto($__name__){
		ob_start();
		View::render($__name__);
		$result = ob_get_contents();
		ob_end_clean();
		return $result;
	}
	public static function set($name, $value){
		self::$data[$name] = $value;
	}
	public static function redirect($__name__, $full=false){
        if (!$full){
    		$__name__ = str_replace('_','/', $__name__);
    		header("Location: ?{$__name__}");
        }else
    		header("Location: {$__name__}");
	}
	public static function renderExists( $__name__ ){
		return file_exists( self::getRenderPath($__name__) );
	}
}