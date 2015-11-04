<?php
App::uses('AppController', 'Controller');
/**
 * Companies Controller
 *
 * @property Company $Company
 */
class CompaniesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function beforeRender() {
        parent::beforeRender();
		if(isset($this->request->data['Company']['password'])){
			unset($this->request->data['Company']['password']);
		}		
		if(isset($this->request->data['Company']['confirm_password'])){
			unset($this->request->data['Company']['confirm_password']);
		}			
    }	
	
/**
 * admin_index method
 *
 * @return void
 */
	public function index() {
		$conds = array();
		if($this->request->is('post') && !empty($this->request->data['Company']['keyword'])){
			$conds['OR']['Company.name LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
			$conds['OR']['Company.contact LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
			$conds['OR']['Company.prefecture LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
			$conds['OR']['Company.city LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
		}
		$this->Company->recursive = 0;
		$this->paginate = array('conditions'=>$conds, 'order' => array('created' => 'desc'));
		$this->set('companies', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		$this->set('company', $this->Company->read(null, $id));
	}
	
/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Company->exists($id)) {
			throw new NotFoundException(__('Invalid company'));
		}
		$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
		$this->set('company', $this->Company->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->request->data['Company']['user_id'] = $this->Auth->user('id');
			$this->Company->create();
			if ($this->Company->save($this->request->data)) {
				$this->Session->setFlash(__('The company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'));
			}
		}
		$users = $this->Company->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Company->save($this->request->data)) {
				$this->Session->setFlash(__('The company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Company->read(null, $id);
		}
		$users = $this->Company->User->find('list');
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
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		if ($this->Company->delete()) {
			$this->Session->setFlash(__('Company deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Company was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$conds = array();
		if($this->request->is('post') && !empty($this->request->data['Company']['keyword'])){
			$conds['OR']['Company.name LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
			$conds['OR']['Company.contact LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
			$conds['OR']['Company.prefecture LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
			$conds['OR']['Company.city LIKE'] = '%'.mb_strtolower(trim($this->request->data['Company']['keyword']),'UTF-8').'%';
		}	
		$this->Company->recursive = 0;
		$this->paginate = array('conditions'=>$conds, 'order' => array('created' => 'desc'));
		$this->set('companies', $this->paginate());
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->request->data['Company']['user_id'] = $this->Auth->user('id');
			$this->Company->create();
			if ($this->Company->save($this->request->data)) {
				$this->Session->setFlash(__('The company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'));
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
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Company->save($this->request->data)) {
				$this->Session->setFlash(__('The company has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The company could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Company->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			throw new NotFoundException(__('Invalid company'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Company->delete()) {
			$this->Session->setFlash(__('Company deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Company was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_fileupload method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */	
	public function admin_fileupload() {
		$this->loadModel('File');
		if($this->request->is('post')){
			$this->request->data['File']['mark'] = 2;
			$this->request->data['File']['user_id'] = $this->Auth->user('id');
			$result = $this->Upload->uploadFile(Configure::read('FOLDER_UPLOAD_CSV'),$this->request->data['Upload']['filename']);
			if(array_key_exists('name', $result)){
				$this->request->data['File']['filename'] = $result['name'];
			}else{
				$this->request->data['File']['filename'] = '';
			}			
			$this->File->create();
			if($this->File->save($this->request->data)){
				if(!empty($this->request->data['File']['filename'])){
					$records_count = $this->Company->find( 'count' );
					try {
						$company['Company']['user_id'] = $this->Auth->user('id');
						$this->Company->importCSV(Configure::read('FOLDER_UPLOAD_CSV').'/'.$this->request->data['File']['filename'],$company);
					} catch (Exception $e) {
						$import_errors = $this->Company->getImportErrors();
					}
					$new_records_count = $this->Company->find( 'count' ) - $records_count;				
				}			
			}			
		}		
		$uploads = $this->File->find('all',array('conditions'=>array('File.user_id'=>$this->Auth->user('id'), 'File.mark'=>2,)));
		$this->set(compact('uploads'));
	}
	
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * user_fileupload method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */	
	public function fileupload() {
		$this->loadModel('File');
		if($this->request->is('post')){
			$this->request->data['File']['mark'] = 2;
			$this->request->data['File']['user_id'] = $this->Auth->user('id');
			$result = $this->Upload->uploadFile(Configure::read('FOLDER_UPLOAD_CSV'),$this->request->data['Upload']['filename']);
			if(array_key_exists('name', $result)){
				$this->request->data['File']['filename'] = $result['name'];
			}else{
				$this->request->data['File']['filename'] = '';
			}			
			$this->File->create();
			if($this->File->save($this->request->data)){
				if(!empty($this->request->data['File']['filename'])){
					$records_count = $this->Company->find( 'count' );
					try {
						$company['Company']['user_id'] = $this->Auth->user('id');
						$this->Company->importCSV(Configure::read('FOLDER_UPLOAD_CSV').'/'.$this->request->data['File']['filename'],$company);
					} catch (Exception $e) {
						$import_errors = $this->Company->getImportErrors();
					}
					$new_records_count = $this->Company->find( 'count' ) - $records_count;				
				}			
			}			
		}		
		$uploads = $this->File->find('all',array('conditions'=>array('File.user_id'=>$this->Auth->user('id'), 'File.mark'=>2,)));
		$this->set(compact('uploads'));
	}
}