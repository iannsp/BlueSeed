<?php
/**
 * 
 * This Controller launch the target controller and request the request action
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 */

class ApplicationController extends Controller {
	/**
	 * 
	 * Test the Request and Dispatch it
	 * @access public 
	 * @return void
	 */
	public function dispatch(){
		if ( class_exists($this->controller) and method_exists( $this->controller, $this->action)){
			$controller = new $this->controller();
			$controllermethod = $this->action;
			$controller->$controllermethod();
		}else{
			$controller = new IndexController();
			$controller->notfound();
		}
	}
}
