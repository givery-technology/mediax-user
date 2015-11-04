<?php
App::uses('AppController', 'Controller');
/**
 * Extras Controller
 *
 * @property Extra $Extra
 */
class ExtrasController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Extra->recursive = 0;
		$this->set('extras', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Extra->id = $id;
		if (!$this->Extra->exists()) {
			throw new NotFoundException(__('Invalid extra'));
		}
		$this->set('extra', $this->Extra->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($keyID) {
		if ($this->request->is('post')) {
			$this->Extra->create();
			if ($this->Extra->save($this->request->data)) {
				$this->Session->setFlash(__('The extra has been saved'));
			} else {
				$this->Session->setFlash(__('The extra could not be saved. Please, try again.'));
			}
		}
		$keyword = $this->Extra->Keyword->find('first',array(
                    'fields'=>array('Keyword.ID','Keyword.Extra'),
                    'conditions'=>array('Keyword.ID'=>$keyID),
                    'Contain'=>array(
                        'Extra'=>array('fields'=>array('Extra.ID','Extra.ExtraType','Extra.Price'))
                    )
                ));
		$this->set(compact('keyword'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Extra->id = $id;
		if (!$this->Extra->exists()) {
			throw new NotFoundException(__('Invalid extra'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Extra->save($this->request->data)) {
				$this->Session->setFlash(__('The extra has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The extra could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Extra->read(null, $id);
		}
		$keywords = $this->Extra->Keyword->find('list');
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
                $this->autoRender = false;
                Configure::write('debug', 0);
                $message = array();
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Extra->id = $id;
		if (!$this->Extra->exists()) {
			throw new NotFoundException(__('Invalid extra'));
		}
		if ($this->Extra->delete()) {
                        $message['msg'] = __('Extra deleted');
                        $message['error'] = 0;
			return json_encode($message);
		}
                $message['msg'] = __('Extra was not deleted');
                $message['error'] = 1;
                return json_encode($message);                
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Extra->recursive = 0;
		$this->set('extras', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Extra->id = $id;
		if (!$this->Extra->exists()) {
			throw new NotFoundException(__('Invalid extra'));
		}
		$this->set('extra', $this->Extra->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Extra->create();
			if ($this->Extra->save($this->request->data)) {
				$this->Session->setFlash(__('The extra has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The extra could not be saved. Please, try again.'));
			}
		}
		$keywords = $this->Extra->Keyword->find('list');
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
		$this->Extra->id = $id;
		if (!$this->Extra->exists()) {
			throw new NotFoundException(__('Invalid extra'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Extra->save($this->request->data)) {
				$this->Session->setFlash(__('The extra has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The extra could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Extra->read(null, $id);
		}
		$keywords = $this->Extra->Keyword->find('list');
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
		$this->Extra->id = $id;
		if (!$this->Extra->exists()) {
			throw new NotFoundException(__('Invalid extra'));
		}
		if ($this->Extra->delete()) {
			$this->Session->setFlash(__('Extra deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Extra was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
