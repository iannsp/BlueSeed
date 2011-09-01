<?php
namespace BlueSeed;
/**
 *
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 * @abstract
 */
use BlueSeed\Observer\ObserverCollection;
use BlueSeed\Observer\Observable;
use BlueSeed\Observer\Observer;

abstract class Controller implements  Observable{
	/**
	 *
	 * the observer Collection to ApplicationController
	 * @var ObserverCollection
	 */
	protected $observerCollection=Array();

	/**
	 * The name of requested Controller
	 * @var String
	 * @access protected
	 */
	protected $controller;
	/**
	 * the name of requested Action
	 * @var String
	 * @access protected
	 */
	protected $action;
	/**
	 * The constructor set the needed variables to operate the action
	 * @param Request $R the request the Application Receive
	 * @return void
	 * @access public
	 */
	public function __construct(Request $R){
		$this->Request 		= $R;
		$this->controller 	= $this->Request->getQuery(0);
		$this->action		= $this->Request->getQuery(1);
	}

	/**
	 * Retrieve the Request Object
	 */
	public function getRequest()
	{
		return $this->Request;
	}

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
//			var_dump($observer);
			$observer->update ($this);
		}
	}

}