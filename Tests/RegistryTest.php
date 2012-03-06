<?php
class RegistryTest extends PHPUnit_Framework_TestCase
{

    public function testsetVar()
    {
        BlueSeed\Registry::setVar('test','1');
        $this->AssertEquals(BlueSeed\Registry::getVar('test'),'1');
    }
    public function testgetVar()
    {
        BlueSeed\Registry::setVar('test','2');
        $this->AssertEquals(BlueSeed\Registry::getVar('test'),'2');
    }
    public function testsetObject()
    {
        $class = new BlueSeed\Session;
        BlueSeed\Registry::setObject('class_1',$class);
        $this->AssertEquals(BlueSeed\Registry::getObject('class_1'),$class);
        
    }
    public function testgetObject()
    {
        $class = new \StdClass;
        BlueSeed\Registry::setObject('class_2',$class);
        $this->AssertEquals(BlueSeed\Registry::getObject('class_2'),$class);
    }
    public function testsetVarSerializeObject()
    {
        $class = new BlueSeed\Session;
        BlueSeed\Registry::setVar('objSer',serialize($class));
        $this->AssertEquals( unserialize(BlueSeed\Registry::getVar('objSer')),$class);
    }
}
