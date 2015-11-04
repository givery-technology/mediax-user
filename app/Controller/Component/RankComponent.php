<?php

App::uses('Component', 'Controller');

class RankComponent extends Component {

        public function remainUrl($string) {
                $string = trim($string);
                $string = str_replace(' ', '', $string);
                if (substr($string, 0, 4) == "http") {
                        $pos = strpos($string, "//") + 2;
                        $string = substr($string, $pos);
                }
                if (substr($string, -1) == "/") {
                        $string = substr($string, 0, -1);
                }
                return $string;
        }

        public function remainDomain($string) {
                $string = trim($string);
                $string = str_replace(' ', '', $string);
                if (substr($string, 0, 4) == "http") {
                        $pos = strpos($string, "//") + 2;
                        $string = substr($string, $pos);
                }
                if (($pos = strpos($string, "/")) > 0) {
                        $string = substr($string, 0, $pos);
                }

                if (substr($string, 0, 4) == "www.") {
                        $string = substr($string, 4);
                }
                return $string;
        }

    public function keyWordRank($engine, $url, $keyword, $savecache = false, $onlytop10 = false) {
        $status = 0; // 0 - new keyword, 1 - keyword need update, 2 - keyword is effective
        $rank = 0;
        $page_start = -1;
		
		// Euc2Utf8 return mb_convert_encoding($str, 'UTF-8', 'EUC-JP');
        $keystring = urlencode($this->arrayToUtf8($keyword));
		#$keystring = mb_convert_encoding($keyword, "UTF-8");
        
		if (strpos($url, "knt.co.jp") > 0) {                        
            $engines['google_jp'] = array(
                'url0' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=',
                'url1' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=100&start=_START_',
				#'pattern' => '/r"><a href="([^<>]*)" class=l/');
          		#'pattern' => '/<h3 class="r"><a href="([^<>]*)" onmousedown/');
                'pattern' => '/<cite>([^<>]*)<\/cite><span class="flc"> -/'
			);
        } else {
            $engines['google_jp'] = array(
                'url0' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=',
                'url1' => 'http://www.google.co.jp/search?hl=ja&q=_QUERY_&btnG=Google+%E6%A4%9C%E7%B4%A2&lr=&num=100&start=_START_',
				#'pattern' => '/r"><a href="([^<>]*)" class=l/');
	            #'pattern' => '/<h3 class="r"><a href="([^<>]*)" onmousedown/');
                'pattern' => '/<cite>([^<>]*)<\/cite><span class="flc">/'
			);
        }
		
        $engines['yahoo_jp'] = array(
            'url0' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2',
            'url1' => 'http://search.yahoo.co.jp/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_',
            //'pattern' => '/<div class="sinf"><em class="yschurl">(.*)<\/em>/');
			//'pattern' => '/<em>(.*)<\/em><\/li>/');
            'pattern' => '/<li><a href="([^<>]*)">/'
			);
        $engines['google_en'] = array(
            'url0' => 'http://www.google.com/search?q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2',
            'url1' => 'http://www.google.com/search?num=100&q=_QUERY_&&btnG=Google+%E6%90%9C%E7%B4%A2&start=_START_',
            'pattern' => '/<h3 class="r"><a href="([^<>]*)" onmousedown/');
        $engines['yahoo_en'] = array(
            'url0' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&fl=0&pstart=1&fr=top_v2',
            'url1' => 'http://search.yahoo.com/search?p=_QUERY_&ei=UTF-8&n=100&fl=0&pstart=1&fr=top_v2&b=_START_',
            'pattern' => '/<span class=url>([\S]*)<\/span>/');
        $engines['google_cn'] = array(
            'url0' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=',
            'url1' => 'http://www.google.cn/search?hl=zh-CN&q=_QUERY_&btnG=Google+%E6%90%9C%E7%B4%A2&meta=&aq=f&oq=&num=100',
            'pattern' => '/=r><a href="([^<>]*)" (target=_blank )?class=l>/');
			
        $start_base = ($engine == 'yahoo_jp' || $engine == 'yahoo_en') ? 1 : 0;
		
        $page_start++;
        $pagemax = 1;
        //only check rank within top10
        if ($onlytop10) {
            $pagemax = 0;
        }

        for ($page = $page_start; $page <= $pagemax; $page++) {
                $start = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $start_base;
                $search_url = $engines[$engine]['url' . $page];
                $search_url = str_replace('_QUERY_', $keystring, $search_url);
                $search_url = str_replace('_START_', $start, $search_url);
                //print_r($search_url.'</br>');��������̥ڡ�����ɽ��
                //sleep(2);
                //echo $search_url."<br />";
                $html = $this->getWebContent($search_url);
                //print_r($html);
				//$html = str_replace('<b>',"", $html);
				//$html = str_replace('</b>',"", $html);
                $html = str_replace('<strong>', "", $html);
                $html = str_replace('</strong>', "", $html);
                if ($page == 0)
                    $html0 = $html;
				
				//echo $search_url.'<br/>';
				#show_html($html);
                $html = str_replace('<b>', "", $html);
                $html = str_replace('</b>', "", $html);
                preg_match_all($engines[$engine]['pattern'], $html, $matches);
                if (isset($matches[1])) {
                    $matches[1] = array_map("Text2Domain", $matches[1]);
					#print_pre($matches[1]);
	                $rank_arr['pages'][$page] = $matches[1];
	                $rank_arr['pagecount'] = $page;
	                $key = $this->rootDomainSearch($url, $matches[1]);
				    if ($key !== false) {
	                    $rank = (($page - 1 < 0) ? 0 : $page - 1) * 100 + $key + 1;
	                    break;
	                }
                }
                if ($page < $pagemax - 1) {
                	//sleep(1);
                } else {
                        if ($rank > 0 && $rank <= 10) { // if top 100's rank <= 10, set it to 11
                        	$rank = 11;
                        }
                }
        }
		
        $rank_arr['update'] = time();
        $rank_str = serialize($rank_arr);
        $this->Rankkeyword = ClassRegistry::init('Rankkeyword');
        if ($status == 0) {
                $rankkeyword['Rankkeyword']['Keyword'] = $keyword;
                $rankkeyword['Rankkeyword'][$engine] = $rank_str;
        } else {
                $rankkeyword['Rankkeyword']['ID'] = $keyid;
                $rankkeyword['Rankkeyword'][$engine] = $rank_str;
                $this->Rankkeyword->create();
        }
        $this->Rankkeyword->save($rankkeyword);
		
        //save cahce
        if (!empty($html0) && $rank > 0 && $rank <= 10) {
            $savecache = true;
        }
		
        if ($savecache == true) {
            $date = date('Ymd');
            if ($rank > 10) {
                    $html0 = $html;
            }
            $cachepath = ROOT . "/../rankcache_new/" . $date;
            if (!file_exists($cachepath)) {
                    mkdir($cachepath, 0777);
            }
            #$filename = $cachepath . "/" . md5($keyword . "_" . $engine) . ".html";
			$filename = $cachepath . "/" . md5(mb_convert_encoding($keyword ."_" .$engine, 'EUC-JP')) .".html";
			#debug($engine);
			
            if ($handle = fopen($filename, 'w')) {
                #$html0 = mb_convert_encoding($html0, "UTF-8", "auto"); // Yahoo
				#$html0 = mb_convert_encoding($html0, "UTF-8", "JIS"); // Google
				
				if($engine == "google_jp"){
					$html0 = mb_convert_encoding($html0, "UTF-8", "JIS, eucjp-win, sjis-win");
				} else {
					$html0 = mb_convert_encoding($html0, 'UTF-8', "auto");
				}
				
                fwrite($handle, $html0);
              	fclose($handle);
            }
        }
		
		return $rank;
    }

