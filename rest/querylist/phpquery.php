<?php

error_reporting(0);
require 'vendor/autoload.php';
use QL\QueryList;
$greatCities = unserialize(file_get_contents('greatCities.txt'));
$rnd = rand(0,count($greatCities)-1);
$_SESSION['area_id'] = $greatCities[$rnd]['area_id'];
$city = $greatCities[$rnd]['area_pinyin'];//全国一、二线城市
for($page=1;$page<=rand(10,100);$page++)
{

    echo $curl = 'http://yyk.39.net/'.$city.'/doctors/c_p'.$page.'/';

    $urls = QueryList::run('Request',[
            'target' => 'http://yyk.39.net/'.$city.'/doctors/c_p'.$page.'/',
            'referrer'=>'http://yyk.39.net/'.$city.'/',
            'method' => 'GET',
            'params' => ['t' => time()],
            'user_agent'=>'Mozilla/7.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20160101 Firefox/23.0',
            'cookiePath' => './cookie_net39.txt',
            'timeout' =>'60'
        ])->setQuery(['link' => ['div>a','href','',function($content){

                          //利用回调函数补全相对链接
                          $baseUrl = 'http://yyk.39.net/';
                          return $baseUrl.$content;
        }]],'.serach-left-list li')->getData(function($item){

                      return $item['link'];
    });

 echo "<pre>";
 print_r($urls);
// exit;
//多线程扩展
QueryList::run('Multi',[
    'list' => $urls,
    'curl' => [
        'opt' => array(
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true,
                ),
        //设置线程数
        'maxThread' => 2,//根据对象服务器实际情况而定
        //设置最大尝试数
        'maxTry' => 3
    ],
    'success' => function($a){

        //采集规则
        $reg = array(
            //姓名
            'name' => array('dt>b','text'),
            //头衔
            'title' => array('dt>span','text','',function($content){
                $variable = explode("\r\n",$content);
                $array = array("","","");
                foreach ($variable as $key => $value) {
                  $row = str_replace("	","",$value);

                  if(!empty($row))
                  {
                    if(strstr($row,'科室')) $array[0]=$row;
                    if(strstr($row,'医师')) $array[1]=$row;
                    if(strstr($row,'教授')) $array[2]=$row;
                  }

                }

                return $array;
            }),
            //出诊地点
            'visit' => array('dd>a','text','',function($content){
              $variable = explode("\r\n",$content);
              $array = array("","");
              foreach ($variable as $key => $value) {
                $row = str_replace("	","",$value);

                if(!empty($row))
                {
                  if(strstr($row,'医院')||strstr($row,'保健院')) $array[0]=$row;
                  if(strstr($row,'科')||strstr($row,'中心')) $array[1]=$row;
                }

              }
              return $array;
              }),
              //擅长领域
              'goodat' => array('.intro_more p','text','',function($content){
                $content = str_replace('[关闭]','',str_replace("擅长领域：","",$content));
                return $content;
                }),
              //执业经历
              'experience' => array('dd>p','text','',function($content){
                $content = str_replace('—&amp;md','',str_replace('...[详细介绍]','',$content));
                return $content;
                }),
              //地区
              'area_id' => array('.pic img','src','',function($content){
                return $_SESSION['area_id'];
              }),
              //头像
              'avatar' => array('.pic img','src')
            );
        $rang = '.doc-detail';
        $body = mb_convert_encoding(str_replace('gbk','utf-8',$a['content']),'utf-8','GBK');

        $ql = QueryList::Query($body,$reg,$rang);
        $data = $ql->getData();
        print_r($data);
        file_get_contents('https://apistore.51daniu.cn/rest/index.php?c=query&a=max&do=write&da='.url_encode(serialize($data)));

    }
]);

}
 ?>
