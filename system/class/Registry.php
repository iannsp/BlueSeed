<?php
/**
 * 
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
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
	 * set a new data. If data exists its override
	 * this method can Set Object but without serialize
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	public static function setVar($name, $value){
		self::$data[$name] = $value;
	}
	/**
	 * 
	 * retrieve the data stored in informed label
	 * @param string $name
	 * @return mixed
	 */
	public static function getVar($name){
		return self::$data[$name];
	}
	/**
	 * 
	 * retrieve the data stored in informed label before unserialize it
	 * @param unknown_type $name
	 * @return mixed
	 */
	public static function getObject($name){
		if (isset(self::$data['objects'][$name])){
			return unserialize(self::$data['objects'][$name]);
		}
		return NULL;
	}
	/**
	 * 
	 * set a new data. If data exists its override
	 * this method serialize the data before store
	 * @param string $name
	 * @package mixed $value
	 */
	public static function setObject($name, $value){
		self::$data['objects'][$name]	= serialize($value);
	}
}
