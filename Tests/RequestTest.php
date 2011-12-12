<?php

class RequestTest extends PHPUnit_Framework_TestCase
{
    private $requestEmpty; 
    private $requestFully;
    
    protected function setUp()
    {
        $this->request = New BlueSeed\Request(
            Array(), 
            Array()
        );
        $this->requestFully = New BlueSeed\Request(
            Array('TestC/test/parametro/1'=>''),
            array('Nome'=>'BlueSeed')
        );
    }
    public function testInvalidUrl(){
        $this->request = New BlueSeed\Request(
            Array('/MyController/MyAction/<!--$#@/1'=>''),
            Array()
        );
        $this->AssertEquals('Controller', $this->request->getQuery(0));
        $this->request = New BlueSeed\Request(
            Array('MyController/MyAction'),
            Array()
        );
        $this->AssertEquals('MyControllerController', $this->request->getQuery(0));
        

    }
    public function testDefault()
    {
        $this->AssertEquals('IndexController', $this->request->getQuery(0));
        $this->AssertEquals('Index', $this->request->getQuery(1));
    }
    public function testisPost()
    {
        $this->AssertFalse($this->request->isPost());
        $this->AssertTrue($this->requestFully->isPost());
    }
    public function testisGet()
    {
        $this->AssertTrue($this->request->isGet());        
        $this->AssertFalse($this->requestFully->isGet());        
    }
    public function testhasinQuery()
    {
        $this->AssertFalse($this->request->hasinQuery('parametro'));
        $this->AssertTrue($this->requestFully->hasinQuery('parametro'));        
    }
    public function testGetParam()
    {
        $this->AssertNull($this->request->getQuery('parametro'));
        $this->AssertEquals('1',$this->requestFully->getQuery('parametro'));
    }
    public function testsetParamOneValue()
    {
        $valor1 =   'valor1';
        $this->request->setParam('postparam',$valor1);
        $this->AssertEquals($valor1,$this->request->getParam('postparam'));
        $this->AssertNull($this->request->getParam('outroparam'));
        $this->AssertNull($this->requestFully->getParam('postparam'));
        
    }
    public function testCountPost()
    {
        $this->AssertEquals(0, count($this->request->getParams()));
        $this->AssertEquals(1, count($this->requestFully->getParams()));
    }
    public function testsetParamMoreValues()
    {
        $valor1 =   'valor1';
        $valor2 =   'outroValor';
        $valor3 =   'valorr';
        $this->request->setParam('valor1',$valor1);
        $this->request->setParam('valor2',$valor2);
        $this->request->setParam('valor3',$valor3);
        $this->AssertEquals($valor1,$this->request->getParam('valor1'));
        $this->AssertEquals($valor2,$this->request->getParam('valor2'));
        $this->AssertEquals($valor3,$this->request->getParam('valor3'));
        $this->AssertNull($this->request->getParam('outroValor'));
        
    }
    protected function tearDown()
    {
        $this->request = null;
    }    
}