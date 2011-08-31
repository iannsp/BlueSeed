<?php
namespace BlueSeed;
use BlueSeed\Observer\ObserverCollection;
/**
 *
 * This Controller launch the target controller and request the request action
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 */

use BlueSeed\Observer\Observer;

use \Application;
use \System;
use \BlueSeed\Observer\ObserverCollection 	as ObserverCollection;
use BlueSeed\Observer\Observable;
class ApplicationController extends Controller implements  Observable{

	/**
	 *
	 * the observer Collection to ApplicationController
	 * @var ObserverCollection
	 */
	private $observerCollection;

	public function attachObserver(Observer $o)
	{
		array_push($this->observerCollection, $o);
	}
	public function detachObserver(Observer $o)
	{
		foreach ($this->observerCollection as $okey => $observer) {
			if ($observer === $o)
				unset($this->observerCollection[$okey]);
				break;
		}
	}
	public function notifyObservers()
	{
		foreach ($this->observerCollection as $observer) {
			$observer->update ($this);
		}
	}

	/**
	 *
	 * The constructor of Controller set type of ObserverCollection
	 */
	public function __construct(){
		parent::__construct();
		$this->observerCollection = new ObserverCollection();
	}
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
