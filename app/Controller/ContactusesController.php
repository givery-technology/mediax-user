<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');
/**
 * Contactuses Controller
 *
 * @property Contactus $Contactus
 */
class ContactusesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Contactus->recursive = 0;
		$this->set('contactuses', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Contactus->id = $id;
		if (!$this->Contactus->exists()) {
			throw new NotFoundException(__('Invalid contactus'));
		}
		$this->set('contactus', $this->Contactus->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Contactus']['userid'] = $this->Auth->user('user.id');
			$this->request->data['Contactus']['date'] = date('Ymd');
			$this->Contactus->create();			
			if ($this->Contactus->save($this->request->data)) {
                
                //send mail
                $email = new CakeEmail('default');
                $email->from(array('sem@givery.co.jp' => '株式会社ギブリー'));
                $email->to(array($this->request->data['Contactus']['parent_email']))
                        ->subject($this->request->data['Contactus']['subject'])
                        ->template('enduser_contactus')
                        ->viewVars(array('contactus' => $this->request->data));
                $email->send();
                
                // auto reply -> Enduser
                $email_reply = new CakeEmail('default');
                $email_reply->from(array($this->request->data['Contactus']['parent_email'] => $this->request->data['Contactus']['agent_company']));
                $email_reply->to(array($this->request->data['Contactus']['email']))
                        ->subject($this->request->data['Contactus']['subject'])
                        ->template('enduser_autoreply')
                        ->viewVars(array('contactus' => $this->request->data));
                $email_reply->send();
                
                $this->Session->setFlash(__('The contactus has been saved'), 'default', array('class' => 'success'));
			} else {
                $this->Session->setFlash(__('The contactus could not be saved. Please, try again.'), 'default', array('class' => 'error'));
			}
		}
		$this->redirect($this->referer());
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Contactus->id = $id;
		if (!$this->Contactus->exists()) {
			throw new NotFoundException(__('Invalid contactus'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contactus->save($this->request->data)) {
				$this->Session->setFlash(__('The contactus has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contactus could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Contactus->read(null, $id);
		}
		$users = $this->Contactus->User->find('list');
		$this->set(compact('users'));
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
		$this->Contactus->id = $id;
		if (!$this->Contactus->exists()) {
			throw new NotFoundException(__('Invalid contactus'));
		}
		if ($this->Contactus->delete()) {
			$this->Session->setFlash(__('Contactus deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Contactus was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
