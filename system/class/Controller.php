<?php
abstract class Controller{
	protected $GET;
	protected $POST;
	protected $controller;
	protected $action;
	
	public function __construct(){
		$this->processURLParam();
		$this->POST = (object) $_POST;
	}
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