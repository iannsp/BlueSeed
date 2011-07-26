<?php

class SystemAnnotation {
	private static $instance;
	private $dados = Array();
	private $method;
	private $class;
	public function __construct($class, $method=null){
		$this->method = $method;
		$this->class = $class;
		$this->parse();
	}
	
	private function getReflectionClass(){
		if ($this->method)
			$reflection = new ReflectionMethod($this->class, $this->method); 
		else
			$reflection = new ReflectionClass($this->class); 
		return $reflection;
	}
	public function setMethod($methodname){
		$this->method = $methodname;
		$this->parse();
	}
	private function parse(){
		$docbloc = $this->getReflectionClass()->getDocComment();
		$dados = explode("\n", $docbloc);
		foreach ($dados as $dado){
			$r = trim($dado);
			if ($r != '/**' && $r!='*/' && $r!= '*'){
				$r = str_replace('* ','', $r);
				if (strpos($r, ' ')!== false){
					$r1 = explode(' ', $r);
					$this->dados[ $r1[0] ]= $r1[1];
				}
			}
		}
	}
	public function exists($key){
		return array_key_exists($key, $this->dados);		
	}
	public function get($key){
		if (!$this->exists($key))
			return NULL;
		return $this->dados[ $key ];
	}
}

?>