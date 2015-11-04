<?php
App::uses('AppShell', 'Console/Command');
App::uses('ComponentCollection', 'Controller');
App::uses('RankComponent','Controller/Component');
App::uses('RankMobileComponent','Controller/Component');

class LoadAllRankShell extends Shell {

    public $uses = array('Keyword');

    public function main() {
        set_time_limit(0);
        
		//load component
        $component = new ComponentCollection();
        App::import('Component','Rank');
        $this->Rank = new RankComponent($component);        
        $component1 = new ComponentCollection();
        App::import('Component','RankMobile');
        $this->RankMobile = new RankMobileComponent($component1);
        
        //extra save cache list
        /*$extras = Cache::read('Extra_KeyID', 'Extra');
        if(!$extras){
            $extras = $this->Keyword->Extra->find('all',array('fields'=>array('DISTINCT (Extra.KeyID) AS KeyID')));
            $extras = Hash::extract($extras, '{n}.Extra.KeyID');
            Cache::write('Extra_KeyID', $extras, 'Extra');
        }*/
        
        $this->Keyword->recursive = -1;
		
        // Filter keyword
        $conds = array();
        $conds['Keyword.Enabled'] = 1;
        $conds['Keyword.nocontract'] = 0;
#Note: 先に解約済のきーワードは解約日まで順位チェックしない
        #$conds['Keyword.rankend'] = 0;
		#$conds['Keyword.rankend >='] = date('Ymd');
		$conds['OR'] = array(
	        array('Keyword.rankend' => 0),
	        array('Keyword.rankend >=' => date('Ymd'))
	    );
		
        $keywords = $this->Keyword->find('all', array('conditions' => $conds));        
		
        foreach ($keywords as $keyword) {
			#sleep(3);
            /*$savecache=false;
            if(in_array($keyword['Keyword']["ID"],$extras)){
                $savecache=true;                   
            }*/                        
            
			sleep(2);
            if ($keyword != false) {
                if ($keyword['Keyword']['Strict'] == 1) {
                    $domain = $this->Rank->remainUrl($keyword['Keyword']['Url']);
                } else {
                    $domain = $this->Rank->remainDomain($keyword['Keyword']['Url']);
                }
            }
			
            $engine = $keyword['Keyword']['Engine'];
			
            /*if ($engine == 3) {
                $rank = $this->Rank->keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword']) . '/' . $this->Rank->keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 6 || $engine == 12) {
                $rank = $this->Rank->keyWordRank('google_en', $domain, $keyword['Keyword']['Keyword']) . '/' . $this->Rank->keyWordRank('yahoo_en', $domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 7) {//mobile search engine
                $rank = $this->RankMobile->keywordRankYahooMobile($domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 8) {
                $rank = $this->RankMobile->keywordRankGoogleMobile($domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 9 || $engine == 11){
                $rank = $this->RankMobile->keywordRankGoogleMobile($domain, $keyword['Keyword']['Keyword']).'/'.$this->RankMobile->keywordRankYahooMobile($domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 10) {
                $keyword['Keyword']["onlytop10"] = isset($keyword['Keyword']["onlytop10"])?$keyword['Keyword']["onlytop10"]:false;
                $rank = $this->Rank->keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword'],$savecache,$keyword['Keyword']["onlytop10"]).'/'.$this->Rank->keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword'],$savecache,$keyword['Keyword']["onlytop10"]);                
            }else {//end
                $engine_list = $this->Rank->getEngineList();
                $rank = $this->Rank->keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword']);
            }*/
			if ($engine == 3) {
                $rank = $this->Rank->keyWordRank('google_jp', $domain, $keyword['Keyword']['Keyword']) . '/' . $this->Rank->keyWordRank('yahoo_jp', $domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 6) {
                $rank = $this->Rank->keyWordRank('google_en', $domain, $keyword['Keyword']['Keyword']) . '/' . $this->Rank->keyWordRank('yahoo_en', $domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 7) {//mobile search engine
                $rank = $this->RankMobile->keywordRankYahooMobile($domain, $keyword['Keyword']['Keyword']);
            } elseif ($engine == 8) {
                $rank = $this->RankMobile->keywordRankGoogleMobile($domain, $keyword['Keyword']['Keyword']);
            } else {//end
                $engine_list = $this->Rank->getEngineList();
                $rank = $this->Rank->keyWordRank($engine_list[$engine]['Name'], $domain, $keyword['Keyword']['Keyword']);
            }
			
            //delete Rankhistory current date
            $this->Keyword->Rankhistory->deleteAll(array('Rankhistory.KeyID' => $keyword['Keyword']['ID'], 'Rankhistory.RankDate' => date('Ymd')));
            
			//Insert Rankhistory current date
            $rankhistory['Rankhistory']['KeyID'] = $keyword['Keyword']['ID'];
            $rankhistory['Rankhistory']['Url'] = $domain;
            $rankhistory['Rankhistory']['Rank'] = $rank;
            $rankhistory['Rankhistory']['RankDate'] = date('Ymd');
           
		    //check color and arrow
            $check_params = array();
            $rankDate = date('Ymd', strtotime(date('Y-m-d') . '-1 day'));
            $data_rankhistory = Cache::read($keyword['Keyword']['ID'] . '_' . $rankDate, 'Rankhistory');
			
            if (!$data_rankhistory) {
                $data_rankhistory = $this->Keyword->Rankhistory->find('first', array(
                    'fields' => array('Rankhistory.Rank'),
                    'conditions' => array(
                        'Rankhistory.KeyID' => $keyword['Keyword']['ID'],
                        'Rankhistory.RankDate' => $rankDate
                )));
                Cache::write($keyword['Keyword']['ID'] . '_' . $rankDate, $rankhistory, 'Rankhistory');
            }
			
            if (isset($data_rankhistory['Rankhistory']['Rank']) && strpos($data_rankhistory['Rankhistory']['Rank'], '/')) {
                $rank_old = explode('/', $data_rankhistory['Rankhistory']['Rank']);
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
			
            //color
            if ($rank_new[0] >= 1 && $rank_new[0] <= 10 || $rank_new[1] >= 1 && $rank_new[1] <= 10) {
                $check_params['color'] = '#E4EDF9';
            } else if ($rank_new[0] >= 11 && $rank_new[0] <= 20 || $rank_new[1] >= 11 && $rank_new[1] <= 20) {
                $check_params['color'] = '#FAFAD2';
            } else if ($rank_old[0] >= 1 && $rank_old[0] <= 10 && $rank_new[0] > 10 || $rank_old[1] >= 1 && $rank_old[1] <= 10 && $rank_new[1] > 10) {
                $check_params['color'] = '#FFBFBF';
            } else {
                $check_params['color'] = '';
            }
			
            //arrow
			if ($rank_new[0] > $rank_old[0] || $rank_new[1] > $rank_old[1] || $rank_new[0] == 0 && $rank_old[0] !=0 || $rank_new[1] == 0 && $rank_old[1] !=0) {
                $check_params['arrow'] = '<span class="red-arrow">↓</span>';
            } else if ($rank_new[0] < $rank_old[0] || $rank_new[1] < $rank_old[1]) {
                $check_params['arrow'] = '<span class="blue-arrow">↑</span>';
            } else {
                $check_params['arrow'] = '';
            }
			
            $rankhistory['Rankhistory']['params'] = json_encode($check_params);
            $this->Keyword->Rankhistory->create();
            $this->Keyword->Rankhistory->save($rankhistory);
			
            $duration = $this->Keyword->Duration->find('first', array(
                'fields' => array('Duration.StartDate'),
                'conditions' => array(
                    'Duration.KeyID' => $keyword['Keyword']['ID'],
                    'Duration.Flag' => 2
                ),
                'order' => 'Duration.ID'
            ));
			
            if ($duration == false) {
                if (strpos($rank, '/') !== false) {
                    $ranks = explode('/', $rank);
                    $google_rank = $ranks[0];
                    $yahoo_rank = $ranks[1];
                }
				
                if (($google_rank > 0 && $google_rank <= 10) || ($yahoo_rank > 0 && $yahoo_rank <= 10) || ($rank > 0 && $rank <= 10)) {
                    $durations['Duration']['KeyID'] = $keyword['Keyword']['ID'];
                    $durations['Duration']['StartDate'] = date('Ymd');
                    $durations['Duration']['EndDate'] = 0;
                    $durations['Duration']['Flag'] = 2;
                    $this->Keyword->Duration->create();
                    $this->Keyword->Duration->save($durations);
                }
				sleep(1);
            }
            //done keyword
            $this->out('Done Keyword: '.$keyword['Keyword']['ID'].'   '.$keyword['Keyword']['Keyword'].'   '.$keyword['Keyword']['Url']);
        }
        //　Load Rank successfully
        $this->out('Done');
    }
}

?>