<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class sms extends BaseAction
 {
 	public $path;
	public function __construct()
 	{
 		parent::__construct();

 	}

 	public function index()
 	{
   		returnJson('200','Welcome to apistore.51daniu.cn');

 	}
  public function notice()
  {
      $pc = getgpc("pc");//渠道
      $orderid = getgpc("orderid");//订单号
      $phone = getgpc("phone");//手机号
      if($pc=="ewb")
      {
        $rst = file_get_contents("http://utf8.sms.webchinese.cn/?Uid=ewb001&Key=56269a12e67872343354&smsMob=".$phone."&smsText=%E6%9C%89%E6%96%B0%E8%AE%A2%E5%8D%95".$orderid."%E8%AF%B7%E5%8F%8A%E6%97%B6%E5%8F%91%E8%B4%A7");
        if($rst==1)
        {
          returnJson('200','onSuccess','发送成功');

        }
        else
        {
          returnJson('500','onFail','发送失败');
        }
      }

      returnJson('403','onFail','发送失败');

  }

  /*
    ***短信API下行服务接口
    ***
    * 发送模板短信
    * @param to 手机号码集合,用英文逗号分开
    * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
    * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
    */
  public function captcha()
  {
    $phone = getgpc("phone");
    $hackphone = array('15214054871','15261805187','13952417295','18021529420','18795804657','15250988638','15720603645','17737131279','13270811315');//enry
    $checkcode = getgpc("checkcode");

    if(empty($phone)||empty($checkcode)||in_array($phone,$hackphone))
    {
      returnJson('403','发送失败');
    }


    //同步用户
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
    $projectcode = getgpc("pc");///立项代码
    if(empty($projectcode))
    {
      $projectcode = 'zbk';
      //'118.178.123.219','139.196.140.194','124.67.69.98','49.65.105.174','221.229.254.75','221.231.138.40'
      if($IPaddress=="139.196.140.194")
      {
        $projectcode = "ewb";
      }
      if($IPaddress=="124.67.69.98")
      {
        $projectcode = "smjd";
      }
      if($IPaddress=="221.229.254.75")
      {
        $projectcode = "yxx";
      }
      if($IPaddress=="221.231.138.40")
      {
        $projectcode = "znjy";
      }

    }

    $restModel = D('Rest');
    $result  = $restModel->query('select * from zbk.portal_users where phone = "'.$phone.'"');
    //var_dump($result);exit;
    if(empty($result[0])){

      $sql = 'insert into zbk.portal_users (phone,create_time,last_time,last_ip,last_pc) values ("'.$phone.'", "'.time().'","'.time().'","'.$IPaddress.'","'.$projectcode.'")';
      $res = $restModel->query($sql);
    }
    else {
      $sql = 'update zbk.portal_users set last_time="'.time().'",last_ip="'.$IPaddress.'",last_pc="'.$projectcode.'" where phone="'.$phone.'"';
      $res = $restModel->query($sql);
    }
    $sql = 'select * from zbk.portal_users where last_ip = "118.178.123.219" and last_pc="zbk" and FROM_UNIXTIME(last_time,"%Y%m%d")="'.(date("Ymd")).'"';
    //file_put_contents("l.txt",$sql);
    $result  = $restModel->query($sql);
    if(count($result)>=20)
    {
      returnJson('403','发送超限');
    }
    //有效时间限制
    $redis = new Redis();//初始化
    $redis->connect('127.0.0.1',6379);//连接
    $sms_last = $redis->get($phone);//取
    //file_put_contents('CAP.txt',time().'<'.$sms_last.'+'.(60*5));
    if(!empty($sms_last)&&(time()<$sms_last+60*5))
    {
      returnJson('403','验证码5分钟内有效，请勿重复发送');
    }
    else
    {
      $redis->set($phone,time());
    }
    // //黑名单机制 apistore_sms_badno

    // $result  = $restModel->query('select * from apistore.apistore_sms_badno where phone = "'.$phone.'" ');
    // // if($phone=='13275578879')
    // // {
    // //   file_put_contents('Sq.txt','select * from apistore.apistore_sms_badno where phone = "'.$phone.'" and ctime>="'.(time()-3600*24*5).'" and status=1 and ctime<="'.time().'"');
    // // }
    // if($result[0])
    // {
    //   $result  = $restModel->query('select count(1) as cnt from apistore.apistore_sms_badno where phone = "'.$phone.'" and ctime>="'.(time()-3600*24*1).'" and status=1 and ctime<="'.time().'"');
    //
    //   if($result[0]['cnt']>9)
    //   {
    //     //$result  = $restModel->querySql('update apistore.apistore_sms_badno set ctime="'.time().'",times=times+1,status=2 where phone = "'.$phone.'"');
    //     returnJson('403','发送频繁发送失败');
    //   }
    //   else
    //   {
    //     //$result  = $restModel->querySql('update apistore.apistore_sms_badno set ctime="'.time().'", times=times+1 where phone = "'.$phone.'"');
    //     $result  = $restModel->querySql('insert into apistore.apistore_sms_badno(phone,times,status,ctime) values("'.$phone.'","1","1","'.time().'")');
    //
    //   }
    //
    // }
    // else
    // {
    //   $result  = $restModel->querySql('insert into apistore.apistore_sms_badno(phone,times,status,ctime) values("'.$phone.'","1","1","'.time().'")');
    //   //file_put_contents('Ss.txt','insert into apistore.apistore_sms_badno(phone,times,status,ctime) values("'.$phone.'","1","1","'.time().'")');
    // }

    // //发送渠道轮询
    // $rand = rand(1,3);//公共渠道


    // if(!in_array($projectcode,array('zbk','ewb','smjd','wlm','tjsj','znjy','gydz')))
    // {
    //   $projectcode = 'zbk';
    // }
    // //=========渠道定制======================
    // if($projectcode=='smjd')//smjd专属渠道
    // {
    //   $rand = 4;
    // }
    // if($projectcode=='tjsj')//smjd专属渠道
    // {
    //   $rand = 5;
    // }
    // if($projectcode=='ewb')//ewb专属渠道
    // {
    //   $rand = 6;
    // }
    // if($projectcode=='gydz')//gydz专属渠道
    // {
    //   $rand = 7;
    // }
    // //=========商务挂起=======================
    // if($rand==2||$rand==3)//暂时挂起融联渠道#2、华为渠道#3
    // {
    //   $rand = 1;
    // }

    if($projectcode=='ewb')
    {
      $sendUrl = 'http://utf8.sms.webchinese.cn/?Uid=ewb001&Key=56269a12e67872343354&smsMob='.$phone.'&smsText='.urlencode("您的验证码为".$checkcode); //短信接口的URL
      $content =  file_get_contents($sendUrl);
      if($content==1){

          returnJson('200','发送成功',$rand);

      }else{
          //返回内容异常，以下可根据业务逻辑自行修改
          returnJson('500','发送失败Error'.$rand);
      }

    }
    elseif($projectcode=='gydz')
    {
      $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
      $smsConf = array(
        'key'   => '2085d0ff201fe895f39f3dc9d73ba46a',
        'mobile'    => $phone,
        'tpl_id'    => '21960',
        'tpl_value' =>'#code#='.$checkcode
      );
      $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
      if($content){
          $result = json_decode($content,true);
          $error_code = $result['error_code'];
          if($error_code == 0){
              //状态为0，说明短信发送成功

              returnJson('200','发送成功',$rand);
          }else{
              //状态非0，说明失败
              $msg = $result['reason'];
              returnJson('500','发送失败Error'.$rand);
          }
      }else{
          //返回内容异常，以下可根据业务逻辑自行修改
          returnJson('500','发送失败Error'.$rand);
      }

    }
    elseif($projectcode=='tjsj')
    {
      $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
      $smsConf = array(
        'key'   => '2698c83b1edbea2ef5351b960b876b94',
        'mobile'    => $phone,
        'tpl_id'    => '14687',
        'tpl_value' =>'#code#='.$checkcode
      );
      $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
      if($content){
          $result = json_decode($content,true);
          $error_code = $result['error_code'];
          if($error_code == 0){
              //状态为0，说明短信发送成功

              returnJson('200','发送成功',$rand);
          }else{
              //状态非0，说明失败
              $msg = $result['reason'];
              returnJson('500','发送失败Error'.$rand);
          }
      }else{
          //返回内容异常，以下可根据业务逻辑自行修改
          returnJson('500','发送失败Error'.$rand);
      }

    }
    elseif($projectcode=='smjd')
    {

      $url = 'http://115.231.73.234:7602/sms.aspx?action=send&userid=514&account=eedswanweihy6&password=ww458562&mobile='.$phone.'&content='.urlencode('【实名寄递】您的验证码为'.$checkcode).'&sendTime=&extno=';
      $httpInfo = array();
      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
      curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
      curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
      curl_setopt( $ch , CURLOPT_URL , $url);
      $response = curl_exec( $ch );
      //file_put_contents('smjd.txt',$response);
      $s_s = '<message>';
      $s_e = '<\/message>';
      preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$response, $ret);
      if($ret[1]=='ok')
      {
        returnJson('200','发送成功',$rand);

      }
      else
      {
        returnJson('403','发送失败Error'.$rand);

      }
    }
    else//阿里云短信&&聚合数据 双通道
    {
      global $alismsClient,$alismsRequest;
      $alismsRequest->setSignName("众包客");/*签名名称*/

      $alismsRequest->setTemplateCode("SMS_25640536");/*模板code*/

      $alismsRequest->setRecNum($phone);/*目标手机号*/

      $alismsRequest->setParamString("{\"no\":\"".$checkcode."\"}");/*模板变量，数字一定要转换为字符串*/
//file_put_contents("a.".date("YmdH").".txt","\r\n".$phone,FILE_APPEND);
      try {

          $alismsClient->getAcsResponse($alismsRequest);

          returnJson('200','发送成功','');
      }
      catch (ClientException  $e) {
          print_r($e->getErrorCode());
          print_r($e->getErrorMessage());
          returnJson('500','发送失败Error'.$projectcode);
      }
      catch (ServerException  $e) {
          print_r($e->getErrorCode());
          print_r($e->getErrorMessage());
          returnJson('500','发送失败Error'.$projectcode);
      }
        // $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        // $smsConf = array(
        //   'key'   => '0152bb4cbf14268914175c10c862da2b',
        //   'mobile'    => $phone,
        //   'tpl_id'    => '5176',
        //   'tpl_value' =>'#code#='.$checkcode
        // );
        // $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
        // if($content){
        //     $result = json_decode($content,true);
        //     $error_code = $result['error_code'];
        //     if($error_code == 0){
        //         //状态为0，说明短信发送成功
        //         returnJson('200','发送成功',$rand);
        //     }else{
        //         // $host = "http://sms.market.alicloudapi.com";
        //         // $path = "/singleSendSms";
        //         // $method = "GET";
        //         // $appcode = "60365c155f1643faaec1516df7eeeef1";
        //         // $headers = array();
        //         // array_push($headers, "Authorization:APPCODE " . $appcode);
        //         // $querys = "ParamString=%E6%82%A8%E7%9A%84%E9%AA%8C%E8%AF%81%E7%A0%81%E4%B8%BA%24%7B".$checkcode."%7D&RecNum=".$phone."&SignName=%E4%BC%97%E5%8C%85%E5%AE%A2&TemplateCode=SMS_25505056";
        //         // $bodys = "";
        //         // $url = $host . $path . "?" . $querys;
        //         //
        //         // $curl = curl_init();
        //         // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        //         // curl_setopt($curl, CURLOPT_URL, $url);
        //         // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //         // curl_setopt($curl, CURLOPT_FAILONERROR, false);
        //         // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //         // curl_setopt($curl, CURLOPT_HEADER, true);
        //         // if (1 == strpos("$".$host, "https://"))
        //         // {
        //         //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //         //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        //         // }
        //         // $return = curl_exec($curl);
        //         // if(strpos($return,'"success":true')>0)
        //         // {
        //         //   returnJson('200','发送成功',$rand);
        //         //
        //         // }
        //
        //         //状态非0，说明失败
        //         $msg = $result['reason'];
        //         returnJson('500','发送失败Error'.$msg.$rand);
        //     }
        // }else{
        //     //返回内容异常，以下可根据业务逻辑自行修改
        //     returnJson('500','发送失败Error'.$rand);
        // }





    }

  }
  static function juhecurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
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

}

