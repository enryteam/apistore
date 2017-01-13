<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class ocr extends BaseAction
 {


	public $path;
	public function __construct()
 	{
 		parent::__construct();
		$this->path = '../attms/upfile/'.date("Y").'/'.date("m").'/'.date("d").'/'.date("H").'/';
		mk_dir($this->path);
 	}

 	public function index()
 	{
   		returnJson('200','Welcome to 51daniu.cn');

 	}
  /*
   * 识别照片中条形码/二维码
   * img:base64
  */
  public function barcode()
  {
    $base64_image_content = urldecode(getgpc('img'));
	/* Create new image object */
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
      $type = $result[2];
      $new_file = $this->path."barcode_".time().".{$type}";
      if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
        $image = new ZBarCodeImage($new_file);

        /* Create a barcode scanner */
        $scanner = new ZBarCodeScanner();

        /* Scan the image */
        $barcode = $scanner->scan($image);
        /* Loop through possible barcodes */
        if (!empty($barcode)) {
            foreach ($barcode as $code) {
                 $return[$code['type']] = $code['data'];
            }
        		if(getgpc('remote')==1)
        		{
        			$ret['remote'] = str_replace("../attms/upfile/","http://apistore.51daniu.cn/attms/upfile/",$new_file);
        		}
        		$ret['barcode'] = $return['CODE-128'];
        		returnJson('200','onSuccess',$ret);
        }
      	else
      	{
      		returnJson('500','onFail');
      	}
      }
    }


    if(intval(strpos($base64_image_content,'cdn.51daniu.cn'))==7)
    {
        $new_file = str_replace('http://cdn.51daniu.cn/','../attms/',$base64_image_content);
        //新建一个图像对象
        $image = new ZBarCodeImage($new_file);

        // 创建一个二维码识别器
        $scanner = new ZBarCodeScanner();

        //识别图像
        $barcode = $scanner->scan($image);
        /* Loop through possible barcodes */
        if (!empty($barcode)) {

        		returnJson('200','onSuccess',$barcode[0]['data']);
        }
      	else
      	{
      		returnJson('500','onFail');
      	}

    }
    returnJson('500','onFail');

    //else
