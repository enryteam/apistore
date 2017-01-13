<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class mail extends BaseAction
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
  //maintis项目
  public function smtp()
  {

    require '../service/mail/class.phpmailer.php';
    $mail = new PHPMailer;
    $mail->Charset='UTF-8';
    $mail->SMTPDebug = 0;
    $mail->IsSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.exmail.qq.com';  // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'ac@enry.cn';                            // SMTP username
    $mail->Port = 465;
    $mail->Password = 'AdminChen5188';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
    $mail->From = 'ac@enry.cn';
    $pc = strtoupper(getgpc("pc"));
    if(!in_array($pc,array("ZBK","JJS","SMJD","XIUBA","EWB","ZNJY","GYDZ","YXX","SMJD")))
    {
      returnJson('403','pc not allowed');
    }
    if($pc=="JJS")
    {
      $mail->FromName = "积交所";
    }
    elseif($pc=="ZBK")
    {
      $mail->FromName = "众包客";
    }
    else
    {
      $mail->FromName = 'CN.ENRY.'.$pc;

    }
    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    $mail->IsHTML(true);                                  // Set email format to HTML
    $mail->Subject = urldecode(getgpc("subject"));
    //$mail->Subject = "=?utf-8?B?".base64_encode(urldecode(getgpc("subject")))."?=";
    $mail->Body    = urldecode(getgpc("body"));
    //$mail->Body = "=?utf-8?B?".base64_encode(urldecode(getgpc("body")))."?=";

    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->AddAddress(urldecode(getgpc("mailto")));
    if(!$mail->Send()) {

       returnJson('500','onFail',$mail->ErrorInfo);

    }
    else
    {
      returnJson('200','onSuccess');
    }


  }
  function imap(){
    set_time_limit(1000000);

    //以腾讯企业邮箱做了测试
    $mailServer="imap.189.cn"; //IMAP主机

    $mailLink="{{$mailServer}:143}INBOX" ; //imagp连接地址：不同主机地址不同

    $mailUser = '18061208098@189.cn'; //邮箱用户名

    $mailPass = 'adminchen'; //邮箱密码

    $mbox = imap_open($mailLink,$mailUser,$mailPass); //开启信箱imap_open

    echo $totalrows = imap_num_msg($mbox); //取得信件数
    $restModel = D("Rest");
    for ($i=1;$i<$totalrows;$i++){

        $headers = imap_fetchheader($mbox, $i); //获取信件标头

        $headArr = $this->matchMailHead($headers); //匹配信件标头
        //echo $headArr['from'];echo '<br>';
        if(1){

              echo $mailBody = imap_fetchbody($mbox, $i, 1); //获取信件正文
          		preg_match_all('/<div style="line-height:25px;">(.*?)<a  href="(.*?)" target=\'_blank\' >(.*?)<\/a>，最新匹配任务请您及时参与，任务详情如下：(.*?)<\/div>(.*?)<td height="25" align="left">(.*?)<\/td>(.*?)<tr><td height=\'25\' colspan=\'2\' align=\'left\'>联系方式：(.*?)&nbsp;&nbsp;&nbsp;<\/td><\/tr>/isU',$mailBody, $str);
          		//print_r($str);
          		// $title = iconv( "UTF-8", "gb2312//IGNORE" , $str[3][0]);
          		// $price = iconv( "UTF-8", "gb2312//IGNORE" , str_replace('尊敬的mf5413e4d35c9bd，','',$str[1][0]));
          		// $content = iconv( "UTF-8", "gb2312//IGNORE" , $str[4][0]);
          		// $type = iconv( "UTF-8", "gb2312//IGNORE" , $str[6][0]);
          		// $contact = iconv( "UTF-8", "gb2312//IGNORE" , $str[8][0]);
              $title = $str[3][0];
          		$price = str_replace('尊敬的mf5413e4d35c9bd，￥','',$str[1][0]);
          		$content = $str[4][0];
          		$type = $str[6][0];
          		$contact = $str[8][0];
              if(!empty($title)&&!empty($price)&&!empty($content)&&!empty($type)&&!empty($contact))
              {
                // $result = $restModel->query("select * from happ.`dede_archives` where typeid=62 and title ='".$title."'");
                // if(empty($result))
                // {
                  $res = $restModel->query("select * from happ.`dede_archives` order by id desc limit 1");
                  $time = time()+rand(0,36000);
                  $restModel->querySql("INSERT INTO happ.`dede_arctiny` (`arcrank`,`typeid`,`typeid2`,`channel`,`senddate`, `sortrank`, `mid`) VALUES ('0','62','0' , '21','".$time."', '".$time."', '105')");
                  $restModel->querySql("INSERT INTO happ.`dede_archives`(id,typeid,sortrank,flag,ismake,channel,arcrank,click,`money`,title,shorttitle,color,writer,source,litpic,pubdate,senddate,mid,description,keywords,mtype) VALUES ('".(1+$res[0]['id'])."','62','".$time."','','0','21','0','0','0','".$title."','','','EnryChan','','','".$time."','".$time."','105','','','0'); ");
                  $restModel->querySql("INSERT INTO happ.`dede_addon21`(aid,typeid,userip,redirecturl,templet,body,lxr,jiage,q,boody) Values('".(1+$res[0]['id'])."','62','183.206.174.28','','','' ,''  ,'".$price."'  ,'".$contact."'  ,'".strip_tags($content)."' )");
                  echo (1+$res[0]['id'])." Task Push Succ.<br>";
                //}

              }
            }

    }



  }
  /**
   *
   * 匹配提取信件头部信息
   * @param String $str
   */
  function matchMailHead($str){
      $headList = array();
      $headArr = array(
          'from',
          'to',
          'date',
          'subject'
      );

      foreach ($headArr as $key){
          if(preg_match('/'.$key.':(.*?)[\n\r]/is', $str,$m)){
              $match = trim($m[1]);
              $headList[$key] = $key=='date'?date('Y-m-d H:i:s',strtotime($match)):$match;
          }
      }
      return $headList;
  }


}
?>
