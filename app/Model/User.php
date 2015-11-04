<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Keyword $Keyword
 */
class User extends AppModel {

        public $actsAs = array('Containable');
/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'enduser';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'pwd' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'on' => 'create'
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => 'isUnique'
			),			
		),
		'company' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
	);

}
