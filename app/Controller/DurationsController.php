<?php
App::uses('AppController', 'Controller');
/**
 * Durations Controller
 *
 * @property Duration $Duration
 */
class DurationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Duration->recursive = 0;
		$this->set('durations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Duration->id = $id;
		if (!$this->Duration->exists()) {
			throw new NotFoundException(__('Invalid duration'));
		}
		$this->set('duration', $this->Duration->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Duration->create();
			if ($this->Duration->save($this->request->data)) {
				$this->Session->setFlash(__('The duration has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The duration could not be saved. Please, try again.'));
			}
		}
		$keywords = $this->Duration->Keyword->find('list');
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
		$this->Duration->id = $id;
		if (!$this->Duration->exists()) {
			throw new NotFoundException(__('Invalid duration'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Duration->save($this->request->data)) {
				$this->Session->setFlash(__('The duration has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The duration could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Duration->read(null, $id);
		}
		$keywords = $this->Duration->Keyword->find('list');
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
		$this->Duration->id = $id;
		if (!$this->Duration->exists()) {
			throw new NotFoundException(__('Invalid duration'));
		}
		if ($this->Duration->delete()) {
			$this->Session->setFlash(__('Duration deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Duration was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Duration->recursive = 0;
		$this->set('durations', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Duration->id = $id;
		if (!$this->Duration->exists()) {
			throw new NotFoundException(__('Invalid duration'));
		}
		$this->set('duration', $this->Duration->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Duration->create();
			if ($this->Duration->save($this->request->data)) {
				$this->Session->setFlash(__('The duration has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The duration could not be saved. Please, try again.'));
			}
		}
		$keywords = $this->Duration->Keyword->find('list');
		$this->set(compact('keywords'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Duration->id = $id;
		if (!$this->Duration->exists()) {
			throw new NotFoundException(__('Invalid duration'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Duration->save($this->request->data)) {
				$this->Session->setFlash(__('The duration has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The duration could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Duration->read(null, $id);
		}
		$keywords = $this->Duration->Keyword->find('list');
		$this->set(compact('keywords'));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Duration->id = $id;
		if (!$this->Duration->exists()) {
			throw new NotFoundException(__('Invalid duration'));
		}
		if ($this->Duration->delete()) {
			$this->Session->setFlash(__('Duration deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Duration was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
