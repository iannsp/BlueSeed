<?php
namespace BlueSeed;

/**
 *
 * The controller to support interpretation of requests
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @package system
 *
 */

class SystemAnnotation {
    private $dados = Array();
    private $methodName;
    private $type;
    private $propertyName;
    private $class;
    private function __construct($class,$type, $method=null, $property=null){
    	$this->type			= $type;
        $this->methodName 	= $method;
        $this->propertyName = $property;
        $this->class 		= $class;
        $this->parse();
    }
    public static function createasProperty($class, $propertyName)
    {
		return New SystemAnnotation($class, "property", NULL, $propertyName);
    }
    public static function createasMethod($class, $methodName)
    {
		return New SystemAnnotation($class, "method", $methodName);
    }
    public static function createasClass($class)
    {
		return New SystemAnnotation($class, "class");
    }

    private function getReflectionClass(){
    	switch($this->type) {
    		case "class" :
            	$reflection = new \ReflectionClass($this->class);
            	break;
    		case "property":
            	$reflection = new \ReflectionProperty($this->class, $this->propertyName);
    			break;
    		case "method":
            	$reflection = new \ReflectionMethod($this->class, $this->methodName);
    			break;
    	}
        return $reflection;
    }
    public function updateTarget($target)
    {
    	$update = "update".ucfirst( $this->type);
		$this->$update($target);
        $this->parse();
    }
    private function updateMethod($methodName)
    {
		$this->methodName 		= $methodName;
    }
    private function updateClass($class)
    {
		$this->class 			= $class;
    }
    private function updateProperty($propertyName)
    {
		$this->propertyName		= $propertyName;
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