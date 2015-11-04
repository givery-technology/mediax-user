<?php
App::uses('AppModel', 'Model');
/**
 * Company Model
 *
 * @property Joboffer $Joboffer
 */
class Company extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	public $actsAs = array(
		'CsvImport' => array(
			'delimiter'  => ',',
			'hasHeader'=>false,
			'mapHeader'=> 'HEADER_CSV_COMPANY'//Configure::read('HEADER_CSV_COMPANY')
		)
	);
	
    /*public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'unique' => array(
				'rule' => 'isUnique'
			)
		),
        'email' => array(
			'email'=>array(
				'rule'    => 'email',
				'message' => 'Email is not correct.'			
			),
			'unique' => array(
				'rule' => 'isUnique'
			)
        )
    );*/	
	
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Joboffer' => array(
			'className' => 'Joboffer',
			'foreignKey' => 'company_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeImport($data){
		return $data;
	}
	
	public function afterImport($data){
		$this->deleteAll(array($this->alias.'.name'=>''));
		return $data;
	}	
	
}
