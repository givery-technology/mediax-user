<?php
App::uses('AppController', 'Controller');
/**
 * Rankkeywords Controller
 *
 * @property Rankkeyword $Rankkeyword
 */
class RankkeywordsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Rankkeyword->recursive = 0;
		$this->set('rankkeywords', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Rankkeyword->id = $id;
		if (!$this->Rankkeyword->exists()) {
			throw new NotFoundException(__('Invalid rankkeyword'));
		}
		$this->set('rankkeyword', $this->Rankkeyword->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Rankkeyword->create();
			if ($this->Rankkeyword->save($this->request->data)) {
				$this->Session->setFlash(__('The rankkeyword has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rankkeyword could not be saved. Please, try again.'));
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
		$this->Rankkeyword->id = $id;
		if (!$this->Rankkeyword->exists()) {
			throw new NotFoundException(__('Invalid rankkeyword'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rankkeyword->save($this->request->data)) {
				$this->Session->setFlash(__('The rankkeyword has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rankkeyword could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Rankkeyword->read(null, $id);
		}
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
		$this->Rankkeyword->id = $id;
		if (!$this->Rankkeyword->exists()) {
			throw new NotFoundException(__('Invalid rankkeyword'));
		}
		if ($this->Rankkeyword->delete()) {
			$this->Session->setFlash(__('Rankkeyword deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rankkeyword was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Rankkeyword->recursive = 0;
		$this->set('rankkeywords', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Rankkeyword->id = $id;
		if (!$this->Rankkeyword->exists()) {
			throw new NotFoundException(__('Invalid rankkeyword'));
		}
		$this->set('rankkeyword', $this->Rankkeyword->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Rankkeyword->create();
			if ($this->Rankkeyword->save($this->request->data)) {
				$this->Session->setFlash(__('The rankkeyword has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rankkeyword could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Rankkeyword->id = $id;
		if (!$this->Rankkeyword->exists()) {
			throw new NotFoundException(__('Invalid rankkeyword'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rankkeyword->save($this->request->data)) {
				$this->Session->setFlash(__('The rankkeyword has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rankkeyword could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Rankkeyword->read(null, $id);
		}
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
		$this->Rankkeyword->id = $id;
		if (!$this->Rankkeyword->exists()) {
			throw new NotFoundException(__('Invalid rankkeyword'));
		}
		if ($this->Rankkeyword->delete()) {
			$this->Session->setFlash(__('Rankkeyword deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rankkeyword was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