        public function getWebContent($url) {
                if(function_exists('curl_init')){
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //
                        $contents = curl_exec($ch);
                        curl_close($ch);                       
                }else{
                        $contents = file_get_contents($url);
                }
                return $contents;
        }

        public function rootDomainSearch($url, $domainArr) {
                foreach ($domainArr as $key => $domain) {
                        if (strpos($domain, $url) !== false) {
                                return $key;
                        }
                }
                return false;
        }
        
        public function getEngineList() {
            $this->Engine = ClassRegistry::init('Engine');
            $engines = Cache::read('enginelist','Engine');
			if(!$engines){
                $engines = $this->Engine->find('all');
                Cache::write('enginelist','Engine');
            }
			
            foreach ($engines as $engine) {
                $enginelist[$engine['Engine']['Code']] = array('Name' => $engine['Engine']['Name'], 'ShowName' => $engine['Engine']['ShowName']);
            }
            return $enginelist;
        }        
        
	/**
	 * if array is not UTF-8 then convert keys and values to UTF-8
	 * method is recursive
	 *
	 * @param mixed $in
	 */
	public function arrayToUtf8($in) {
		if (is_array($in)) {
			foreach ($in as $key => $value) {
				$out[$this->arrayToUtf8($key)] = $this->arrayToUtf8($value);
			}
		} elseif (is_string($in)) {
			if (mb_detect_encoding($in) != "UTF-8")
				return utf8_encode($in);
			else
				return $in;
		} else {
			return $in;
		}
		return $out;
	}        
}

//function
function Text2Domain($string) {
        $string = ReplaceBold($string);
        //$string = RemainDomain($string);	// 0904
        return $string;
}

function ReplaceBold($string) {
        $string = str_replace('<b>', '', $string);
        $string = str_replace('</b>', '', $string);
        $string = str_replace('<wbr>', '', $string);
        return $string;
}

?>