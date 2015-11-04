<?php
App::uses('Jobhunter', 'Model');

/**
 * Jobhunter Test Case
 *
 */
class JobhunterTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.jobhunter',
		'app.status'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Jobhunter = ClassRegistry::init('Jobhunter');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Jobhunter);

		parent::tearDown();
	}

}
