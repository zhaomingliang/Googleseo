<?php
namespace Googleseo;
header("Content-type: text/html; charset=utf-8"); 
include_once "./simple_html_dom.php";
//error_reporting(0);
set_time_limit(0);
$time = date("Y-m-d");
$html = new simple_html_dom();

class googleseo{
    /*查询网站是否在首页*/
    public static function indexranking($yuming){
            $html->load_file('https://www.google.com.hk/search?oe=utf-8&pws=0&complete=0&hl=en&num=10&q='.$yuming.'&nfpr=1');
            $result = $html->find('div[class=g] cite');
                $data = array();
                foreach($result as $v) {
                        $data[] .= $v->innertext;
                        $data = str_replace("<b>","",$data);
                        $data = str_replace("</b>","",$data);
                } 
                $yuming = trim($yuming)."/";
                $webranking = array_search($yuming,$data);
                if(!is_bool($webranking)){
                    $rswebranking = $webranking + 1;
                }
                else{
                    $rswebranking = "10+";
                }
            return $rswebranking;

    }

    /*查询网站在google收录数*/
    public static function webinclude($yuming){
            $html->load_file('https://www.google.com.hk/search?oe=utf-8&pws=0&complete=0&hl=en&num=10&q=site:'.$yuming);

            $webincluderesult = $html->find('#resultStats'); 
            foreach($webincluderesult as $v) {
                 $webinclude = $v->innertext;
            }
            $webinclude = str_replace(",","",$webinclude);
            $webincludedata = preg_match('/-?[1-9]\d*/', $webinclude, $matches);
            $webincludedata  = $matches['0'];
            return $webincludedata;

    }


}


/*
 *使用方法
 * include_once "./GooglseoClass.php";
 * googleseo::indexranking('baidu.com');
*/
?>