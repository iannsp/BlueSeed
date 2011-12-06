<?php

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'RequestTest.php';
require_once '../bootstrap.php';
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

