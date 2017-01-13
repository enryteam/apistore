<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class imroom extends BaseAction
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
  public function make()
  {
    $channel = getgpc("channel");
    if(in_array($channel,array('znjy','zbk')))
    {

      $userid = getgpc("userid");
      $roomport = rand(17001,17999);
      $nodecode = file_get_contents("../service/im/release_znjy_room.js");
      $nodefile = "../service/im/release_".$channel."_room_".$roomport.".js";
      if(!file_exists($nodefile))
      {
        if(empty($userid))
        {
          returnJson('500','创建失败');

        }
        //$restModel = D("Rest");
        // $result = $restModel->query('select * from znjy.apistore_auth_room where isfounder=1 and user_id='.$userid);
        // if($result)
        // {
        //   returnJson('500','不能重复创建');
        // }
        // $sql = "insert into znjy.`apistore_auth_room` (channel, `user_id`, `room_port`, `created`, `online`, `isfounder`) values('".$channel."', ".$userid.", ".$roomport.", '".time()."', 'online', 1)";
        // if($restModel->querySql($sql))
        // {
          file_put_contents($nodefile,str_replace("17001",$roomport,$nodecode));

          exec("chmod -R 777 ".str_replace("../service/im","/htdocs/clound/apistore.51daniu.cn/service/im",$nodefile));

          exec("node ".str_replace("../service/im","/htdocs/clound/apistore.51daniu.cn/service/im",$nodefile)." >/dev/null  &");//php非阻塞 by enry
          returnJson('200','创建成功',array('RoomID'=>$roomport,'RoomFounder'=>$userid,'RoomChannel'=>$channel));

        // }
        // else
        // {
        //   returnJson('500','创建失败');
        //
        // }
      }
      else
      {
        returnJson('500','创建失败');

      }


    }
    else
    {
      returnJson('500','创建失败');
    }
  }
  //项目znjy
  public function znjy()
  {
    returnJson('403','无权操作');//by enry at 161213

    $opt = getgpc("type");
    $fromuid = intval(getgpc("sid"));
    $roomport = intval(getgpc("port"));
    $type = getgpc('msgtype');
    $msg = getgpc('msg');

    $restModel = D("Rest");

    if($opt == "getinfo")
    {
      if($fromuid>0)
      {
        $res = $restModel->query("select * from znjy.`apistore_auth_room` where room_port = ".$roomport." and user_id = ".$fromuid);

        if(count($res)>0)
        {
          //自动更新上线状态
          $restModel->querysql("update znjy.`apistore_auth_room` set online='online' where user_id = '".$fromuid."'");
          if(!empty($msg))
          {
            //写入聊天记录
            $restModel->querysql("insert into znjy.`apistore_imroom_record`(fromuid,message,msgtype,roomport,createtime) values('".$fromuid."','".$msg."','".$type."','".$roomport."','".time()."')");
          }

        }
        else
        {
          //初始化auth用户令牌

          $restModel->querysql("insert into znjy.`apistore_auth_room`(channel,user_id,room_port,created,online) values('znjy','".$fromuid."','".$roomport."','".time()."','online')");

        }
      }
      echo json_encode(array("sid"=>$res[0]["user_id"],"online"=>$res[0]["online"]));
      exit;
    }
    //平台用户下线操作
    elseif($opt == "unline")
    {
      $restModel->querysql("update znjy.`apistore_auth_room` set  	online='offline' where user_id = '".$fromuid."'");

    }
    //平台用户是否在线
    elseif($opt == "online")
    {
      if($fromuid)
      {
      $ret = $restModel->query("select * from znjy.`apistore_auth_center` where user_id = '".$fromuid."'");
      returnJson('200','用户存在',$ret[0]['online']);

      }
      else
      {
        returnJson('403','用户不存在');

      }
    }

  }

}
?>
