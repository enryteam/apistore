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
		// if($baseCore::curl_get_url(urldecode($_GET['ac']),$site_data))
		// {
			echo $site_data = str_replace('data-src="http://','data-src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=http://',docurl(urldecode($_GET['ac'])));
	    //var_dump($content);
	    $s_s = '<title>';
			$s_e = '<\/title>';
			preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr_title);
	    var_dump($arr_title);
	    $s_s = '<div class="rich_media_content " id="js_content">';
			$s_e = '<\/div>';
			preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr_body);

	    var_dump($arr_body);


			exit;
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=gbk">
						<title>'.$arr_title[1].'</title>
						<keywords>'.$arr_title[1].' HybirdApp,HybirdApp教程,HybirdApp开发工具,HybirdApp网站,HybirdApp视频,HybirdApp游戏,HybirdApp应用,HybirdApp,cordova,phonegap html5,wxml,wxss教程,css,javascript,js教程</keywords>
						<description>'.strip_tags(mb_substr(trim($arr_body[1]),0,400,'UTF-8')).'</description>
						<!--Detail001---Start--></head><body>'.$arr_body[1].'<p>&nbsp;</p>';
			echo '<!--Detail001---Over--></body></html>';
		//}
		exit;
	}

	echo '<!--List001---Start-->';
	for($pageID==1;$pageID<3;$pageID++)
	{
	$listurl = 'http://weixin.sogou.com/weixin?query=%E5%BE%AE%E4%BF%A1%E5%B0%8F%E7%A8%8B%E5%BA%8F&_sug_type_=&_sug_=n&type=2&page='.$pageID.'&ie=utf8';
	if($baseCore::curl_get_url($listurl,$site_data))
	{
		//echo strlen($site_data);
	  //echo strip_tags($site_data,'<a>');
		// $s_s = '<body';
		// $s_e = '</body>';
		// preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr);
		$pat = '/<a href="(.*?)" target="_blank" id="sogou_vr_(.*?)>(.*?)<\/a>/i';
		preg_match_all($pat, strip_tags($site_data,'<a>'), $m);
		//print_r($m);
		$List = array();
		if($m){
			foreach($m[1] as $key=>$val){
				$List[$key]["url"] = $val;
			}
			foreach($m[3] as $key=>$val){
				$List[$key]["title"] = $val;
			}
			foreach ($List as $key => $value) {
				echo '<a href="http://apistore.51daniu.cn/service/curl/sogou.php?ac='.urlencode($value['url']).'">'.$value['title'].'</a>';
				echo '<br>';
			}
		}

	}
}
	echo '<!--List001---Over-->';
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
