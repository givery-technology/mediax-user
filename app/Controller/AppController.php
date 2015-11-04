<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		'Auth' => array(
			'authError' => 'Did you really think you are allowed to see that?'
		),
		'Session',
		'Cookie',
		'Upload',
		'Email',
		'RequestHandler',
		'Password',
		'Rank',
        'RankMobile'
	);
	
	public $helpers = array('Session','Form','Html','Js'/*,'Fck','Layout','Text','Encode'*/);
	
	public $paginate = array('limit' => 20, 'order' => array('modified' => 'desc'));
	
	public $key = 'givery.media.sem-check.enduser';
	
	public function beforeFilter() {
        $this->_auto_login();
        parent::beforeFilter();		
     	$this->_setupAuth();
		$this->_setupLayout();
		$this->Cookie->key = $this->key;		
    }

	public function beforeRender() {
       	parent::beforeRender();
		if(isset($this->request->data['User']['password'])){
			unset($this->request->data['User']['password']);
		}
		if(isset($this->request->data['User']['pwd'])){
			unset($this->request->data['User']['pwd']);
		}
		if(isset($this->request->data['Enduser']['pwd'])){
			unset($this->request->data['Enduser']['pwd']);
		}
	}
	
	public function _setupAuth() {
       if(!$this->Auth->user()){
                $this->Auth->loginAction = array('admin'=>false,'controller' => 'users','action' => 'login');
                $this->Auth->authenticate = array(
                        'Form' => array('fields' => array('username' => 'email', 'password' => 'pwd'))
                );     
                AuthComponent::$sessionKey = 'Auth.User.user';
        }else{
               $this->Auth->allow('*');
       }
    }
	
	public function _auto_login(){
		if (isset($this->passedArgs['email']) && isset($this->passedArgs['pass']) && $this->request->action=='autologin') {
			$user = $this->User->find('first',array('conditions'=>array('User.email'=>base64_decode($this->passedArgs['email']),'User.pwd'=>$this->passedArgs['pass'])));
			$user = array_change_key_case($user);
			if($user){
				$this->Auth->login($user);
			}
		}		
	}
	
	public function _setupLayout(){

	}
	
	public function isAuthorized($user = null) {
        return true;
    }
	
	# CSV download filename
	public function export($options = null) {
        $this->autoRender = false;
        $modelClass = $this->modelClass;
        $this->response->type('Content-Type: text/csv');
        if(isset($options['filename'])){
            $this->response->download(date('Y-m-d_H-i-s').'_'.strtolower($options['filename']) . '.csv');
            unset($options['filename']);
        }else{
            $this->response->download(date('Y-m-d_H-i-s').'_'.strtolower(Inflector::pluralize($modelClass)) . '.csv');
        }				
        
        $this->response->body($this->$modelClass->exportCSV($options));
    }
    
    public function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400); #24*60*60
    }    
    
    public function forDate($begin, $end, $interval){
        $data_date = array();
        do {
            $data_date[] = $begin;
            $begin = date('Y-m-d',strtotime($begin.' +'.$interval.' day'));
        } while (strtotime($begin)<=strtotime($end));
		$data_date[] = $end;
		
        return $data_date;
    }
}
