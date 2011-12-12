<?php
require_once 'bootstrap.php';
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'RequestTest.php';
require_once '../bootstrap.php';
require_once 'ActiveRecordHookTest.php';
require_once 'ActiveRecordTest.php';
/**
 * Static test suite.
 */
class BlueSeedSuite extends PHPUnit_Framework_TestSuite {

    /**
     * Constructs the test suite handler.
     */
    public function __construct() {
        $this->setName ( 'BlueSeedSuite' );
        $this->addTestSuite('RequestTest');
        $this->addTestSuite ( 'ActiveRecordHookTest' );
        $this->addTestSuite ( 'ActiveRecordTest' );
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

