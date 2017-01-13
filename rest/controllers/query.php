<?php
 set_time_limit(0);
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');
 require 'querylist/vendor/autoload.php';
 use QL\QueryList;
 class query extends BaseAction
 {
 	public $path;
  public $area_id;
	public function __construct()
 	{
 		parent::__construct();
		$this->path = '../attms/upfile/'.date("Y").'/'.date("m").'/'.date("d").'/'.date("H").'/';
		mk_dir($this->path);
 	}

 	public function index()
 	{
     $restModel = D('Rest');
     /////////////////////////////////ewb//////////////////////////////////////////////////////////////
     $enryQuery = file_get_contents("http://www.ewabao.com/rest/querylist/enryQuery.txt?t=".time());
     $enryQuery = unserialize($enryQuery);
     echo count($enryQuery);
     echo "<br>";
     foreach ($enryQuery as $data)
     {
       foreach($data as $row)
       {

         if(!empty($row['name'])&&!empty($row['visit'][0])&&!empty($row['visit'][1]))
         {
          if($row['avatar']!='http://nimage.39.net/daoyi/images/pics/default_ys.gif')
           {
             $finfo = new finfo(FILEINFO_MIME_TYPE);
             $stream = file_get_contents($row['avatar']);
             $localSrc = $this->path.md5($row['avatar']).str_replace('image/','.',$finfo->buffer($stream));

             file_put_contents($localSrc,$stream);
             $row['avatar'] = str_replace('../attms/upfile/','http://cdn.51daniu.cn/upfile/',$localSrc);
           }
           else {
             $row['avatar'] = 'http://cdn.51daniu.cn/face/rryb_avatar.png';
           }
           $sql = "select * from `rryb`.`rryb_doctor` where hospital='".$row['visit'][0]."' and department='".$row['visit'][1]."' and name='".$row['name']."'";
           $result = $restModel->query($sql);

           if(empty($result))
           {
             $rand =  rand(10000,99999).rand(100000,999999);
             $sql = "INSERT INTO `rryb`.`rryb_doctor` (`uid`, `area`,`hospital`, `department`, `name`, `avatar`, `title0`, `title1`, `title2`, `good_at`, `experience`) VALUES(".$rand.", '".$row['area_id']."','".$row['visit'][0]."', '".$row['visit'][1]."', '".$row['name']."','".$row['avatar']."', '".$row['title'][0]."', '".$row['title'][1]."', '".$row['title'][2]."', '".$row['goodat']."', '".$row['experience']."')";
             $restModel->querySql($sql);
           }
           $sql = "select * from `rryb`.`rryb_department` where name='".$row['visit'][1]."'";
           $result = $restModel->query($sql);

           if(empty($result))
           {
              $restModel->querySql("INSERT INTO `rryb`.`rryb_department` (`id`, `fid`, `name`, `is_del`) VALUES (NULL, '0', '".$row['visit'][1]."', '0');");
           }
           $sql = "select * from `rryb`.`rryb_hospital` where name='".$row['visit'][0]."'";
           $result = $restModel->query($sql);

           if(empty($result))
           {
              $restModel->querySql("INSERT INTO `rryb`.`rryb_hospital` (`id`, `name`, `area_id`, `level`, `medical_insurance`, `type`, `introduction`, `phone1`, `phone2`, `addr`, `beds`, `is_del`) VALUES (NULL, '".$row['visit'][0]."', '".$row['area_id']."', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '0');");
           }
         }
       }
     }
     //file_get_contents("http://www.ewabao.com/rest/querylist/enry.php?t=".time());
     echo '<iframe src="http://www.ewabao.com/rest/querylist/enry.php?t='.time().'"></iframe>';

     ////////////////////////////////////////////////////////////////////////////////////////////////////
echo "CN.ENRY.EWB<hr>";
     /////////////////////////////////xiuba//////////////////////////////////////////////////////////////
     $enryQuery = file_get_contents("http://www.51xiuba.cn/rest/querylist/enryQuery.txt?t=".time());
     $enryQuery = unserialize($enryQuery);
     //echo "<pre>";
     echo count($enryQuery);
     echo "<br>";
     foreach ($enryQuery as $data)
     {
       foreach($data as $row)
       {

         if(!empty($row['name'])&&!empty($row['visit'][0])&&!empty($row['visit'][1]))
         {
          if($row['avatar']!='http://nimage.39.net/daoyi/images/pics/default_ys.gif')
           {
             $finfo = new finfo(FILEINFO_MIME_TYPE);
             $stream = file_get_contents($row['avatar']);
             $localSrc = $this->path.md5($row['avatar']).str_replace('image/','.',$finfo->buffer($stream));

             file_put_contents($localSrc,$stream);
             $row['avatar'] = str_replace('../attms/upfile/','http://cdn.51daniu.cn/upfile/',$localSrc);
           }
           else {
             $row['avatar'] = 'http://cdn.51daniu.cn/face/rryb_avatar.png';
           }
           $sql = "select * from `rryb`.`rryb_doctor` where hospital='".$row['visit'][0]."' and department='".$row['visit'][1]."' and name='".$row['name']."'";
           $result = $restModel->query($sql);

           if(empty($result))
           {
             $rand =  rand(10000,99999).rand(100000,999999);
             $sql = "INSERT INTO `rryb`.`rryb_doctor` (`uid`, `area`,`hospital`, `department`, `name`, `avatar`, `title0`, `title1`, `title2`, `good_at`, `experience`) VALUES(".$rand.", '".$row['area_id']."','".$row['visit'][0]."', '".$row['visit'][1]."', '".$row['name']."','".$row['avatar']."', '".$row['title'][0]."', '".$row['title'][1]."', '".$row['title'][2]."', '".$row['goodat']."', '".$row['experience']."')";
             $restModel->querySql($sql);
           }
           $sql = "select * from `rryb`.`rryb_department` where name='".$row['visit'][1]."'";
           $result = $restModel->query($sql);

           if(empty($result))
           {
              $restModel->querySql("INSERT INTO `rryb`.`rryb_department` (`id`, `fid`, `name`, `is_del`) VALUES (NULL, '0', '".$row['visit'][1]."', '0');");
           }
           $sql = "select * from `rryb`.`rryb_hospital` where name='".$row['visit'][0]."'";
           $result = $restModel->query($sql);

           if(empty($result))
           {
              $restModel->querySql("INSERT INTO `rryb`.`rryb_hospital` (`id`, `name`, `area_id`, `level`, `medical_insurance`, `type`, `introduction`, `phone1`, `phone2`, `addr`, `beds`, `is_del`) VALUES (NULL, '".$row['visit'][0]."', '".$row['area_id']."', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '0');");
           }

         }
       }
     }
     //file_get_contents("http://www.51xiuba.cn/rest/querylist/enry.php?t=".time());
     echo '<iframe src="http://www.51xiuba.cn/rest/querylist/enry.php?t='.time().'"></iframe>';
     ////////////////////////////////////////////////////////////////////////
     echo "CN.ENRY.XIUBA<hr>";
          /////////////////////////////////smjd//////////////////////////////////////////////////////////////
          $enryQuery = file_get_contents("http://124.67.69.111/rest/querylist/enryQuery.txt?t=".time());
          $enryQuery = unserialize($enryQuery);
          //echo "<pre>";
          echo count($enryQuery);
          echo "<br>";
          foreach ($enryQuery as $data)
          {
            foreach($data as $row)
            {

              if(!empty($row['name'])&&!empty($row['visit'][0])&&!empty($row['visit'][1]))
              {
               if($row['avatar']!='http://nimage.39.net/daoyi/images/pics/default_ys.gif')
                {
                  $finfo = new finfo(FILEINFO_MIME_TYPE);
                  $stream = file_get_contents($row['avatar']);
                  $localSrc = $this->path.md5($row['avatar']).str_replace('image/','.',$finfo->buffer($stream));

                  file_put_contents($localSrc,$stream);
                  $row['avatar'] = str_replace('../attms/upfile/','http://cdn.51daniu.cn/upfile/',$localSrc);
                }
                else {
                  $row['avatar'] = 'http://cdn.51daniu.cn/face/rryb_avatar.png';
                }
                $sql = "select * from `rryb`.`rryb_doctor` where hospital='".$row['visit'][0]."' and department='".$row['visit'][1]."' and name='".$row['name']."'";
                $result = $restModel->query($sql);

                if(empty($result))
                {
                  $rand =  rand(10000,99999).rand(100000,999999);
                  $sql = "INSERT INTO `rryb`.`rryb_doctor` (`uid`, `area`,`hospital`, `department`, `name`, `avatar`, `title0`, `title1`, `title2`, `good_at`, `experience`) VALUES(".$rand.", '".$row['area_id']."','".$row['visit'][0]."', '".$row['visit'][1]."', '".$row['name']."','".$row['avatar']."', '".$row['title'][0]."', '".$row['title'][1]."', '".$row['title'][2]."', '".$row['goodat']."', '".$row['experience']."')";
                  $restModel->querySql($sql);
                }
                $sql = "select * from `rryb`.`rryb_department` where name='".$row['visit'][1]."'";
                $result = $restModel->query($sql);

                if(empty($result))
                {
                   $restModel->querySql("INSERT INTO `rryb`.`rryb_department` (`id`, `fid`, `name`, `is_del`) VALUES (NULL, '0', '".$row['visit'][1]."', '0');");
                }
                $sql = "select * from `rryb`.`rryb_hospital` where name='".$row['visit'][0]."'";
                $result = $restModel->query($sql);

                if(empty($result))
                {
                   $restModel->querySql("INSERT INTO `rryb`.`rryb_hospital` (`id`, `name`, `area_id`, `level`, `medical_insurance`, `type`, `introduction`, `phone1`, `phone2`, `addr`, `beds`, `is_del`) VALUES (NULL, '".$row['visit'][0]."', '".$row['area_id']."', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '0');");
                }

              }
            }
          }
          //file_get_contents("http://www.51xiuba.cn/rest/querylist/enry.php?t=".time());
          echo '<iframe src="http://124.67.69.111/rest/querylist/enry.php?t='.time().'"></iframe>';
          ////////////////////////////////////////////////////////////////////////
          echo "CN.ENRY.SMJD<hr>";
               /////////////////////////////////znjy//////////////////////////////////////////////////////////////
               $enryQuery = file_get_contents("http://www.lwjiaoyu.com/rest/querylist/enryQuery.txt?t=".time());
               $enryQuery = unserialize($enryQuery);
               //echo "<pre>";
               echo count($enryQuery);
               echo "<br>";
               foreach ($enryQuery as $data)
               {
                 foreach($data as $row)
                 {

                   if(!empty($row['name'])&&!empty($row['visit'][0])&&!empty($row['visit'][1]))
                   {
                    if($row['avatar']!='http://nimage.39.net/daoyi/images/pics/default_ys.gif')
                     {
                       $finfo = new finfo(FILEINFO_MIME_TYPE);
                       $stream = file_get_contents($row['avatar']);
                       $localSrc = $this->path.md5($row['avatar']).str_replace('image/','.',$finfo->buffer($stream));

                       file_put_contents($localSrc,$stream);
                       $row['avatar'] = str_replace('../attms/upfile/','http://cdn.51daniu.cn/upfile/',$localSrc);
                     }
                     else {
                       $row['avatar'] = 'http://cdn.51daniu.cn/face/rryb_avatar.png';
                     }
                     $sql = "select * from `rryb`.`rryb_doctor` where hospital='".$row['visit'][0]."' and department='".$row['visit'][1]."' and name='".$row['name']."'";
                     $result = $restModel->query($sql);

                     if(empty($result))
                     {
                       $rand =  rand(10000,99999).rand(100000,999999);
                       $sql = "INSERT INTO `rryb`.`rryb_doctor` (`uid`, `area`,`hospital`, `department`, `name`, `avatar`, `title0`, `title1`, `title2`, `good_at`, `experience`) VALUES(".$rand.", '".$row['area_id']."','".$row['visit'][0]."', '".$row['visit'][1]."', '".$row['name']."','".$row['avatar']."', '".$row['title'][0]."', '".$row['title'][1]."', '".$row['title'][2]."', '".$row['goodat']."', '".$row['experience']."')";
                       $restModel->querySql($sql);
                     }
                     $sql = "select * from `rryb`.`rryb_department` where name='".$row['visit'][1]."'";
                     $result = $restModel->query($sql);

                     if(empty($result))
                     {
                        $restModel->querySql("INSERT INTO `rryb`.`rryb_department` (`id`, `fid`, `name`, `is_del`) VALUES (NULL, '0', '".$row['visit'][1]."', '0');");
                     }
                     $sql = "select * from `rryb`.`rryb_hospital` where name='".$row['visit'][0]."'";
                     $result = $restModel->query($sql);

                     if(empty($result))
                     {
                        $restModel->querySql("INSERT INTO `rryb`.`rryb_hospital` (`id`, `name`, `area_id`, `level`, `medical_insurance`, `type`, `introduction`, `phone1`, `phone2`, `addr`, `beds`, `is_del`) VALUES (NULL, '".$row['visit'][0]."', '".$row['area_id']."', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '0');");
                     }

                   }
                 }
               }
               //file_get_contents("http://www.51xiuba.cn/rest/querylist/enry.php?t=".time());
               echo '<iframe src="http://www.lwjiaoyu.com/rest/querylist/enry.php?t='.time().'"></iframe>';
               ////////////////////////////////////////////////////////////////////////
    echo "CN.ENRY.ZNJY<hr>";
    /////////////////////////////////znjy//////////////////////////////////////////////////////////////
    $enryQuery = file_get_contents("https://m.zhiletools.com/rest/querylist/enryQuery.txt?t=".time());
    $enryQuery = unserialize($enryQuery);
    //echo "<pre>";
    echo count($enryQuery);
    echo "<br>";
    foreach ($enryQuery as $data)
    {
      foreach($data as $row)
      {

        if(!empty($row['name'])&&!empty($row['visit'][0])&&!empty($row['visit'][1]))
        {
         if($row['avatar']!='http://nimage.39.net/daoyi/images/pics/default_ys.gif')
          {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $stream = file_get_contents($row['avatar']);
            $localSrc = $this->path.md5($row['avatar']).str_replace('image/','.',$finfo->buffer($stream));

            file_put_contents($localSrc,$stream);
            $row['avatar'] = str_replace('../attms/upfile/','http://cdn.51daniu.cn/upfile/',$localSrc);
          }
          else {
            $row['avatar'] = 'http://cdn.51daniu.cn/face/rryb_avatar.png';
          }
          $sql = "select * from `rryb`.`rryb_doctor` where hospital='".$row['visit'][0]."' and department='".$row['visit'][1]."' and name='".$row['name']."'";
          $result = $restModel->query($sql);

          if(empty($result))
          {
            $rand =  rand(10000,99999).rand(100000,999999);
            $sql = "INSERT INTO `rryb`.`rryb_doctor` (`uid`, `area`,`hospital`, `department`, `name`, `avatar`, `title0`, `title1`, `title2`, `good_at`, `experience`) VALUES(".$rand.", '".$row['area_id']."','".$row['visit'][0]."', '".$row['visit'][1]."', '".$row['name']."','".$row['avatar']."', '".$row['title'][0]."', '".$row['title'][1]."', '".$row['title'][2]."', '".$row['goodat']."', '".$row['experience']."')";
            $restModel->querySql($sql);
          }
          $sql = "select * from `rryb`.`rryb_department` where name='".$row['visit'][1]."'";
          $result = $restModel->query($sql);

          if(empty($result))
          {
             $restModel->querySql("INSERT INTO `rryb`.`rryb_department` (`id`, `fid`, `name`, `is_del`) VALUES (NULL, '0', '".$row['visit'][1]."', '0');");
          }
          $sql = "select * from `rryb`.`rryb_hospital` where name='".$row['visit'][0]."'";
          $result = $restModel->query($sql);

          if(empty($result))
          {
             $restModel->querySql("INSERT INTO `rryb`.`rryb_hospital` (`id`, `name`, `area_id`, `level`, `medical_insurance`, `type`, `introduction`, `phone1`, `phone2`, `addr`, `beds`, `is_del`) VALUES (NULL, '".$row['visit'][0]."', '".$row['area_id']."', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '0');");
          }

        }
      }
    }
    echo '<iframe src="https://m.zhiletools.com/rest/querylist/enry.php?t='.time().'"></iframe>';

    ////////////////////////////////////////////////////////////////////////
echo "CN.ENRY.GYDZ<hr>";
    $greatCities = $restModel->query("select area_id,area_pinyin from `rryb`.`rryb_area` where area_pinyin<>'' and area_pinyin<>'NULL'");
    //print_r($greatCities);
    file_put_contents('greatCities.txt',serialize($greatCities));
    // for($q=1;$q<=5;$q++)
    // {

    $rnd = rand(0,count($greatCities)-1);
    $this->area_id = $greatCities[$rnd]['area_id'];
    $city = $greatCities[$rnd]['area_pinyin'];//全国一、二线城市
    $p=rand(1,999);
    for($page=$p;$page<=$p+5;$page++)
    {

        $curl = 'http://yyk.39.net/'.$city.'/doctors/c_p'.$page.'/';

        $urls = QueryList::run('Request',[
                'target' => 'http://yyk.39.net/'.$city.'/doctors/c_p'.$page.'/',
                'referrer'=>'http://yyk.39.net/'.$city.'/',
                'method' => 'GET',
                'params' => ['t' => time()],
                'user_agent'=>'Mozilla/7.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20160101 Firefox/23.0',
                'cookiePath' => './cookie_net39.txt',
                'timeout' =>'60'
            ])->setQuery(['link' => ['div>a','href','',function($content){

                              //利用回调函数补全相对链接
                              $baseUrl = 'http://yyk.39.net/';
                              return $baseUrl.$content;
            }]],'.serach-left-list li')->getData(function($item){

                          return $item['link'];
        });

    //  echo "<pre>";
    //  print_r($urls);
    // exit;
    //多线程扩展
    QueryList::run('Multi',[
        'list' => $urls,
        'curl' => [
            'opt' => array(
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSL_VERIFYHOST => false,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_AUTOREFERER => true,
                    ),
            //设置线程数
            'maxThread' => 2,//根据对象服务器实际情况而定
            //设置最大尝试数
            'maxTry' => 3
        ],
        'success' => function($a){

            //采集规则
            $reg = array(
                //姓名
                'name' => array('dt>b','text'),
                //头衔
                'title' => array('dt>span','text','',function($content){
                    $variable = explode("\r\n",$content);
                    $array = array("","","");
                    foreach ($variable as $key => $value) {
                      $row = str_replace("	","",$value);

                      if(!empty($row))
                      {
                        if(strstr($row,'科室')) $array[0]=$row;
                        if(strstr($row,'医师')) $array[1]=$row;
                        if(strstr($row,'教授')) $array[2]=$row;
                      }

                    }

                    return $array;
                }),
                //出诊地点
                'visit' => array('dd>a','text','',function($content){
                  $variable = explode("\r\n",$content);
                  $array = array("","");
                  foreach ($variable as $key => $value) {
                    $row = str_replace("	","",$value);

                    if(!empty($row))
                    {
                      if(strstr($row,'医院')||strstr($row,'保健院')) $array[0]=$row;
                      if(strstr($row,'科')||strstr($row,'中心')) $array[1]=$row;
                    }

                  }
                  return $array;
                  }),
                  //擅长领域
                  'goodat' => array('.intro_more p','text','',function($content){
                    $content = str_replace('[关闭]','',str_replace("擅长领域：","",$content));
                    return $content;
                    }),
                  //执业经历
                  'experience' => array('dd>p','text','',function($content){
                    $content = str_replace('—&amp;md','',str_replace('...[详细介绍]','',$content));
                    return $content;
                    }),
                  'avatar' => array('.pic img','src','',function($content){
                    if($content!='http://nimage.39.net/daoyi/images/pics/default_ys.gif')
                      {
                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                        $stream = file_get_contents($content);
                        $localSrc = $this->path.md5($content).str_replace('image/','.',$finfo->buffer($stream));

                        file_put_contents($localSrc,$stream);
                        return str_replace('../attms/upfile/','http://cdn.51daniu.cn/upfile/',$localSrc);
                      }
                      else {
                        return 'http://cdn.51daniu.cn/face/rryb_avatar.png';
                      }


                  })
                );
            $rang = '.doc-detail';
            $body = mb_convert_encoding(str_replace('gbk','utf-8',$a['content']),'utf-8','GBK');

            $ql = QueryList::Query($body,$reg,$rang);
            $data = $ql->getData();
            var_dump($data);
            echo "<br>";
            $restModel = D('Rest');
            foreach($data as $row)
            {
              if(!empty($row['name'])&&!empty($row['visit'][0])&&!empty($row['visit'][1]))
              {

                $sql = "select * from `rryb`.`rryb_doctor` where hospital='".$row['visit'][0]."' and department='".$row['visit'][1]."' and name='".$row['name']."'";
                $result = $restModel->query($sql);

                if(empty($result))
                {
                  $rand =  rand(10000,99999).rand(100000,999999);
                  $sql = "INSERT INTO `rryb`.`rryb_doctor` (`uid`, `area`,`hospital`, `department`, `name`, `avatar`, `title0`, `title1`, `title2`, `good_at`, `experience`) VALUES(".$rand.", '".$this->area_id."','".$row['visit'][0]."', '".$row['visit'][1]."', '".$row['name']."','".$row['avatar']."', '".$row['title'][0]."', '".$row['title'][1]."', '".$row['title'][2]."', '".$row['goodat']."', '".$row['experience']."')";
                  $restModel->querySql($sql);
                }

              }
              $sql = "select * from `rryb`.`rryb_department` where name='".$row['visit'][1]."'";
              $result = $restModel->query($sql);

              if(empty($result))
              {
                 $restModel->querySql("INSERT INTO `rryb`.`rryb_department` (`id`, `fid`, `name`, `is_del`) VALUES (NULL, '0', '".$row['visit'][1]."', '0');");
              }
              $sql = "select * from `rryb`.`rryb_hospital` where name='".$row['visit'][0]."'";
              $result = $restModel->query($sql);

              if(empty($result))
              {
                 $restModel->querySql("INSERT INTO `rryb`.`rryb_hospital` (`id`, `name`, `area_id`, `level`, `medical_insurance`, `type`, `introduction`, `phone1`, `phone2`, `addr`, `beds`, `is_del`) VALUES (NULL, '".$row['visit'][0]."', '".$this->area_id."', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, '0');");
              }
            }

        }
    ]);

  }

 // }

    file_put_contents('pquery.txt',date("YmdHis"));
    returnJson('200','onSuccess','[pquery_net39_doctor] '.$curl);
    //*/5 * * * *  curl  http://apistore.51daniu.cn/rest/index.php?c=query&a=net39_doctor


 	}
  /**
  *外协
  **/
  public function max()
  {
    $do = getgpc("do");
    $da = urldecode($_GET["da"]);
    if($do=="read")
    {
      echo file_get_contents("querylist.txt");
      exit;
    }
    if($do=="write")
     {
       ///
    }
  }
  /*
   *批量采集演示
   *
  */
  public function demo()
  {
      //HTTP操作扩展
      $urls = QueryList::run('Request',[
              'target' => 'http://cms.querylist.cc/news/list_2.html',
              'referrer'=>'http://cms.querylist.cc',
              'method' => 'GET',
              'params' => ['var1' => 'testvalue', 'var2' => 'somevalue'],
              'user_agent'=>'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0',
              'cookiePath' => './cookie.txt',
              'timeout' =>'30'
          ])->setQuery(['link' => ['h2>a','href','',function($content){
          //利用回调函数补全相对链接
          $baseUrl = 'http://cms.querylist.cc';
          return $baseUrl.$content;
      }]],'.cate_list li')->getData(function($item){
          return $item['link'];
      });

      //多线程扩展
      QueryList::run('Multi',[
          'list' => $urls,
          'curl' => [
              'opt' => array(
                          CURLOPT_SSL_VERIFYPEER => false,
                          CURLOPT_SSL_VERIFYHOST => false,
                          CURLOPT_FOLLOWLOCATION => true,
                          CURLOPT_AUTOREFERER => true,
                      ),
              //设置线程数
              'maxThread' => 100,
              //设置最大尝试数
              'maxTry' => 3
          ],
          'success' => function($a){
              //采集规则
              $reg = array(
                  //采集文章标题
                  'title' => array('h1','text'),
                  //采集文章发布日期,这里用到了QueryList的过滤功能，过滤掉span标签和a标签
                  'date' => array('.pt_info','text','-span -a',function($content){
                      //用回调函数进一步过滤出日期
                      $arr = explode(' ',$content);
                      return $arr[0];
                  }),
                  //采集文章正文内容,利用过滤功能去掉文章中的超链接，但保留超链接的文字，并去掉版权、JS代码等无用信息
                  'content' => array('.post_content','html','a -.content_copyright -script',function($content){
                          //利用回调函数下载文章中的图片并替换图片路径为本地路径
                          //使用本例请确保当前目录下有image文件夹，并有写入权限
                          //由于QueryList是基于phpQuery的，所以可以随时随地使用phpQuery，当然在这里也可以使用正则或者其它方式达到同样的目的
                          $doc = phpQuery::newDocumentHTML($content);
                          $imgs = pq($doc)->find('img');
                          foreach ($imgs as $img) {
                              $src = pq($img)->attr('src');
                              $localSrc = $this->path.md5($src).'.jpg';
                              $stream = file_get_contents($src);
                              file_put_contents($localSrc,$stream);
                              pq($img)->attr('src',$localSrc);
                          }
                          return $doc->htmlOuter();
                  })
                  );
              $rang = '.content';
              $ql = QueryList::Query($a['content'],$reg,$rang);
              $data = $ql->getData();
              //打印结果，实际操作中这里应该做入数据库操作
              echo '<br>';
              echo count($data);

          }
      ]);

      returnJson('200','采集成功');



  }



}
?>
