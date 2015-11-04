<?php

App::uses('AppController', 'Controller');

/**
 * Rankhistories Controller
 *
 * @property Rankhistory $Rankhistory
 */
class RankhistoriesController extends AppController {

	/**
	 * client index method
	 * show only contract keyword
	 * @return void
	 */
	public function client_index($show_all = 'false', $status = 0) {
		$this -> Rankhistory -> recursive = 2;

		$this -> loadModel('User');
		$user = $this -> User -> find('first', array('conditions' => array('User.id' => $this -> Session -> read('Auth.User.user.id'))));
		$keys = explode(',', $user['User']['keystr']);

		$conds = array();
		$conds['Rankhistory.rankDate ='] = date('Ymd');
		$conds['Rankhistory.KeyID'] = $keys;
		$conds['Keyword.Enabled'] = 1;
		$conds['Keyword.nocontract'] = 0;

		$fields = array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params', 'Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url');
		$rankhistories = $this -> Rankhistory -> find('all', array('conditions' => $conds, 'fields' => $fields, 'order' => 'Rankhistory.updated DESC'));
		$this -> set('rankhistories', $rankhistories);
		
		// notice
		$this->loadModel('Notice');
		$conds_notice = array();
		$conds_notice['Notice.history <='] = date('Y-m-d');
		$notices = $this -> Notice -> find('all', array('conditions' => $conds_notice, 'order' => 'Notice.created DESC', 'limit' => Configure::read('NOTICE_NUMBER')));
		$search = 1;
		$this->set('notices', $notices);
		$this->set('search', $search);
	}

	/**
	 * client keyword method
	 * show only contract keyword
	 * @return void
	 */
	public function client_keyword() {

		$this -> loadModel('User');
		$user = $this -> User -> find('first', array('conditions' => array('User.id' => $this -> Session -> read('Auth.User.user.id'))));
		$keys = explode(',', $user['User']['keystr']);

		$conds = array();
		$conds['Keyword.ID'] = $keys;

		$this -> Rankhistory -> Keyword -> recursive = 2;
		$this -> Rankhistory -> Keyword -> Behaviors -> load('Containable');
		$rankhistory = $this -> Rankhistory -> Keyword -> find('all', array('conditions' => $conds, 'fields' => array('Keyword.ID', 'Keyword.UserID', 'Keyword.Keyword', 'Keyword.Engine', 'Keyword.rankend', 'Keyword.Enabled', 'Keyword.nocontract', 'Keyword.Penalty', 'Keyword.Url'), 'contain' => array('Rankhistory' => array('fields' => array('Rankhistory.ID', 'Rankhistory.Url', 'Rankhistory.Rank', 'Rankhistory.RankDate', 'Rankhistory.params'), 'conditions' => array('Rankhistory.rankDate' => date('Ymd')), 'order' => 'Rankhistory.updated DESC'), 'Duration', 'Extra')));
		$this -> set('rankhistories', $rankhistory);
	}

