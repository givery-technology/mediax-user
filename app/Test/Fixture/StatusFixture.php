<?php
/**
 * StatusFixture
 *
 */
class StatusFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'status';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'jobhunter_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'companies_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'flag' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'end_date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modifield' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'jobhunter_id' => 1,
			'companies_id' => 1,
			'flag' => 1,
			'end_date' => '2013-03-22 05:10:16',
			'created' => '2013-03-22 05:10:16',
			'modifield' => '2013-03-22 05:10:16'
		),
	);

}
