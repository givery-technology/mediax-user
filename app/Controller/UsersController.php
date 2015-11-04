<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$conds = array();
		$fields = array();
		
		$this->set('users', $this->User->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'User.id DESC')));
	}
	
/**
 * agent index method
 *
 * @return void
 */
	public function agent_index() {
		$this->User->recursive = 0;
		$conds = array();
		$conds['User.agent'] = 1;
		$fields = array();
		
		$this->set('users', $this->User->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'User.id DESC')));
	}

/**
 * agent edit method
 *
 * @return void
 */
	public function agent_edit() {
		$this->User->id = $this->Session->read('Auth.User.user.id');
		$id = $this->User->id;
		
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			$logo = $this->Upload->uploadImage('uploads/logo',$this->request->data['User']['logo']);
			if (array_key_exists('name', $logo)) {
				$this->request->data['User']['logo'] = $logo['name'];
			}else{
				unset($this->request->data['User']['logo']);
			}
			# Hash user password with md5
			if($this->request->data['User']['pwd'] != '') {
				$this->request->data['User']['pwd'] = md5($this->request->data['User']['pwd']);	
			}else{
				$User = $this->User->read(null, $id);
				$this->request->data['User']['pwd'] = $User['User']['pwd'];
			}
			
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The company has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'agent_edit',$id));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}
	
/**
 * client inquiry method
 *
 * @return void
 */
	public function client_inquiry() {
		$this->User->recursive = 0;
		$conds = array();
		$conds['User.agent'] = 1;
		$fields = array();
		
		$this->set('users', $this->User->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'User.id DESC')));
	}
	
/**
 * agent method
 *
 * @return void
 */
	public function agent() {
		$this->User->recursive = 0;
		$conds = array();
		$fields = array();
		
		$conds['User.agent'] = 1;
		
		$this->set('users', $this->User->find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'User.id DESC')));
	}
	
/**
 * agent set method
 *
 * @return void
 */
	public function agent_set($id = NULL) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->data['User']['agent'] = 1;
		
		if ($this->User->save($this->request->data)) {
			$this->Session->setFlash(__('The agent setting has been saved'), 'default', array('class' => 'success'));
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash(__('The agent setting could not be saved. Please, try again.'), 'default', array('class' => 'error'));
		}
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {               
        set_time_limit(0);
		$this->User->recursive = 2;
		$this->User->id = $id;
		
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		
        $user = $this->User->find('first',array(
            'fields'=>array('User.company', 'User.email', 'User.name', 'User.tel', 'User.fax', 'User.agent'),
            'conditions'=>array('User.id'=>$id),
            'contain'=>array(
                'Keyword'=>array(
                    'fields'=>array('Keyword.ID','Keyword.Keyword as keyword','Keyword.Url','Keyword.rankstart','Keyword.nocontract','Keyword.rankend'),
					'Duration' => array(
						'conditions'=>array('Duration.Flag'=>1),
						'fields' => array('Duration.ID','Duration.KeyID','Duration.StartDate','Duration.EndDate','Duration.Flag')
					)
                )
            )
		));
		
		$this->set('user', $user);
		
        $conds = array();
        $conds['Rankhistory.RankDate'] = date('Ymd');
        if($this->request->is('post')){
			$conds['Rankhistory.RankDate'] = implode('',$this->request->data['Rankhistory']['rankDate']);
        }                
        
        $rankhistory = $this->User->Keyword->Rankhistory->find('list',array(
            'fields'=>array('Rankhistory.KeyID','Rankhistory.Rank'),
            'conditions'=>$conds
        ));
        $this->set('rankhistory', $rankhistory);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
            if($this->request->data['User']['pwd'] != '') {
                $this->request->data['User']['pwd'] = md5($this->request->data['User']['pwd']); 
            }
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if($this->request->data['User']['pwd'] != '') {
				$this->request->data['User']['pwd'] = md5($this->request->data['User']['pwd']);	
			} 
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The company has been saved'), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'view',$id));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['pwd']);
		}
	}

/**
* login method
*
* @return void
*/	
	public function login() {
		if ($this->Session->read('Auth.User')) {
			$this->Session->setFlash(__('You are logged in!'), 'default', array('class' => 'error'));
			return $this->redirect($this->Auth->redirectUrl());
		}
		
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
	}
	
/**
* autologin method
*
* @return void
*/
	public function autologin($email = null, $pwd = null) {
        if ($this->request->is('get')) {
            if ($this->Auth->login()) {
                return $this->redirect(array('controller'=>'rankhistories','action'=>'client_index'));
            }
        }
	}

/**
* logout method
*
* @return void
*/		
	public function logout() {
	    $this->Session->destroy();
		$this->Cookie->delete('auto_login_mediax_enduser.user');
		$this->redirect($this->Auth->logout());
	}	
	
}