<?php
App::uses('AppModel', 'Model');
/**
 * Slog Model
 *
 * @property Status $Status
 * @property Jobhunter $Jobhunter
 */
class Slog extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Jobhunter' => array(
			'className' => 'Jobhunter',
			'foreignKey' => 'jobhunter_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
