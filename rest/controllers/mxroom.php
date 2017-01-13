<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class mxroom extends BaseAction
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
    $channel = getgpc("pc");
    if(in_array($channel,array('jjs','zbk')))
    {

      $roomport = intval(getgpc("tradeid"));
      if(empty($roomport))
      {
        returnJson('500','创建失败');

      }
      if(strlen($roomport)>3)
      {
        returnJson('500','创建失败','L3');
      }
      $nodecode = file_get_contents("../service/mx/server_jjs_release_1997088.js");
      $nodefile = "../service/mx/server_".$channel."_release_18".$roomport.".js";
      if(!file_exists($nodefile))
      {


        //$restModel = D("Rest");
        // $result = $restModel->query('select * from znjy.apistore_auth_room where isfounder=1 and user_id='.$userid);
        // if($result)
        // {
        //   returnJson('500','不能重复创建');
        // }
        // $sql = "insert into znjy.`apistore_auth_room` (channel, `user_id`, `room_port`, `created`, `online`, `isfounder`) values('".$channel."', ".$userid.", ".$roomport.", '".time()."', 'online', 1)";
        // if($restModel->querySql($sql))
        // {
          file_put_contents($nodefile,str_replace('&g_code=18','&g_code=',str_replace("1997088",'18'.$roomport,$nodecode)));

          exec("chmod -R 777 ".str_replace("../service/mx","/htdocs/clound/apistore.51daniu.cn/service/mx",$nodefile));

          exec("node ".str_replace("../service/im","/htdocs/clound/apistore.51daniu.cn/service/mx",$nodefile)." >/dev/null  &");//php非阻塞 by enry
          //returnJson('200','创建成功',array('RoomCode'=>$roomport,'RoomChannel'=>$channel));

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
      $nodecode = file_get_contents("../service/mx/server_jjs_release_2997088.js");
      $nodefile = "../service/mx/server_".$channel."_release_28".$roomport.".js";
      if(!file_exists($nodefile))
      {
        if(empty($roomport))
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
          file_put_contents($nodefile,str_replace('&g_code=28','&g_code=',str_replace("2997088",'28'.$roomport,$nodecode)));

          exec("chmod -R 777 ".str_replace("../service/mx","/htdocs/clound/apistore.51daniu.cn/service/mx",$nodefile));

          exec("node ".str_replace("../service/im","/htdocs/clound/apistore.51daniu.cn/service/mx",$nodefile)." >/dev/null  &");//php非阻塞 by enry
          //returnJson('200','创建成功',array('RoomCode'=>$roomport,'RoomChannel'=>$channel));

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
      $nodecode = file_get_contents("../service/mx/server_jjs_release_3997088.js");
      $nodefile = "../service/mx/server_".$channel."_release_38".$roomport.".js";
      if(!file_exists($nodefile))
      {
        if(empty($roomport))
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
          file_put_contents($nodefile,str_replace('&g_code=38','&g_code=',str_replace("3997088",'38'.$roomport,$nodecode)));

          exec("chmod -R 777 ".str_replace("../service/mx","/htdocs/clound/apistore.51daniu.cn/service/mx",$nodefile));

          exec("node ".str_replace("../service/im","/htdocs/clound/apistore.51daniu.cn/service/mx",$nodefile)." >/dev/null  &");//php非阻塞 by enry
          //returnJson('200','创建成功',array('RoomCode'=>$roomport,'RoomChannel'=>$channel));

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
      returnJson('200','创建成功',array('RoomID'=>$roomport,'RoomPC'=>$channel));


    }
    else
    {
      returnJson('500','创建失败');
    }
  }


}
?>
