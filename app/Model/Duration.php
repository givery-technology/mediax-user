<?php
App::uses('AppModel', 'Model');
/**
 * Duration Model
 *
 * @property Keyword $Keyword
 */
class Duration extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'ID';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'ID';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Keyword' => array(
			'className' => 'Keyword',
			'foreignKey' => 'KeyID',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
