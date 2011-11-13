<?php
namespace BlueSeed;
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
class ApplicationController extends Controller {


    /**
     *
     * The constructor of Controller set type of ObserverCollection
     * @param \BlueSeed\Request $R
     */
    public function __construct(Request $R){
        parent::__construct($R);
//        $this->observerCollection = new ObserverCollection();
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
                $controllername = "\\Application\\Controller\\".$this->controller;
                $controller =  new $controllername($this->getRequest());
                $controllermethod = $controller->getRequest()->getQuery(1);
                if( method_exists($controller, $controllermethod)) {
                    foreach ($this->observerCollection as $obs) {
                        $controller->attachObserver($obs);
                    }
                    $controller->notifyObservers();
                    $controller->$controllermethod();
                }
                else {
                    $this->notfound($this->controller, $this->action);
                }
            }catch(\Exception $E){
                View::set('exception', $E);
                View::render('system_exception');
            }
        }else{
                $this->notFound($this->controller, $this->action);
        }
    }
    /**
     *
     * verify if controller exist
     * @param string $controllername
     * @return bool
     * @access private
     */
    private function hasController($controllername){
        return file_exists( APP_PATH."Controller/{$controllername}.php" );
    }
    /**
     *
     * Default behavior if controller and method does not exist
     * @param string $controller
     * @param string $action
     * @return void
     */
    private function notfound($controller, $action){
        \BlueSeed\View::set('controller', $controller);
        \BlueSeed\View::set('action', $action);
        \BlueSeed\View::render('system_notfound');
    }
}
