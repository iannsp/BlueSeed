<?php
class DatabaseTest extends PHPUnit_Framework_TestCase {
    private $config;
    private $database;
    private $configpath;
    
    public function setUp()
    {
        $this->database = BlueSeed\Database::getInstance();
        $this->configpath = __DIR__."/fixtures/databaseconfigtest.ini";    
    }
    public function tearDown()
    {
        $this->database = null;
    }
    public function testloadfromConf()
    {
        $this->database->loadfromConf($this->configpath);
        $this->AssertInstanceOf('BlueSeed\DatabaseConnection',$this->database->get('db_test1'));
    }
    public function testaddDatabase()
    {
        $database = $this->getMockBuilder('BlueSeed\DatabaseConnection')
                    ->disableOriginalConstructor()
                    ->getMock();
        $this->database->addDatabase('ref_01', $database);
        $this->AssertEquals($this->database->get('ref_01'), $database);
    }
    public function testgetDatabase()
    {
        $database = $this->getMockBuilder('BlueSeed\DatabaseConnection')
                    ->disableOriginalConstructor()
                    ->getMock();
        $this->database->addDatabase('ref_01', $database);
        $this->AssertEquals($this->database->get('ref_01'), $database);
    }
    
    /**
    *
    * @expectedException Exception
    */
    public function testgetNoDatabase()
    {
        $this->AssertEquals($this->database->get('ref_01'), $database);
    }
    public function testgetInstance()
    {
        $this->AssertTrue(($this->database===BlueSeed\Database::getInstance()));
        
    }
}