<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       layout.View.Helper
 */
class LayoutHelper extends Helper {

	public $helpers = array('Html');

	private function _getModel($model = null) {
		return ClassRegistry::init($model);
	}

	/*
	 * compare rank method
	 * <font style='color:red;font-weight:600'>↓</font>
	 * <font style='color:blue;font-weight:600'>↑</font>
	 *
	 * Rank 1->10: blue、 #E4EDF9
	 * Rank 11->20: yellow #FAFAD2
	 * Rank change from blue range to outsite: Alert red #FFBFBF
	 */
	public function compareRank($keyword_id, $rank, $date) {
		$dataRank = array();

		$rankDate = date('Ymd', strtotime(date('Y-m-d', strtotime($date)) . '-1 day'));
		$rankhistory = Cache::read($keyword_id . '_' . $rankDate, 'Rankhistory');

		if (!$rankhistory) {
			$Rankhistory = $this -> _getModel('Rankhistory');
			$rankhistory = $Rankhistory -> find('first', array('fields' => array('Rankhistory.Rank'), 'conditions' => array('Rankhistory.KeyID' => $keyword_id, 'Rankhistory.RankDate' => $rankDate)));
		}

		if (isset($rankhistory['Rankhistory']['Rank']) && strpos($rankhistory['Rankhistory']['Rank'], '/')) {
			$rank_old = explode('/', $rankhistory['Rankhistory']['Rank']);
		} else {
			$rank_old[0] = 0;
			$rank_old[1] = 0;
		}

		if (!empty($rank) && strpos($rank, '/')) {
			$rank_new = explode('/', $rank);
		} else {
			$rank_new[0] = 0;
			$rank_new[1] = 0;
		}

		//arrow
		if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1]) {
			$dataRank['arrow'] = '<span class="red-arrow">↓</span>';
		} else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
			$dataRank['arrow'] = '<span class="blue-arrow">↑</span>';
		} else {
			$dataRank['arrow'] = '';
		}
		//color
		if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
			$dataRank['color'] = 'background:#E4EDF9';
		} else if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
			$dataRank['color'] = 'background:#FAFAD2';
		} else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
			$dataRank['color'] = 'background:#FFBFBF';
		} else {
			$dataRank['color'] = '';
		}
		return $dataRank;
	}

	public function getLogoUser($user_id) {
		$User = $this -> _getModel('User');
		$user = $User -> query('Select logo From user Where id=' . $user_id);
		return $user[0]['user']['logo'];
	}

	public function getEmailUser($user_id) {
		$User = $this -> _getModel('User');
		$user = $User -> query('Select email From user Where id=' . $user_id);
		return $user[0]['user']['email'];
	}

	public function getCompanyUser($user_id) {
		$User = $this -> _getModel('User');
		$company = $User -> query('Select company From user Where id=' . $user_id);
		return $company[0]['user']['company'];
	}
	
	/*
	 * notice label method
	 * 
	 * input: Notice.label
	 * output: notice label html
	 * logic: 
	 * created: 2014-12-24 
	 * author: lecaoquochung@gmail.com
	 */
	public function notice_label($label) {
		$notice_label = Configure::read('NOTICE_LABEL');
		$label_markup = Configure::read('LABEL_MARKUP');
		echo '<span class="status"><span class="label ' .$label_markup[$label] .'">' .$notice_label[$label] .'</span></span>';
	}
	
	/*
	 * compare today method
	 * 
	 * input: $date
	 * output: 1: bigger 0: smaller or equal
	 * logic: return 1 or 0
	 * created: 2014-12-24 
	 * author: lecaoquochung@gmail.com
	 */
	public function compare_today($date) {
		$today = strtotime('today');
		$date = strtotime($date);
		if($date <= $today) {
			return 0;
		} else {
			return 1;
		}
	}

	/*
	 * count history method
	 * 
	 * param: $date
	 * return: number of date compare with today
	 * logic: return 1 or 0
	 * created: 2015-02-02
	 * author: lecaoquochung@gmail.com
	 */
	public function CountDate($date) {
		$today = strtotime('today');
		$date = strtotime($date);
		$history = ($today - $date)/(60*60*24);
		
		return $history;
	}

}
?>