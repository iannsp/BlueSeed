<?php
class ApiController extends \BlueSeed\Controller  implements \BlueSeed\ControllerInterface{
    public function __construct(){
/*
    	$signature  ="";
        $clientid   ="";
        // verifica se o servidor que esta requisitando é valido
        if (! Api::validateSignature($signature, $clientid) ){
            Service::Header(404);
        }
*/
        parent::__construct();
//        array_shift($this->URLparam);
    }
	public function Index(){
		var_dump($this->GET);
	}
	private function SolveRoute(){
	    if ( \BlueSeed\Controller::canRequest ($this->URLparam[0], $this->URLparam[1]) ){
	        $class  = $this->URLparam[0]."Controller";
	        $method = $this->URLparam[1]; 
            $c  = new $class();
            array_shift($c->URLparam);
            $this->URLparam = $this->URLparam;
            return $c->$method('json');
	    }else{
            \BlueSeed\Service::Header( \BlueSeed\Service::BADREQUEST);
	    }
	}
}
?>