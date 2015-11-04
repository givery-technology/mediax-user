<?php
/**
 * JobhunterFixture
 *
 */
class JobhunterFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'furigana' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'mobile_email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'birthday' => array('type' => 'date', 'null' => true, 'default' => null),
		'gender' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'last_education' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'marriage' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'job_change' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 1),
		'experience' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'certificate' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'certificate_comment' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'income' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'introduce' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'company_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'industry' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'working_period' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'employment_type' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'position' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'woking_content' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'top1_employment_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'top1_job' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'top1_workingplace' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'top1_income' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'top1_characteristic' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'personal_type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created_csv' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_csv' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'register' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'contact' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'postcode' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'prefecture' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'address_no' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'building_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'station' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'time_to_station' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 96, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'memo' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'furigana' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'mobile_email' => 'Lorem ipsum dolor sit amet',
			'birthday' => '2013-03-22',
			'gender' => 1,
			'address' => 'Lorem ipsum dolor sit amet',
			'phone' => 'Lorem ipsum d',
			'last_education' => 'Lorem ipsum dolor sit amet',
			'marriage' => 1,
			'job_change' => 1,
			'experience' => 1,
			'certificate' => 'Lorem ipsum dolor sit amet',
			'certificate_comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'income' => 'Lorem ipsum dolor sit amet',
			'introduce' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'company_name' => 'Lorem ipsum dolor sit amet',
			'industry' => 'Lorem ipsum dolor sit amet',
			'working_period' => 'Lorem ipsum dolor sit amet',
			'employment_type' => 'Lorem ipsum dolor sit amet',
			'position' => 'Lorem ipsum dolor sit amet',
			'woking_content' => 'Lorem ipsum dolor sit amet',
			'top1_employment_type' => 'Lorem ipsum dolor sit amet',
			'top1_job' => 'Lorem ipsum dolor sit amet',
			'top1_workingplace' => 'Lorem ipsum dolor sit amet',
			'top1_income' => 'Lorem ipsum dolor sit amet',
			'top1_characteristic' => 'Lorem ipsum dolor sit amet',
			'personal_type' => 'Lorem ipsum dolor sit amet',
			'created_csv' => '2013-03-22 05:08:36',
			'modified_csv' => '2013-03-22 05:08:36',
			'created' => '2013-03-22 05:08:36',
			'modified' => '2013-03-22 05:08:36',
			'register' => 1,
			'contact' => 'Lorem ipsum dolor sit amet',
			'postcode' => 'Lorem ip',
			'prefecture' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'address_no' => 'Lorem ipsum dolor sit amet',
			'building_name' => 'Lorem ipsum dolor sit amet',
			'station' => 'Lorem ipsum dolor sit amet',
			'time_to_station' => 'Lorem ipsum dolor sit amet',
			'memo' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);

}
