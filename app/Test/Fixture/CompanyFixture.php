<?php
/**
 * CompanyFixture
 *
 */
class CompanyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'contact' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'furigana' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'working_time' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'welfare_facilities' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'benefit' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dayoff' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'postcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'prefecture' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address_no' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'building_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'billing_destination' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'contact' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'furigana' => 'Lorem ipsum dolor sit amet',
			'working_time' => 'Lorem ipsum dolor sit amet',
			'welfare_facilities' => 'Lorem ipsum dolor sit amet',
			'benefit' => 'Lorem ipsum dolor sit amet',
			'dayoff' => 'Lorem ipsum dolor sit amet',
			'postcode' => 'Lorem ip',
			'prefecture' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'address_no' => 'Lorem ipsum dolor sit amet',
			'building_name' => 'Lorem ipsum dolor sit amet',
			'billing_destination' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-03-22 05:08:54',
			'modifield' => '2013-03-22 05:08:54'
		),
	);

}
