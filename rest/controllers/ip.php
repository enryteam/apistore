<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class ip extends BaseAction
 {
 	public function __construct()
 	{
 		parent::__construct();
 	}

 	public function index()
 	{
    returnJson('200','Welcome to 51daniu.cn');

 	}
  public function myip()
  {
    $IPaddress='';
    if (isset($_SERVER)){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $IPaddress = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")){
            $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $IPaddress = getenv("HTTP_CLIENT_IP");
        } else {
            $IPaddress = getenv("REMOTE_ADDR");
        }
    }
    echo $IPaddress;
    file_put_contents("gydz.txt",$IPaddress);
    exit;

  }
  public function address()
  {


    $aliyun_appKey = "23545958";
    $aliyun_appSecret = "fe8145295288eb6c54890ca914a838a8";
    $aliyun_host = "https://dm-81.data.aliyun.com";
    $aliyun_path = "/rest/160601/ip/getIpInfo.json";

    include_once 'aliyun-api-gateway/Util/aliyunAutoloader.php';

		$request = new aliyunHttpRequest($aliyun_host, $aliyun_path, aliyunHttpMethod::GET, $aliyun_appKey, $aliyun_appSecret);
    $request->setHeader(aliyunHttpHeader::HTTP_HEADER_CONTENT_TYPE, aliyunContentType::CONTENT_TYPE_TEXT);
		$request->setHeader(aliyunHttpHeader::HTTP_HEADER_ACCEPT, aliyunContentType::CONTENT_TYPE_TEXT);
    $request->setQuery("ip", getgpc("ip"));
		$response = (array)aliyunHttpClient::execute($request);
    foreach($response as $key=>$value)
    {
      $retArr[] = $value;
    }
    $retArr = json_decode($retArr[1],true);

    if($retArr['code']=="0")
    {
      returnJson('200','onSuccess',$retArr['data']);

    }
    else
    {
      returnJson('500','onFail',$retArr['data']);

    }

  }
}
?>