//    {
//      $ch = curl_init ();
//
//      $header['Accept']='*/*';
//      $header['Accept-Encoding']='zip, deflate';
//      $header['Accept-Language']='zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3';
//      $header['Connection']='keep-alive';
//      $header['Host']='demo.geekso.com';
//      $header['Referer']='http://demo.geekso.com/qrcode/current/tools';
//      $header['User-Agent']='Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:44.0) Gecko/20100101 Firefox/44.0';
//      $header['X-Requested-With']='XMLHttpRequest';
//
//      curl_setopt ( $ch, CURLOPT_URL, 'http://demo.geekso.com/qrcode/submit');
//      curl_setopt ( $ch, CURLOPT_POST, 1 );
//      curl_setopt ( $ch, CURLOPT_HEADER, $header);
//      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
//      curl_setopt ( $ch, CURLOPT_POSTFIELDS, $img);
//      $return = curl_exec ( $ch );
//      //{"status":0,"res":{"type":"CODE-128","data":"210365014935<br \/>","time":1.3588948249817},"time":1456399164}
//      curl_close ( $ch );
//
//    }



  }
  /*
   * 识别身份证
   * img:base64 支持的文件格式：jpg、bmp、jpeg、png。 最大可上传：5M
  */
  public function idcard()
  {

    $base64_image_content = urldecode(getgpc('img'));
    file_put_contents('../attms/upfile/base64_idcard_'.time().'.txt',getgpc('img'));

   /* Create new image object */
   if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
    $type = $result[2];

    $new_file = $this->path."idcard_".time().".{$type}";
    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content))))
    {
     if(getgpc('remote')==1)
    {
      $matches['remote'] =  str_replace("../attms/upfile/","http://cdn.51daniu.cn/upfile/",$new_file);
    }
    // //$f="../attms/upfile/2016/03/01/22/idcard_1456843003.jpeg";
    // //$cfile= curl_file_create($f,'image/jpg','img');
    // $cfile= curl_file_create($new_file);
    // //$cfile = new \CURLFile(D_P."sfz.jpg",'image/jpeg','img');
    // $post=array(
    // 	'action'=>'idcard',
    // 	'callbackurl'=>'/idcard/',
    // 	'img'=>$cfile
    // );
    // $url="http://ocr.ccyunmai.com/UploadImg.action";
    // $return = $this->http_post($url,$post,60,filesize($f));
    //
    // $matches['idcard']  =   str_replace("&lt;cardno&gt;","",substr($return,strpos($return,"&lt;cardno&gt;"),strpos($return,"&lt;/cardno&gt;")-strpos($return,"&lt;cardno&gt;")));
    // //&lt;name&gt;&lt;/name&gt;&lt;cardno&gt;&lt;/cardno&gt;&lt;sex&gt;男&lt;/sex&gt;&lt;folk&gt;白&lt;/folk&gt;&lt;birthday&gt;&lt;/birthday&gt;&lt;address&gt;&lt;/address&gt;&lt;issue_authority&gt;&lt;/issue_authority&gt;&lt;
    //阿里云身份证识别
    // if(empty($matches['idcard']))
    // {
      //  $host = "https://dm-51.data.aliyun.com";
      //  $path = "/rest/160601/ocr/ocr_idcard.json";
      //  $method = "POST";
      //  $appcode = "60365c155f1643faaec1516df7eeeef1";
      //  $headers = array();
      //  array_push($headers, "Authorization:APPCODE " . $appcode);
      //  //根据API的要求，定义相对应的Content-Type
      //  array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
      //  $querys = "";
      //  $bodys = "{\"inputs\":[{\"image\":{\"dataType\":50,\"dataValue\":\"".(str_replace($result[1], '', $base64_image_content))."\"},\"configure\":{\"dataType\":50,\"dataValue\":\"{\\\"side\\\":\\\"face\\\"}\"}}]}";
      //  $url = $host . $path;
       //
      //  $curl = curl_init();
      //  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
      //  curl_setopt($curl, CURLOPT_URL, $url);
      //  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      //  curl_setopt($curl, CURLOPT_FAILONERROR, false);
      //  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      //  curl_setopt($curl, CURLOPT_HEADER, false);
      //  if (1 == strpos("$".$host, "https://"))
      //  {
      //      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      //      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      //  }
      //  curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
      //  $return =  curl_exec($curl);
      $aliyun_appKey = "23545958";
      $aliyun_appSecret = "fe8145295288eb6c54890ca914a838a8";
      $aliyun_host = "https://dm-51.data.aliyun.com";
      $aliyun_path = "/rest/160601/ocr/ocr_idcard.json";

      include_once 'aliyun-api-gateway/Util/aliyunAutoloader.php';

      $bodyContent = "{\"inputs\":[{\"image\":{\"dataType\":50,\"dataValue\":\"".(str_replace($result[1], '', $base64_image_content))."\"},\"configure\":{\"dataType\":50,\"dataValue\":\"{\\\"side\\\":\\\"face\\\"}\"}}]}";

      $request = new aliyunHttpRequest($aliyun_host, $aliyun_path, aliyunHttpMethod::POST, $aliyun_appKey, $aliyun_appSecret);

      //Stream的内容
      $bytes = array();
      $request->setHeader(aliyunHttpHeader::HTTP_HEADER_CONTENT_TYPE, aliyunContentType::CONTENT_TYPE_STREAM);
      $request->setHeader(aliyunHttpHeader::HTTP_HEADER_ACCEPT, aliyunContentType::CONTENT_TYPE_JSON);
      foreach($bytes as $byte) {
      				$bodyContent .= chr($byte);
      		}
      if (0 < strlen($bodyContent)) {
      	$request->setHeader(aliyunHttpHeader::HTTP_HEADER_CONTENT_MD5, base64_encode(md5($bodyContent, true)));
      	$request->setBodyStream($bodyContent);
      }

      $request->setSignHeader(aliyunSystemHeader::X_CA_TIMESTAMP);
      $response = aliyunHttpClient::execute($request);
      ob_start();
      print_r($response);
      $return  = ob_get_contents();
      //file_put_contents("IDC.txt",$return);
      ob_end_flush();
      ob_end_clean();
      $matches['idcard'] = str_replace('"num\":\"','',substr($return,strpos($return,'"num\"'),27));
      $str = str_replace('\\','',$str);
      preg_match_all('/":"(.*)",/isU',$str,$mat);
      $matches['name'] = $mat[1][3];
      $matches['birthday'] = $mat[1][1];
      $matches['nationality'] = $mat[1][4];
      $matches['sex'] = $mat[1][7];
      $matches['address'] = $mat[1][8];

    // }
      returnJson('200','onSucces',$matches);
    }
  }


    returnJson('500','服务端异常请联系管理员');

  }
  
		function http_post($url,$post_data,$time=60,$size){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			curl_setopt($ch, CURLOPT_TIMEOUT, $time);
			curl_setopt($ch, CURLOPT_INFILESIZE,$size);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$output = curl_exec($ch);
			curl_close($ch);
			return $output;
		}
    function namecard($base64)
    {
      $base64_image_content = urldecode(getgpc('img'));
      if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result))
      {
        $base64img = base64_decode(str_replace($result[1], '', $base64_image_content));

        file_put_contents("namecard_img.".$result[2],$base64img);
        $host = "https://dm-57.data.aliyun.com";
        $path = "/rest/160601/ocr/ocr_business_card.json";
        $method = "POST";
        $appcode = "60365c155f1643faaec1516df7eeeef1";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
        $querys = "";
        $bodys = "{\"inputs\":[{\"image\":{\"dataType\":50,\"dataValue\":\"".str_replace($result[1], '', $base64_image_content)."\"}}]}";
        $url = $host . $path;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
        $ret = json_decode(curl_exec($curl),true);
        //print_r($ret);
        if($ret['outputs'][0]['outputValue']['dataType']==50)
        {
          returnJson('200','onSuccess',json_decode($ret['outputs'][0]['outputValue']['dataValue'],true));

        }
        else
        {
          returnJson('404','onSuccess','请重试');

        }

      }
      else
      {
        returnJson('500','onFail');

      }

    }

}
?>
