<?php
require_once 'bootstrap.php';
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'ActiveRecordHookTest.php';
require_once 'ActiveRecordTest.php';
/**
 * Static test suite.
 */
class testSuite extends PHPUnit_Framework_TestSuite {

    /**
     * Constructs the test suite handler.
     */
    public function __construct() {
        $this->addTestSuite ( 'ActiveRecordHookTest' );
        $this->addTestSuite ( 'ActiveRecordTest' );
    }

    /**
     * Creates the suite.
     */
    public static function suite() {
        return new self ();
    }
}

