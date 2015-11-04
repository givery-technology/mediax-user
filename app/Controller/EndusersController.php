<?php
App::uses('AppController', 'Controller');
/**
 * Endusers Controller
 *
 * @property Enduser $Enduser
 */
class EndusersController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Enduser->recursive = 0;
		$conds = array();
		$conds['Enduser.parent'] = $this->Session->read('Auth.User.user.id');
		$endusers = $this->Enduser->find('all',array('conditions' => $conds));
		$this->set('endusers', $endusers);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Enduser->id = $id;
		if (!$this->Enduser->exists()) {
			throw new NotFoundException(__('Invalid enduser'));
		}
		$this->set('enduser', $this->Enduser->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Enduser']['keystr'] = implode(',', $this->request->data['Enduser']['keystr']);
			$this->Enduser->create();
			if ($this->Enduser->save($this->request->data)) {
				$this->Session->setFlash(__('The enduser has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The enduser could not be saved. Please, try again.'));
			}
		}
		$users = $this->Enduser->User->find('list');
		$this->set(compact('users'));
		$this->Enduser->User->Keyword->recursive = 0;
		$conds = array();
		$conds['User.id'] = $this->Session->read('Auth.User.user.id');
		$fields = array('Keyword.ID', 'Keyword.Keyword', 'User.id');
		$tmp_keywords = Hash::extract($this->Enduser->User->Keyword->find('all', array('conditions' => $conds, 'fields' => $fields)), '{n}.Keyword');
		$keywords = array();
		for($i = 0; $i<sizeof($tmp_keywords); $i++) {
			$keywords[$tmp_keywords[$i]['ID']] = $tmp_keywords[$i]['Keyword'];
		}
		$this->set(compact('keywords'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Enduser->id = $id;
		if (!$this->Enduser->exists()) {
			throw new NotFoundException(__('Invalid enduser'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['Enduser']['keystr'] = implode(',', $this->request->data['Enduser']['keystr']);
			# Hash user password with md5
			if($this->request->data['Enduser']['pwd'] != '') {
				$this->request->data['Enduser']['pwd'] = md5($this->request->data['Enduser']['pwd']);	
			}else{
				$Enduser = $this->Enduser->read(null, $id);
				$this->request->data['Enduser']['pwd'] = $Enduser['Enduser']['pwd'];
			}
			
			if ($this->Enduser->save($this->request->data)) {
				$this->Session->setFlash(__('The enduser has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The enduser could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Enduser->read(null, $id);
			$this->request->data['Enduser']['keystr'] = explode(',',$this->request->data['Enduser']['keystr']);
		}
		$users = $this->Enduser->User->find('list');
		$this->set(compact('users'));
		$this->Enduser->User->Keyword->recursive = 0;
		$conds = array();
		$conds['User.id'] = $this->Session->read('Auth.User.user.id');
		$fields = array('Keyword.ID', 'Keyword.Keyword', 'User.id');
		$tmp_keywords = Hash::extract($this->Enduser->User->Keyword->find('all', array('conditions' => $conds, 'fields' => $fields)), '{n}.Keyword');
		$keywords = array();
		for($i = 0; $i<sizeof($tmp_keywords); $i++) {
			$keywords[$tmp_keywords[$i]['ID']] = $tmp_keywords[$i]['Keyword'];
		}
		$this->set(compact('keywords'));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Enduser->id = $id;
		if (!$this->Enduser->exists()) {
			throw new NotFoundException(__('Invalid enduser'));
		}
		if ($this->Enduser->delete()) {
			$this->Session->setFlash(__('Enduser deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Enduser was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
