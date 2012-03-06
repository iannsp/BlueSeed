<?php

/**
 * ActiveRecordHook test case.
 */
use BlueSeed\ActiveRecord;
use BlueSeed\ActiveRecordHook;
class ActiveRecordHookTest extends PHPUnit_Framework_TestCase {

    private $ActiveRecordHook;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp ();
        $this->ActiveRecordHook = new ActiveRecordHook();
    }

    protected function tearDown() {
        $this->ActiveRecordHook = null;
        parent::tearDown ();
    }

    public function __construct() {
        // TODO Auto-generated constructor
    }

    public function test__construct()
    {
        $this->ActiveRecordHook = new \BlueSeed\ActiveRecordHook();
    }
    public function testgetHook()
    {
        $hook1 = function($record){
                    var_dump($record);
                };
        $hook2 = function($record){
                    var_dump($record);
                };
        $this->ActiveRecordHook->add( ActiveRecordHook::AFTERSAVE , $hook1);
        $this->ActiveRecordHook->add( ActiveRecordHook::AFTERUPDATE , $hook2);
        $this->AssertEquals(1, count($this->ActiveRecordHook->get(ActiveRecordHook::AFTERSAVE)));
        $this->AssertEquals(0, count($this->ActiveRecordHook->get(ActiveRecordHook::AFTERDELETE)));
        $this->AssertEquals(1, count($this->ActiveRecordHook->get(ActiveRecordHook::AFTERUPDATE)));
    }
    public function testAdd()
    {
        $hook1 = function($record){
                    var_dump($record);
                };
        $this->ActiveRecordHook->add( ActiveRecordHook::AFTERSAVE , $hook1);
        $hooks = $this->ActiveRecordHook->get(ActiveRecordHook::AFTERSAVE);
        $this->AssertEquals($hook1, $hooks[0]);

        $hook2 = function($record){
                    var_dump($record);
                };
        $this->ActiveRecordHook->add( ActiveRecordHook::AFTERSAVE , $hook2);
        $hooks = $this->ActiveRecordHook->get(ActiveRecordHook::AFTERSAVE);
        $this->AssertEquals($hook2, $hooks[1]);

    }
    public function testExec()
    {
        $record = $this->getMock('BlueSeed\ActiveRecord');
        $record->nome = "ObjName";
        $cluename = function($record){
                    return "name:".$record->nome;
        };
        $cluename2        = function($record) {
                $record->nome = "name:".$record->nome;
        };
        $this->ActiveRecordHook->add(ActiveRecordHook::AFTERSAVE, $cluename);
        $this->ActiveRecordHook->add(ActiveRecordHook::AFTERUPDATE, $cluename2);
        $hooks = $this->ActiveRecordHook->get(ActiveRecordHook::AFTERSAVE);
        $hook = $hooks[0];
        $this->AssertEquals("name:".$record->nome, $hook($record) );
        $this->ActiveRecordHook->exec(ActiveRecordHook::AFTERUPDATE, $record);
        $this->AssertEquals("name:ObjName", $record->nome );
    }
    public function testCount()
    {
        $this->AssertEquals(0, $this->ActiveRecordHook->count());
        $cluename2        = function($record) {
                $record->nome = "name:".$record->nome;
        };
        $this->ActiveRecordHook->add(ActiveRecordHook::AFTERSAVE, $cluename2);
        $this->AssertEquals(1, $this->ActiveRecordHook->count());
    }
    /**
     * @expectedException \Exception
     */
    public function testgetHookType()
    {
            $this->ActiveRecordHook->get(10);

    }
    /**
     * @expectedException \Exception
     */
    public function testsetHookType()
    {
        $cluename        = function($record) {};
        $this->ActiveRecordHook->add(1000, $cluename);

    }
}