class SMSREST {
	private $AccountSid;
	private $AccountToken;
	private $AppId;
	private $ServerIP;
	private $ServerPort;
	private $SoftVersion;
	private $Batch;  //时间戳
	private $BodyType = "xml";//包体格式，可填值：json 、xml
	private $enabeLog = true; //日志开关。可填值：true、
	private $Filename="./log.txt"; //日志文件
	private $Handle;
	function __construct($ServerIP,$ServerPort,$SoftVersion)
	{
		$this->Batch = date("YmdHis");
		$this->ServerIP = $ServerIP;
		$this->ServerPort = $ServerPort;
		$this->SoftVersion = $SoftVersion;
    $this->Handle = fopen($this->Filename, 'a');
	}

   /**
    * 设置主帐号
    *
    * @param AccountSid 主帐号
    * @param AccountToken 主帐号Token
    */
    function setAccount($AccountSid,$AccountToken){
      $this->AccountSid = $AccountSid;
      $this->AccountToken = $AccountToken;
    }


   /**
    * 设置应用ID
    *
    * @param AppId 应用ID
    */
    function setAppId($AppId){
       $this->AppId = $AppId;
    }

   /**
    * 打印日志
    *
    * @param log 日志内容
    */
    function showlog($log){
      if($this->enabeLog){
         fwrite($this->Handle,$log."\n");
      }
    }