	/**
	 * CSV method - csv by keyword
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function csv_by_keyword($keyID = null, $date = null) {
		$this -> Rankhistory -> Keyword -> recursive = 2;
		$fields = array();
		$fields = array('Keyword.id', 'Keyword.Keyword', 'Keyword.Url', 'User.company');
		$keyword = $this -> Rankhistory -> Keyword -> find('first', array('conditions' => array('Keyword.ID' => $keyID), 'fields' => $fields));
		// $keyword['Keyword']['Keyword']

		$limit = 30;
		$conds = array();
		$conds['Rankhistory.KeyID'] = $keyID;
		if (!empty($date)) {
			$conds['DATE_FORMAT(Rankhistory.RankDate,"%Y-%m")'] = date('Y-m', strtotime($date));
			$limit = null;
		}

		$this -> export(array('conditions' => $conds, 'fields' => array('Rankhistory.RankDate', 'Rankhistory.Rank'), 'order' => array('Rankhistory.RankDate' => 'desc'), 'limit' => $limit, 'mapHeader' => 'HEADER_CSV_VIEW_KEYWORD', 'insertHeader' => array($keyword['Keyword']['Keyword'], $keyword['User']['company'], $keyword['Keyword']['Url']), 'filename' => $keyword['Keyword']['Keyword'], 'callbackHeader' => 'header_csv_by_keyword', 'callbackRow' => 'row_csv_by_keyword', ));
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		$this -> set('rankhistory', $this -> Rankhistory -> read(null, $id));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this -> request -> is('post')) {
			$this -> Rankhistory -> create();
			if ($this -> Rankhistory -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The rankhistory has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The rankhistory could not be saved. Please, try again.'));
			}
		}
		$keywords = $this -> Rankhistory -> Keyword -> find('list');
		$this -> set(compact('keywords'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$this -> Rankhistory -> id = $id;
		if (!$this -> Rankhistory -> exists()) {
			throw new NotFoundException(__('Invalid rankhistory'));
		}
		if ($this -> request -> is('post') || $this -> request -> is('put')) {
			if ($this -> Rankhistory -> save($this -> request -> data)) {
				$this -> Session -> setFlash(__('The rankhistory has been saved'));
				$this -> redirect(array('action' => 'index'));
			} else {
				$this -> Session -> setFlash(__('The rankhistory could not be saved. Please, try again.'));
			}
		} else {
			$this -> request -> data = $this -> Rankhistory -> read(null, $id);
		}
		$keywords = $this -> Rankhistory -> Keyword -> find('list');
		$this -> set(compact('keywords'));
	}

	/**
	 *	Color Row method
	 * 	Rank 1->10: blue、 #E4EDF9
	 *  	Rank 11->20: yellow #FAFAD2
	 * 	Rank change from blue range to outsite: Alert red #FFBFBF
	 */
	public function color_row() {
		$this -> autoRender = false;
		Configure::write('debug', 0);

		$rankDate = date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day'));

		$rankhistory = Cache::read($this -> request -> data['keyID'] . '_' . $rankDate, 'Rankhistory');

		if (!$rankhistory) {
			$rankhistory = $this -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $this -> request -> data['keyID'], 'Rankhistory.RankDate' => $rankDate)));
			Cache::write($this -> request -> data['keyID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
		}

		if (isset($rankhistory['Rankhistory']['Rank']) && strpos($rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($this -> request -> data['rank']) && strpos($this -> request -> data['rank'], '/')) {
			$rank_new = explode('/', $this -> request -> data['rank']);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
			return '#E4EDF9';
		}

		if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
			return '#FAFAD2';
		}

		if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
			return '#FFBFBF';
		}
	}

	/*
	 * Arrow Row method
	 * <font style='color:red;font-weight:600'>↓</font>
	 * <font style='color:blue;font-weight:600'>↑</font>
	 */
	public function arrow_row() {
		$this -> autoRender = false;
		Configure::write('debug', 0);
		$rankhistory = $this -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $this -> request -> data['keyID'], 'Rankhistory.RankDate' => date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day')))));

		if (isset($rankhistory['Rankhistory']['Rank']) && strpos($rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($this -> request -> data['rank']) && strpos($this -> request -> data['rank'], '/')) {
			$rank_new = explode('/', $this -> request -> data['rank']);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1]) {
			return '<span class="red-arrow">↓</span>';
		} else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
			return '<span class="blue-arrow">↑</span>';
		}
	}

	/*
	 * Arrow Row method
	 * <font style='color:red;font-weight:600'>↓</font>
	 * <font style='color:blue;font-weight:600'>↑</font>
	 *
	 * Rank 1->10: blue、 #E4EDF9
	 * Rank 11->20: yellow #FAFAD2
	 * Rank change from blue range to outsite: Alert red #FFBFBF
	 */

	public function compare_rank() {
		$this -> autoRender = false;
		Configure::write('debug', 0);

		$message = array();
		$rankDate = date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day'));
		$rankhistory = Cache::read($this -> request -> data['keyID'] . '_' . $rankDate, 'Rankhistory');
		if (!$rankhistory) {
			$rankhistory = $this -> Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $this -> request -> data['keyID'], 'Rankhistory.RankDate' => date('Ymd', strtotime(date('Y-m-d', strtotime($this -> request -> data['rankDate'])) . '-1 day')))));
			Cache::write($this -> request -> data['keyID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
		}
		if (isset($rankhistory['Rankhistory']['Rank']) && strpos($rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($this -> request -> data['rank']) && strpos($this -> request -> data['rank'], '/')) {
			$rank_new = explode('/', $this -> request -> data['rank']);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		//color
		if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
			$message['color'] = '#E4EDF9';
		} else if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
			$message['color'] = '#FAFAD2';
		} else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
			$message['color'] = '#FFBFBF';
		} else {
			$message['color'] = '';
		}

		//arrow
		if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1]) {
			$message['arrow'] = '<span class="red-arrow">↓</span>';
		} else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
			$message['arrow'] = '<span class="blue-arrow">↑</span>';
		} else {
			$message['arrow'] = '';
		}

		return json_encode($message);
	}

}
