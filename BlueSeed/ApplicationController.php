<?php
namespace BlueSeed;
/**
 * 
 * This Controller launch the target controller and request the request action
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 */
use \Application;
use \System;
class ApplicationController extends Controller {
	/**
	 * 
	 * Test the Request and Dispatch it
	 * @access public 
	 * @return void
	 */
	public function dispatch(){
		if ( $this->hasController($this->controller)){
			try{
				$controller = "\\Application\\Controller\\".$this->controller;
				$controller =  new $controller;
				$controllermethod = $this->action;
				if( method_exists($controller, $controllermethod)) 
					$controller->$controllermethod();
				else
					$this->notfound();
			}catch(\Exception $E){
				$this->notFound();
			}
		}else{
				$this->notFound();
		}
	}
	private function hasController($controllername){
		return file_exists( APP_PATH."Controller/{$controllername}.php" );
	}
	private function notfound(){
		\BlueSeed\View::render('system_notfound');
	}
}
