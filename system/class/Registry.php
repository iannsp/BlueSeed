<?php

class Registry{
	private static $data = Array();
	public static function setVar($name, $value){
		self::$data[$name] = $value;
	}
	public static function getVar($name){
		return self::$data[$name];
	}
	public static function getObject($name){
		if (isset(self::$data['objects'][$name])){
			return unserialize(self::$data['objects'][$name]);
		}
/*		if (isset($_SESSION['objects'][$name])){
				return unserialize($_SESSION['objects'][$name]);
			}
*/			
		return NULL;
	}
	public static function setObject($name, $value){
		self::$data['objects'][$name]	= serialize($value);
//			$_SESSION['objects'][$name]  = serialize( $value );
	}
}