    /**
     * 发起HTTPS请求
     */
     function curl_post($url,$data,$header,$post=1)
     {
       //初始化curl
       $ch = curl_init();
       //参数设置
       $res= curl_setopt ($ch, CURLOPT_URL,$url);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt ($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_POST, $post);
       if($post)
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
       $result = curl_exec ($ch);
       //连接失败
       if($result == FALSE){
          if($this->BodyType=='json'){
             $result = "{\"statusCode\":\"172001\",\"statusMsg\":\"网络错误\"}";
          } else {
             $result = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?><Response><statusCode>172001</statusCode><statusMsg>网络错误</statusMsg></Response>";
          }
       }

       curl_close($ch);
       return $result;
     }



   /**
    * 发送模板短信
    * @param to 短信接收彿手机号码集合,用英文逗号分开
    * @param datas 内容数据
    * @param $tempId 模板Id
    */
    function sendTemplateSMS($to,$datas,$tempId)
    {
        //主帐号鉴权信息验证，对必选参数进行判空。
        $auth=$this->accAuth();

        if($auth!=""){
            return $auth;
        }
        // 拼接请求包体
        if($this->BodyType=="json"){
           $data="";
           for($i=0;$i<count($datas);$i++){
              $data = $data. "'".$datas[$i]."',";
           }
           $body= "{'to':'$to','templateId':'$tempId','appId':'$this->AppId','datas':[".$data."]}";
        }else{
           $data="";
           for($i=0;$i<count($datas);$i++){
              $data = $data. "<data>".$datas[$i]."</data>";
           }
           $body="<TemplateSMS>
                    <to>$to</to>
                    <appId>$this->AppId</appId>
                    <templateId>$tempId</templateId>
                    <datas>".$data."</datas>
                  </TemplateSMS>";
        }
    //    $this->showlog("request body = ".$body);
        // 大写的sig参数
        $sig =  strtoupper(md5($this->AccountSid . $this->AccountToken . $this->Batch));
        // 生成请求URL
        $url="https://$this->ServerIP:$this->ServerPort/$this->SoftVersion/Accounts/$this->AccountSid/SMS/TemplateSMS?sig=$sig";
        //$this->showlog("request url = ".$url);
        // 生成授权：主帐户Id + 英文冒号 + 时间戳。
        $authen = base64_encode($this->AccountSid . ":" . $this->Batch);
        // 生成包头
        $header = array("Accept:application/$this->BodyType","Content-Type:application/$this->BodyType;charset=utf-8","Authorization:$authen");
        // 发送请求
        $result = $this->curl_post($url,$body,$header);
      //  $this->showlog("response body = ".$result);


        if($this->BodyType=="json"){//JSON格式
           $datas=json_decode($result);
        }else{ //xml格式
           $datas = simplexml_load_string(trim($result," \t\n\r"));
        }

      //  if($datas == FALSE){
//            $datas = new stdClass();
//            $datas->statusCode = '172003';
//            $datas->statusMsg = '返回包体错误';
//        }
        //重新装填数据
        if($datas->statusCode==0){
         if($this->BodyType=="json"){
            $datas->TemplateSMS =$datas->templateSMS;
            unset($datas->templateSMS);
          }
        }

        return $datas;
    }

  /**
    * 主帐号鉴权
    */
   function accAuth()
   {
       if($this->ServerIP==""){
            $data = new stdClass();
            $data->statusCode = '172004';
            $data->statusMsg = 'IP为空';
          return $data;
        }
        if($this->ServerPort<=0){
            $data = new stdClass();
            $data->statusCode = '172005';
            $data->statusMsg = '端口错误（小于等于0）';
          return $data;
        }
        if($this->SoftVersion==""){
            $data = new stdClass();
            $data->statusCode = '172013';
            $data->statusMsg = '版本号为空';
          return $data;
        }
        if($this->AccountSid==""){
            $data = new stdClass();
            $data->statusCode = '172006';
            $data->statusMsg = '主帐号为空';
          return $data;
        }
        if($this->AccountToken==""){
            $data = new stdClass();
            $data->statusCode = '172007';
            $data->statusMsg = '主帐号令牌为空';
          return $data;
        }
        if($this->AppId==""){
            $data = new stdClass();
            $data->statusCode = '172012';
            $data->statusMsg = '应用ID为空';
          return $data;
        }
   }
}
?>
