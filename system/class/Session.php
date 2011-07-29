<?php
// elaborar melhor uma solucao para Session e Register...
class Session{
	public static function start(){
		session_start();
	}
	public static function destroy(){
		session_destroy();
	}
	public static function setVar($name, $value){
		$_SESSION[$name] 	= 	$value;
	}
	public static function getVar($name){
		return $_SESSION[$name];
	}
	public static function getObject($name){
		if ( isset( $_SESSION['objects'][$name] ) ){
			return unserialize($_SESSION['objects'][$name]);
		}
		return NULL;
	}
	public static function setObject($name, $value){
		$_SESSION['objects'][$name]		= 	serialize($value);
	}
}
