<?php

class ApplicationController extends Controller {
	public function dispatch(){
		if (count($this->URLparam) == 0){
			$controller = new IndexController();
			$controller->Index();
		}else{
				$method = (isset($this->URLparam[1]) && $this->URLparam[1]!='' )?$this->URLparam[1]:"Index";
				if(self::canRequest($this->URLparam[0], $method)){
					$controller = $this->URLparam[0]."Controller" ;
					$controller = new $controller();
					$controllermethod = $method;
					$ab = new BusinessAnnotation($this->URLparam[0]."Controller");
					$ab->setMethod($controllermethod);
					$controller->$controllermethod();
				}else{
					$controller = new IndexController();
					$controller->notfound();
				}
		}
	}
	public static function has($name){
		return file_exists(CONTROLLER_PATH.strtolower($name)."Controller.php");
	}
	public static function hasAction($name, $method){
		$name_ = ucfirst($name);
		$lookforMethod = new ReflectionClass("{$name_}Controller");
		return $lookforMethod->hasMethod($method);
	}
	public static function canRequest($controller, $method){
		return (self::has($controller) and self::hasAction($controller, $method));
	}
}
