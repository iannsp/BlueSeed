<?php
namespace BlueSeed;

/**
 *
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 *
 */

class Registry{
    /**
     *
     * wher ethe data are stored
     * @var unknown_type
     * @static
     */
    private static $data = Array();

    /**
    * 
    * to set values into registry
    * @param $name string The ID to recovery the data
    * @param $var mixed value to storage
    */
    public static function  set($name, $var)
    {
        self::$data[$name] = $var;
    }
    /**
    * 
    * to recovery values
    * @param $name string
    */
    public static function get($name)
    {
        if (array_key_exists($name, self::$data)){
            return self::$data[$name];
        }
        return null;
    }

    /**
     *
     * to old versions works
     */
    public static function setVar($name, $value){
        self::set($name, $value);
    }

    /**
     *
     * to old versions works
     */
    public static function getVar($name){
        return self::get($name);
    }

    /**
     *
     * to old versions works
     */
    public static function getObject($name){
        return self::get($name);
    }

    /**
     *
     * to old versions works
     */
    public static function setObject($name, $value){
        return self::set($name, $value);
    }
}
