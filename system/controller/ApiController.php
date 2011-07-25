<?php
class ApiController extends Controller  implements ControllerInterface{
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
        array_shift($this->URLparam);
    }
	public function Index(){
	}
	private function SolveRoute(){
	    if ( Controller::canRequest ($this->URLparam[0], $this->URLparam[1]) ){
	        $class  = $this->URLparam[0]."Controller";
	        $method = $this->URLparam[1]; 
            $c  = new $class();
            array_shift($c->URLparam);
            $this->URLparam = $this->URLparam;
            return $c->$method('json');
	    }else{
            Service::Header(Service::BADREQUEST);
	    }
	}
}
?>