<?php
App::uses('Joboffer', 'Model');

/**
 * Joboffer Test Case
 *
 */
class JobofferTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.joboffer',
		'app.company'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Joboffer = ClassRegistry::init('Joboffer');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Joboffer);

		parent::tearDown();
	}

}
