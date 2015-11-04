<?php
App::uses('AppModel', 'Model');
/**
 * Enduser Model
 *
 * @property User $User
 */
class Enduser extends AppModel {

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


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'parent',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
