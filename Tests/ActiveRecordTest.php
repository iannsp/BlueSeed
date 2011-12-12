<?php

/**
 * ActiveRecord test case.
 */
class ActiveRecordTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var ActiveRecord
	 */
	private $ActiveRecord;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();

		// TODO Auto-generated ActiveRecordTest::setUp()
		$this->ActiveRecord = $this->getMockForAbstractClass('BlueSeed\ActiveRecord');
		$this->ActiveRecord->expects($this->any())
             ->method('getIndexName')
             ->will($this->returnValue('id'));
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated ActiveRecordTest::tearDown()


		$this->ActiveRecord = null;

		parent::tearDown ();
	}

	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}

	/**
	 * Tests ActiveRecord::attachHooks()
	 */
	public function testAttachHooks() {
		// TODO Auto-generated ActiveRecordTest::testAttachHooks()
		$this->markTestIncomplete ( "attachHooks test not implemented" );

		//ActiveRecord::attachHooks(/* parameters */);

	}

	/**
	 * Tests ActiveRecord->getMeta()
	 */
	public function testGetMeta() {
		// TODO Auto-generated ActiveRecordTest->testGetMeta()
		$this->markTestIncomplete ( "getMeta test not implemented" );

		//$this->ActiveRecord->getMeta(/* parameters */);

	}

	/**
	 * Tests ActiveRecord->getIndexName()
	 */
	public function testGetIndexName() {
		$this->AssertEquals('id',$this->ActiveRecord->getIndexName());
	}

	/**
	 * Tests ActiveRecord->getIndexValue()
	 */
	public function testGetIndexValue() {
		// TODO Auto-generated ActiveRecordTest->testGetIndexValue()
		$this->markTestIncomplete ( "getIndexValue test not implemented" );

		$this->ActiveRecord->getIndexValue(/* parameters */);

	}

	/**
	 * Tests ActiveRecord->getTableName()
	 */
	public function testGetTableName() {
		// TODO Auto-generated ActiveRecordTest->testGetTableName()
		$this->markTestIncomplete ( "getTableName test not implemented" );

		$this->ActiveRecord->getTableName(/* parameters */);

	}

	/**
	 * Tests ActiveRecord->getConnectionName()
	 */
	public function testGetConnectionName() {
		// TODO Auto-generated ActiveRecordTest->testGetConnectionName()
		$this->markTestIncomplete ( "getConnectionName test not implemented" );

		$this->ActiveRecord->getConnectionName(/* parameters */);

	}

	/**
	 * Tests ActiveRecord::fetchAll()
	 */
	public function testFetchAll() {
		// TODO Auto-generated ActiveRecordTest::testFetchAll()
		$this->markTestIncomplete ( "fetchAll test not implemented" );

		//ActiveRecord::fetchAll(/* parameters */);

	}

	/**
	 * Tests ActiveRecord::find()
	 */
	public function testFind() {
		// TODO Auto-generated ActiveRecordTest::testFind()
		$this->markTestIncomplete ( "find test not implemented" );

		//ActiveRecord::find(/* parameters */);

	}

	/**
	 * Tests ActiveRecord->save()
	 */
	public function testSave() {
		// TODO Auto-generated ActiveRecordTest->testSave()
		$this->markTestIncomplete ( "save test not implemented" );

		$this->ActiveRecord->save(/* parameters */);

	}

	/**
	 * Tests ActiveRecord->delete()
	 */
	public function testDelete() {
		// TODO Auto-generated ActiveRecordTest->testDelete()
		$this->markTestIncomplete ( "delete test not implemented" );

		$this->ActiveRecord->delete(/* parameters */);

	}

}

