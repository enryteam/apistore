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

		$url = urldecode($_GET['ac']);
		//$url = 'http%3A%2F%2Fmp.weixin.qq.com%2Fs%3F__biz%3DMzA5NTQ2NjUzMA%3D%3D%26mid%3D207136729%26idx%3D1%26sn%3Da82af7b7ba0bee9a7017b607dc7e5d4b%26scene%3D5%23rd';
		//$url = 'http://mp.weixin.qq.com/s?__biz=MzA5NTQ2NjUzMA==&mid=207136729&idx=1&sn=a82af7b7ba0bee9a7017b607dc7e5d4b&scene=5#rd';

		//var_dump(urlencode($url));
		$site_data = str_replace('data-src="http://','data-src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=http://',docurl($url));
		//var_dump($content);
		$s_s = '<h2 class="rich_media_title" id="activity-name">';
		$s_e = '<\/h2>';
		preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr_title);
		//var_dump($arr_title);
		$s_s = '<div class="rich_media_content " id="js_content">';
		$s_e = '<\/div>';
		preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr_body);

		//var_dump($arr_body);

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>'.$arr_title[1].'</title>
					<keywords>HybirdApp,HybirdApp教程,HybirdApp开发工具,HybirdApp网站,HybirdApp视频,HybirdApp游戏,HybirdApp应用,HybirdApp,cordova,phonegap html5,wxml,wxss教程,css,javascript,js教程</keywords>
					<description>'.mb_substr(trim($arr_body[1]),0,400,'UTF-8').'</description>
					<!--Detail001---Start-->
					</head><body>'.$arr_body[1].'<p></p><p></p><p></p><p><a href="http://www.hybirdapp.com/" target="_blank">HybirdApp中国</a>，是中国最大的HybirdApp中文门户。为广大HybirdApp开发者提供HybirdApp教程、HybirdApp开发工具、HybirdApp网站示例、HybirdApp视频、Cordova Phonegap 微信小程序wxapp教程等多种HybirdApp在线学习资源。</p>';
		echo '<!--Detail001---Over--></body></html>';
		exit;
	}

	echo '<!--List001---Start-->';
	include "Snoopy.class.php";
	$snoopy = new Snoopy;

	$snoopy->proxy_host = "weixin.sogou.com";
	$snoopy->proxy_port = "8080";

	$snoopy->agent = "(compatible; MSIE 4.01; MSN 2.5; AOL 4.0; Windows 98)";
	$snoopy->referer = "http://weixin.sogou.com/";

	$snoopy->cookies["SessionID"] = 238472834723489l;
	$snoopy->cookies["favoriteColor"] = "RED";

	$snoopy->rawheaders["Pragma"] = "no-cache";

	$snoopy->maxredirs = 2;
	$snoopy->offsiteok = false;
	$snoopy->expandlinks = false;

	$snoopy->user = "joe";
	$snoopy->pass = "bloe";

	if($snoopy->fetchtext("http://weixin.sogou.com")) 
	{
	  echo " <PRE>".htmlspecialchars($snoopy->results)." </PRE>\n"; <BR>
	}
	else
	{
		echo "error fetching document: ".$snoopy->error."\n";

	}

	foreach ($return->data as $key => $val) {
		echo '<a href="http://apistore.51daniu.cn/service/curl/soso.php?ac='.urlencode($val['detailLink']).'">'.$val['detailLink'].'</a><br>';
	}

	echo '<!--List001---Over-->';
	/**
	 * 请求接口返回内容
	 * @param  string $url [请求的URL地址]
	 * @param  string $params [请求的参数]
	 * @param  int $ipost [是否采用POST形式]
	 * @return  string
	 */
	function docurl($url){
		$httpInfo = array();
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );

		curl_setopt( $ch , CURLOPT_URL , $url);

		$response = curl_exec( $ch );
		if ($response === FALSE) {
			//echo "cURL Error: " . curl_error($ch);
			return false;
		}
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		return $response;
	}

?>
