<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class im extends BaseAction
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
  //项目wlm
  public function wlm()
  {
    $opt = getgpc("type");
    $fromuid = intval(getgpc("sid"));
    $touid = intval(getgpc("touid"));
    $type = trim(getgpc("msgtype"));
    $msg = getgpc('msg');
    file_put_contents("R.txt",serialize($_REQUEST));
    $restModel = D("Rest");

    if($opt == "getinfo")
    {
      if($fromuid>0)
      {
        $res = $restModel->query("select * from wlm.`apistore_auth_center` where user_toid=".$touid." and user_id = ".$fromuid);

      if(count($res)>0)
      {
        //自动更新上线状态
        $restModel->querysql("update wlm.`apistore_auth_center` set online='online' where user_id = '".$fromuid."'");
        if(!empty($msg))
        {
          //写入聊天记录
          $sql = "insert into wlm.`apistore_im_record`(fromuid,message,msgtype,touid,createtime) values('".$fromuid."','".$msg."','".$type."','".$touid."','".time()."')";
          file_put_contents("Q.txt",$sql);
          $restModel->querysql($sql);
        }

      }
      else
      {
        //初始化auth用户令牌
        $restModel->querysql("insert into wlm.`apistore_auth_center`(channel,user_id,user_toid,created,online) values('wlm','".$fromuid."','".$touid."','".time()."','online')");

      }
      }
      echo json_encode(array("sid"=>$res[0]["user_id"],"online"=>$res[0]["online"]));
      exit;
    }
    //平台用户下线操作
    elseif($opt == "unline")
    {
      $restModel->querysql("update wlm.`apistore_auth_center` set  	online='offline' where user_id = '".$fromuid."'");

    }
    //平台用户是否在线
    elseif($opt == "online")
    {
      if($fromuid)
      {
      $ret = $restModel->query("select * from wlm.`apistore_auth_center` where user_id = '".$fromuid."'");
      returnJson('200','用户存在',$ret[0]['online']);

      }
      else
      {
        returnJson('403','用户不存在');

      }
    }

  }

  //项目tjsj
  public function tjsj()
  {
    $opt = getgpc("type");
    $fromuid = intval(getgpc("sid"));
    $touid = intval(getgpc("touid"));
    $type = trim(getgpc("msgtype"));
    $msg = getgpc('msg');

    $restModel = D("Rest");

    if($opt == "getinfo")
    {
      if($fromuid>0)
      {
        $res = $restModel->query("select * from tjsj.`apistore_auth_center` where  user_toid=".$touid." and user_id = ".$fromuid);
      }
      if(count($res)>0)
      {
        //自动更新上线状态
        $restModel->querysql("update tjsj.`apistore_auth_center` set online='online' where user_id = '".$fromuid."'");
        if(!empty($msg))
        {
        //写入聊天记录
        $restModel->querysql("insert into tjsj.`apistore_im_record`(fromuid,message,msgtype,touid,createtime) values('".$fromuid."','".$msg."','".$type."','".$touid."','".time()."')");
        }
      }
      else
      {
        //初始化auth用户令牌
        $restModel->querysql("insert into tjsj.`apistore_auth_center`(channel,user_id,user_toid,created,online) values('tjsj','".$fromuid."','".$touid."','".time()."','online')");

      }
      echo json_encode(array("sid"=>$res[0]["user_id"],"online"=>$res[0]["online"]));
      exit;
    }
    //平台用户下线操作
    elseif($opt == "unline")
    {
      $restModel->querysql("update tjsj.`apistore_auth_center` set  	online='offline' where user_id = '".$fromuid."'");

    }
    //平台用户是否在线
    elseif($opt == "online")
    {
      if($fromuid)
      {
      $ret = $restModel->query("select * from tjsj.`apistore_auth_center` where user_id = '".$fromuid."'");
      returnJson('200','用户存在',$ret[0]['online']);

      }
      else
      {
        returnJson('403','用户不存在');

      }
    }

  }
  //项目znjy
  public function znjy()
  {
    $opt = getgpc("type");
    $fromuid = intval(getgpc("sid"));
    $touid = intval(getgpc("touid"));
    $type = trim(getgpc('msgtype'));
    $msg = getgpc('msg');

    $restModel = D("Rest");

    if($opt == "getinfo")
    {
      if($fromuid>0)
      {
        $res = $restModel->query("select * from znjy.`apistore_auth_center` where user_toid=".$touid." and user_id = ".$fromuid);

      if(count($res)>0)
      {
        //自动更新上线状态
        $restModel->querysql("update znjy.`apistore_auth_center` set online='online' where user_id = '".$fromuid."'");
        if(!empty($msg))
        {
          //写入聊天记录
          $restModel->querysql("insert into znjy.`apistore_im_record`(fromuid,message,msgtype,touid,createtime) values('".$fromuid."','".$msg."','".$type."','".$touid."','".time()."')");
        }

      }
      else
      {
        //初始化auth用户令牌
        $restModel->querysql("insert into znjy.`apistore_auth_center`(channel,user_id,user_toid,created,online) values('znjy','".$fromuid."','".$touid."','".time()."','online')");

      }
      }
      echo json_encode(array("sid"=>$res[0]["user_id"],"online"=>$res[0]["online"]));
      exit;
    }
    //平台用户下线操作
    elseif($opt == "unline")
    {
      $restModel->querysql("update znjy.`apistore_auth_center` set  	online='offline' where user_id = '".$fromuid."'");

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
