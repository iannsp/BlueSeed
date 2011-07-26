<?php

class ApplicationController extends Controller {
	public function dispatch(){

		if( $this->canRequest($this->controller, $this->action) ){
			$controller = $this->controller ;
			$controller = new $controller();
			$controllermethod = $this->action;
			$controller->$controllermethod();
		}else{
			$controller = new IndexController();
			$controller->notfound();
		}
	}
	private function has($name){
		return file_exists(CONTROLLER_PATH.strtolower($name).".php");
	}
	private function hasAction($name, $method){
		$lookforMethod = new ReflectionClass($name);
		return $lookforMethod->hasMethod($method);
	}
	private function canRequest($controller, $method){
		return ($this->has($controller) && $this->hasAction($controller, $method));
	}
}
