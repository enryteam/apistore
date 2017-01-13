<?php
	header("Content-type:text/html;charset=utf-8");
	header("refresh:1800;url=?token=".md5(time()).""); 
	ini_set("display_errors","On");
	error_reporting(E_ALL ^ E_NOTICE);
	set_time_limit(0);
	ini_set('memory_limit', '256M');
	date_default_timezone_set("Asia/Shanghai");
	define( "DIRROOT", dirname(__FILE__).DIRECTORY_SEPARATOR);
	define( "USERAGENT", $_SERVER['HTTP_USER_AGENT'] );
	define( "COOKIEJAR", tempnam( ini_get( "upload_tmp_dir" ), "cookie" ) );
	define( "TIMEOUT", 30 );	
	define( "MYNAME", 'myname');//猪八戒网上用户名
	define( "MYPWD", 'mypwd');//猪八戒网上用户密码
	require_once(DIRROOT.'./include/class.zhubajieTask.php');
	
	$zhubajietask = new zhubajieTask;
	$zhubajietask->joinTaskList();

?>