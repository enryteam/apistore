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


	echo '<!--List001---Start-->';
	for($pageID==1;$pageID<5;$pageID++)
	{
	$listurl = 'http://weixin.sogou.com/weixin?query=%E5%BE%AE%E4%BF%A1%E5%B0%8F%E7%A8%8B%E5%BA%8F&_sug_type_=&_sug_=n&type=2&page='.$pageID.'&ie=utf8';
	if($baseCore::curl_get_url($listurl,$site_data))
	{
		// echo strlen($site_data);
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
				echo '<a href="'.$value['url'].'">'.$value['title'].'</a>';
				echo '<br>';
			}
		}

	}
}
	echo '<!--List001---Over-->';


?>
