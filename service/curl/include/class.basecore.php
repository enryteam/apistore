<?php
class baseCore{

	 public function curl_post_vars($url, $vars)
	 {
	   	    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_POST, 1 );
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
				curl_setopt($ch, CURLOPT_TIMEOUT, TIMEOUT );
		    curl_setopt($ch, CURLOPT_COOKIEJAR,COOKIEJAR);
		    $data = curl_exec($ch);
		    curl_close($ch);
		    if ($data){
		        return true;
			}else{
		        return false;
			}

	}

	public function curl_post_url($url,&$data,$vars=NULL)
	{
	   	$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $vars);
		curl_setopt( $ch, CURLOPT_USERAGENT, USERAGENT );
		curl_setopt( $ch, CURLOPT_TIMEOUT, TIMEOUT );
		curl_setopt( $ch, CURLOPT_COOKIEFILE, COOKIEJAR );
		ob_start();
		$c = curl_exec($ch);
		$data = ob_get_contents();
		ob_end_clean();
		curl_close( $ch );
		if ($data){
			return true;
		}else{
			return false;
		}

	}

	public function curl_get_url($url,&$data)
	{
		$ip = '180.111.'.rand(10,200).'.'.rand(10,200);

		$header = array(
		'X-FORWARDED-FOR: ' . $ip,
		'CLIENT-IP: ' . $ip,
		);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_TIMEOUT, 30 );
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
	  // curl_setopt($ch,CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		// curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
		// curl_setopt($ch,CURLOPT_PROXY, $ip);
		// curl_setopt($ch,CURLOPT_PROXYPORT, '80');
		$data = curl_exec($ch);
		if ($data){
			return true;
		}else{
			return false;
		}

	}


	public function readcookies( $file )
	{
		$fp = fopen( $file, "r" );
		while ( !feof( $fp ) )
		{
			$buffer = fgets( $fp, 4096 );
			$tmp = split( "\t", $buffer );
			$result[trim( $tmp[5] )] = trim( $tmp[6] );
		}
		return $result;
	}

	public function writetext($filename,$contentarr)
	{
		$txtDir = DIRROOT.'./'.date("Y").'/'.date("m").'/';
		if (!is_dir( $txtDir ))
		{
			self::mkdirs( $txtDir );
		}

		$f=fopen($txtDir.$filename.'_'.date("Ymd").'.txt','a+');
		fwrite($f,'Time:'.date('Y-m-d H:i:s',time())."\r\n");
		foreach($contentarr as $key=>$val)
		{
			fwrite($f,''.$key.':'.$val."\r\n");
		}
		fwrite($f,"\r\n\r\n");
		fclose($f);

	}

	public function mkdirs($dir)
	{
		if(!is_dir($dir))
		{
			if(!self::mkdirs(dirname($dir))){
				return false;
			}
			if(!mkdir($dir,0777)){
				return false;
			}
		}
		return true;
	}

}
?>
