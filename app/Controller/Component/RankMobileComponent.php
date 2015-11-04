<?php

App::uses('Component', 'Controller');

class RankMobileComponent extends Component {

        public $components = array('Rank');

        public function keywordRankYahooMobile($url, $keyword) {
                $arr1 = $this->yahoo_url($keyword, 2);
                $rankarray = $arr1["arr"];
                $key = $this->Rank->rootDomainSearch($url, $rankarray);
                if ($key == false) {
                        $key = 0;
                } else {
                        $key = $key + 1;
                        $this->saveSearchCache("$keyword", "yahoo_mobile", $arr1["str"]);
                }
                return $key;
        }
        
        public function keywordRankGoogleMobile($url,$keyword){
                $useragent="DoCoMo/2.0 P705i(c100;TB;W30H19)";
                $parten='/span><a href="([^<>]*)" /';
                $keystring = urlencode($this->Rank->arrayToUtf8($keyword));
                $html=$this->getWebContent("http://www.google.co.jp/m?mrestrict=chtml&eosr=on&ct=fsh&q=".$keystring,$useragent);

                //$html=cutcontent($html,"<div style=\"padding-top:5px","<div class=\"sftr alignright\">");
                //echo $html;

                $htmltemp=$html;
                preg_match_all($parten, $html, $matches);
                $matches[1]=array_map("updateurl",$matches[1]);

                //print_pre($matches[1]);
                $rankarray=$matches[1];
                $html=$this->getWebContent("http://www.google.co.jp/m?eosr=on&site=search&mrestrict=chtml&start=10&sa=X&oi=blended&ct=more-results&q=".$keystring,$useragent);
                $html=$this->cutcontent($html,"<div style=\"padding-top:5px;padding-bottom:5px;padding-left:1px;padding-right:0px;\">","<div class=\"sftr alignright\">");
                //saveSearchCache($engine_list[8]['Name']."-".md5($keyword)."-1",$html);
                $this->saveSearchCache("$keyword","google_mobile",$htmltemp.$html);

                preg_match_all($parten, $html, $matches);
                $matches[1]=array_map("updateurl",$matches[1]);
                //print_pre($matches[1]);
                $rankarray=array_merge($rankarray,$matches[1]);
                $key = $this->Rank->rootDomainSearch($url, $rankarray);
                if($key===false){
                        $key=0;
                }else{
                        $key=$key+1;
                }
                return $key;
        }        

        function yahoo_url($content = "seo", $pageTotal = 2, $url = 'http://mobile-search.yahoo.co.jp/search?carrier=imode&safe=1&module=mobilesite&left=open', $de_code = 'utf8') {
                //echo "text";
                //set_time_limit(3600*20);
                //ini_set ('memory_limit', "128M");
                //header("Content-Type:text/html;charset=$de_code");
                $content = $this->Rank->arrayToUtf8($content);
                $page_start = $_GET['page_start'] ? $_GET['page_start'] : '1';
                for ($start = 0; $start < $pageTotal; $start++) {
                        sleep(1);
                        $page_start = 10 * $start + 1;
                        $true_url = $url . "&p=" . rawurlencode($content) . "&b=$page_start";
                        $text = $this->getWebContent($true_url);
                        $text = str_replace("\n", "", $text);
                        $text = $this->Rank->arrayToUtf8($text);

                        $pattern_c = "/<div id\=\"mobschweb\">(.*)<\!\-\- \/\#�������������� \-\->\s+<\/div>/U";
                        preg_match_all($pattern_c, $text, $matches_c);
                        $main_text = $matches_c[1][0];

                        $pattern_item = "/<li>(.*)<\/li>/U";
                        preg_match_all($pattern_item, $main_text, $matches_item);

                        for ($i = 0, $n = count($matches_item[1]); $i < $n; $i++) {
                                $main_item = $matches_item[1][$i];

                                $pattern_a = "/<a.*>(.*)<\/a>/U";
                                preg_match_all($pattern_a, $main_item, $matches_a);

                                $pattern_txt = "/<div class=\"mobweb_text\">(.*)<\/div>/U";
                                preg_match_all($pattern_txt, $main_item, $matches_txt);

                                if ($de_code != 'utf8') {
                                        $matches_a[1][0] = iconv("UTF-8", $de_code, $matches_a[1][0]);
                                        $matches_txt[1][0] = iconv("UTF-8", $de_code, $matches_txt[1][0]);
                                }
                                $out_str .='<' . (10 * $start + $i + 1) . '>' . $matches_a[1][0] . '<br>' . $matches_txt[1][0] . '<br>';

                                $pattern_url = "/showSimulator\(\\\\'\/(.*)\\\\'\)/U";
                                preg_match_all($pattern_url, $main_item, $matches_url);
                                $url_1 = "http://mobile-search.yahoo.co.jp/" . $matches_url[1][0];
                                $text_1 = $this->getWebContent($url_1);
                                $text_1 = str_replace("\n", "", $text_1);
                                $pattern_1 = "/<base href\=\"(.*)\" \/>/U";
                                preg_match_all($pattern_1, $text_1, $matches_out_url);
                                $out_arr[] = $matches_out_url[1][0];
                        }
                }
                $out['str'] = $out_str;
                $out['arr'] = $out_arr;
                return $out;
        }

        function saveSearchCache($keyword, $engine, $content) {
                //filename format
                //date-searchenginename-md5(euc keyword)-0
                $date = date("Ymd");
                $cachepath = ROOT . "/../rankcache_new/" . $date;
                if (!file_exists($cachepath)) {
                        mkdir($cachepath);
                }
                $filename = $cachepath . "/" . md5($keyword . "_" . $engine) . ".html";
                if ($handle = fopen($filename, 'w')) {
                        fwrite($handle, $content);
                        fclose($handle);
                }
        }
        
        public function getWebContent($url,$user_agent="") {
                if(function_exists('curl_init')){
                        $ch = curl_init();
                        curl_setopt ($ch, CURLOPT_URL, $url);
                        curl_setopt ($ch, CURLOPT_HEADER, 0);
                        curl_setopt ($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
                        curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
                        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt ($ch, CURLOPT_TIMEOUT, 300);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//
                        $contents = curl_exec ($ch);
                        curl_close ($ch);                    
                }else{
                        $contents = file_get_contents($url, false, stream_context_create(array('http'=>array('method'=>"GET",'header'=>"User-Agent: ".$user_agent))));
                }
                return $contents;
        }     
        
        public function cutcontent($str,$fromstr,$tostr=null){
                $posstart = strpos($str, $fromstr);
                if($posstart==null){$posstart=0;}
                if($tostr!=null){
                        $posend=strpos($str,$tostr,0)-1;
                }
                if(($tostr==null)||($posend==null)){
                        $posend=strlen($str);
                }
                        $posend=$posend-$posstart;
                $result=substr($str,$posstart,$posend);
                return $result;

        }        

}

?>