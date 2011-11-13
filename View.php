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
    /**
     *
     * render the view plus the variables
     * @param string $__name__
     * @throws \Exception
     */
    public static function render($__name__){
            extract(self::$data);
        if (self::renderExists( $__name__ ) )
            require self::getRenderPath($__name__);
        else
            throw New \Exception ("render {$__name__} n�o existe");
    }

    /**
     *
     * get the View path
     * @param string $__name__
     * @return string
     */
    private static function getRenderPath($__name__){
        $__name__ = str_replace('_','/', $__name__);
        return VIEW_PATH."{$__name__}.php" ;
    }
    /**
     *
     * like render method but return the renderized content instead print it to stdout
     * @param string $__name__
     * @return string
     */
    public static function renderto($__name__){
        ob_start();
        View::render($__name__);
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    /**
     *
     * Inform a variable into View Content
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public static function set($name, $value){
        self::$data[$name] = $value;
    }

    /**
     *
     * make easy redirect a page using the BS
     * @param string $__name__
     * @param bool $full if true can be a external url, if false, is internal
     * @throws \Exception
     * @return void
     */
    public static function redirect($__name__, $full=false){
        if (!$full){
            $__name__ = str_replace('_','/', $__name__);
            header("Location: ?{$__name__}");
        }else
            header("Location: {$__name__}");
    }
    /**
     *
     * verify if a render exist
     * @param string  $__name__
     * @return void
     */
    public static function renderExists( $__name__ ){
        return file_exists( self::getRenderPath($__name__) );
    }
}