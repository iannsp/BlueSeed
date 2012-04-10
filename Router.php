<?php

namespace BlueSeed;
/**
* change the Request Class name e Method name to real Objects Definition
* using search replace for it
**/
class Router
{
    private $request;
    private $rc;
    public function __construct(array $config, Request $req)
    {
        $this->request  = $req;
        $this->rc       = $config;
    }
    public function resolve($language)
    {
       $classtoRoute = str_replace('Controller','',$this->request->getQuery(0));
       $methotoRoute = $this->request->getQuery(1);
       $dictionary   = ($this->rc[$language]); 
       $route  = strtolower($classtoRoute)."/".strtolower($methotoRoute);  
       if(array_key_exists($route,$dictionary)) {
            $routeparts = explode("/",$dictionary[$route]);
            $this->request->setController($routeparts[0]);
            $this->request->setAction($routeparts[1]);
       }
    }
}
