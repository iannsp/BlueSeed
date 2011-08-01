<?php
namespace BlueSeed;

/**
 * 
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 * @abstract
 *
 */
abstract class Controller{
	/**
	 * 
	 * The data received in $_GET parsed by processURLParam
	 * @var ARRAY
	 * @access protected
	 */
	protected $GET;
	/**
	 * 
	 * The data received in $_POST  
	 * @var Array 
	 * @access protected
	 */
	protected $POST;
	/**
	 * 
	 * The name of requested Controller
	 * @var String
	 * @access protected
	 */
	protected $controller;
	/**
	 * 
	 * the name of requested Action
	 * @var String
	 * @access protected
	 */
	protected $action;
	/**
	 * 
	 * The constructor set the needed variables to operate the action
	 * @return void
	 * @access public
	 */
	public function __construct(){
		$this->processURLParam();
		$this->POST = (object) $_POST;
	}
	/**
	 * 
	 * Method where the friendly URL are parsed into Controller / 
	 * and Action /Data1/Data2/DataN
	 * @return void
	 * @access private
	 */
	private function processURLParam(){
		$GET = Array();
		if (count($_GET)>0){
			$k = array_keys($_GET);
			$GET = explode('/', $k[0]);
			$this->controller 	= ucfirst(trim(array_shift($GET )))."Controller";
			$this->action		= trim(array_shift($GET));
			if($this->action == '')
				$this->action	= "Index";
			$this->GET			= trim(implode(',',$GET));			
		}else{
			$this->controller 	= "IndexController";
			$this->action		= "Index";
		}
	}
}