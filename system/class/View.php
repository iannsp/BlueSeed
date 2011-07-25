<?php

Final class View{
	public static $data = Array();
	private static $extracted = false;
	public static function gotoRoot(){
	    View::redirect('/',true);
	}
	public static function render($__name__){
		if ( !View::$extracted ){
			extract(self::$data);
			View::$extracted = true;
		}
		$__name__ = str_replace('_','/', $__name__);
		require VIEW_PATH."{$__name__}.php";
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
		View::$extracted = false;
	}
	public static function redirect($__name__, $full=false){
        if (!$full){
    		$__name__ = str_replace('_','/', $__name__);
    		header("Location: ?{$__name__}");
        }else
    		header("Location: {$__name__}");
	}
}