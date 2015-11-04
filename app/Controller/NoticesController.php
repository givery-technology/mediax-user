<?php
App::uses('AppController', 'Controller');
/**
 * Notices Controller
 *
 * @property Notice $Notice
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NoticesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Notice->recursive = 0;
		$conds_notice = array();
		$conds_notice['Notice.history <='] = date('Y-m-d');
		$this -> Paginator -> settings = array('conditions' => $conds_notice, 'limit' => 20, 'order' => array('created' => 'DESC'));
		$this->set('notices', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Notice->exists($id)) {
			throw new NotFoundException(__('Invalid notice'));
		}
		$options = array('conditions' => array('Notice.' . $this->Notice->primaryKey => $id));
		$this->set('notice', $this->Notice->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Notice->create();
			if ($this->Notice->save($this->request->data)) {
				$this->Session->setFlash(__('The notice has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notice could not be saved. Please, try again.'));
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
		if (!$this->Notice->exists($id)) {
			throw new NotFoundException(__('Invalid notice'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Notice->save($this->request->data)) {
				$this->Session->setFlash(__('The notice has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notice could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Notice.' . $this->Notice->primaryKey => $id));
			$this->request->data = $this->Notice->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Notice->id = $id;
		if (!$this->Notice->exists()) {
			throw new NotFoundException(__('Invalid notice'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Notice->delete()) {
			$this->Session->setFlash(__('The notice has been deleted.'));
		} else {
			$this->Session->setFlash(__('The notice could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
