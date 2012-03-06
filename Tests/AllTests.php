<?php
require_once 'bootstrap.php';
//require_once 'RequestTest.php';
//require_once 'ActiveRecordHookTest.php';
//require_once 'ActiveRecordTest.php';
class BlueSeedSuite extends PHPUnit_Framework_TestSuite {

    /**
     * Constructs the test suite handler.
     */
    public function __construct() {
        $this->setName ( 'BlueSeedSuite' );
 //       $this->addTestSuite('RequestTest');
 //       $this->addTestSuite ( 'ActiveRecordHookTest' );
 //       $this->addTestSuite ( 'ActiveRecordTest' );
    }
    protected function setUp()
        {
        }

    protected function tearDown()
    {
    }
    public static function suite() {
        return new self ();
    }
}
