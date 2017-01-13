<?php
	header("Content-type:text/html;charset=utf-8");
	header("refresh:1800;url=?token=".md5(time())."");
	ini_set("display_errors","On");
	error_reporting(0);
	set_time_limit(0);
	ini_set('memory_limit', '256M');
	date_default_timezone_set("Asia/Shanghai");
	define( "DIRROOT", dirname(__FILE__).DIRECTORY_SEPARATOR);
	define( "USERAGENT", $_SERVER['HTTP_USER_AGENT'] );
	define( "COOKIEJAR", tempnam( ini_get( "upload_tmp_dir" ), "cookie" ) );
	define( "TIMEOUT", 30 );
	if(!class_exists('baseCore')){
		require_once(DIRROOT.'./include/class.basecore.php');
		$baseCore = new baseCore;
	}
	if(!empty($_GET['ac']))
	{
		if($baseCore::curl_get_url('http://www.henkuai.com'.urldecode($_GET['ac']),$site_data))
		{
			preg_match_all('/<title>(.*?)<\/title>/isU',$site_data, $title);

			preg_match_all('/<table cellspacing="0" cellpadding="0"><tr><td class="t_f"(.*?)<\/td><\/tr><\/table>

<div class="ptg mbm mtn">/isU',$site_data, $arr);


			//var_dump($title);
			$str = preg_replace('/<a\s+href=\'?"?([^>]+)\'?"?.*>/imsU','',$arr[1][0]);
			$str = preg_replace("/<script[\s\S]*?<\/script>/i", "", $str);
			$str = preg_replace('/ id="postmessage_.*">/i',"",$str);
			$str = str_replace('"static/image/common/none.gif" zoomfile=','',$str);
			$str = str_replace('游客，如果您要查看本帖隐藏内容请回复','',$str);
			$str = str_replace('-狂兔科技','-HybirdApp中国',str_replace('</a>','',$str));
			$str = str_replace('回复可见：','',$str);
			$str = str_replace('（www.henkuai.com）','（www.hybirdapp.com）',$str);
			preg_match_all('/<span id="thread_subject">(.*?)</span><\/span>/isU',$site_data, $arr);

			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>'.$title[1][0].'</title>
			<keywords>HybirdApp,HybirdApp教程,HybirdApp开发工具,HybirdApp网站,HybirdApp视频,HybirdApp游戏,HybirdApp应用,HybirdApp,cordova,phonegap html5,wxml,wxss教程,css,javascript,js教程</keywords>
			<description>'.strip_tags(mb_substr(trim($str),0,400,'UTF-8')).'</description>
			<!--Detail001---Start--></head><body>'.$str.'<p></p><p></p><p></p><p><a href="http://www.hybirdapp.com/" target="_blank">HybirdApp中国</a>，是中国最大的HybirdApp中文门户。为广大HybirdApp开发者提供HybirdApp教程、HybirdApp开发工具、HybirdApp网站示例、HybirdApp视频、Cordova Phonegap 微信小程序wxapp教程等多种HybirdApp在线学习资源。</p>';
				echo '<!--Detail001---Over--></body></html>';
		}


		exit;
	}

	echo '<!--List001---Start-->';
	for($pageID==1;$pageID<10;$pageID++)
	{
		$List = array();
		$listurl = 'http://www.henkuai.com/forum-56-'.$pageID.'.html';
		if($baseCore::curl_get_url($listurl,$site_data))
		{
			$s_s = '<!--模板巴士list开始-->';
			$s_e = '<!--模板巴士list结束-->';
			preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr);
			$pat = '/<a href="thread-(.*?).html"(.*?)>(.*?)<\/a>/i';
			preg_match_all($pat, $arr[1], $m);
			if($m){
				foreach($m[1] as $key=>$val){
					$List[$key][url] = 'http://apistore.51daniu.cn/service/curl/dzx.php?ac='.urlencode('/thread-'.$val.'.html');
				}
				foreach($m[3] as $key=>$val){
					$List[$key][title] = $val;
				}
				foreach ($List as $key => $value) {
					echo str_replace('-狂兔科技','-HybirdApp中国','<a href="'.$value['url'].'">'.$value['title'].'</a>');
					echo '<br>';
				}
			}

		}

	}

	echo '<!--List001---Over-->';


?>
