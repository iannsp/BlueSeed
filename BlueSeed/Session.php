<?php
namespace BlueSeed;

/**
 * 
 * This classe use Session to store and recovery data  ...
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 * 
 *
 */
class Session{
	/**
	 * 
	 * start a session
	 * @access public
	 * @return void
	 */
	public static function start(){
		session_start();
	}
	/**
	 * 
	 * Destroy a session
	 * @access public
	 * @return void
	 */	
	public static function destroy(){
		session_destroy();
	}
	/**
	 * 
	 * Save data without serialize it.
	 * can be object with resources you can serialize, scalars or Array
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	public static function setVar($name, $value){
		$_SESSION[$name] 	= 	$value;
	}
	/**
	 * 
	 * retrieve a value saved with setVar ...
	 * @see setVar
	 * @param string $name
	 * @return mixed
	 */
	public static function getVar($name){
		return $_SESSION[$name];
	}
	/**
	 * retrieve a mixed saved with setObject
	 * @see setObject
	 * @param string $name
	 * @return mixed
	 */
	public static function getObject($name){
		if ( isset( $_SESSION['objects'][$name] ) ){
			return unserialize($_SESSION['objects'][$name]);
		}
		return NULL;
	}
	/**
	 * Save data with serializing it
	 * @param string $name
	 * @param mixed  $value
	 * @return void
	 */
	public static function setObject($name, $value){
		$_SESSION['objects'][$name]		= 	serialize($value);
	}
}
