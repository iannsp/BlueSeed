<?php
namespace BlueSeed;
use BlueSeed\Request;
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
     * @access public
     */
    public function __construct(Request $R){
        $this->Request         = $R;
        $this->controller     = $this->Request->getQuery(0);
        $this->action        = $this->Request->getQuery(1);
    }
	/**
	 *
	 * This is the main Controller Method
	 */
    public function Index()
    {
    	$sa = SystemAnnotation::createasClass($this);
    	if($sa->exists('@scaffold')){
    		if (defined('VO_NAMESPACE'))
				$objData = VO_NAMESPACE.$sa->get('@scaffold')."Vo";
			else
				$objData = $sa->get('@scaffold')."Vo";
			$objData = New $objData();
			Scaffold::creator($objData, $this->getRequest())->make();
    	}
    }

    /**
     *
     * Return the action of Controller
     */
	public function getAction()
	{
		return $this->action;
	}
    /**
     * Retrieve the Request Object
     * @return \BlueSeed\Request
     */
    public function getRequest()
    {
        return $this->Request;
    }

    /**
     * (non-PHPdoc)
     * @see BlueSeed\Observer.Observable::attachObserver()
     */
    public function attachObserver(Observer $o)
    {
        array_push($this->observerCollection, $o);
    }

    /**
     * (non-PHPdoc)
     * @see BlueSeed\Observer.Observable::detachObserver()
     */

    public function detachObserver(Observer $o)
    {
        foreach ($this->observerCollection as $okey => $observer) {
            if ($observer === $o)
                unset($this->observerCollection[$okey]);
                break;
        }
    }

    /**
     * (non-PHPdoc)
     * @see BlueSeed\Observer.Observable::notifyObservers()
     */
    public function notifyObservers()
    {
        foreach ($this->observerCollection as $observer) {
            $observer->update ($this);
        }
    }

}