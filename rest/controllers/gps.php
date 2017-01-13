<?
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class gps extends BaseAction
 {
 	public function __construct()
 	{
 		parent::__construct();
 	}

 	public function index()
 	{
    returnJson('200','Welcome to 51daniu.cn');

 	}

    /*
     * 网页内容获取方法
    */
    public function getcontent($url)
    {
        if (function_exists("file_get_contents")) {
            $file_contents = file_get_contents($url);
        } else {
            $ch      = curl_init();
            $timeout = 300;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }
    /*
     *
    */
    public function gps2address()
    {
        //gps=32.1684599207371,118.70308012530512
        $bdMapApi = 'http://api.map.baidu.com/geocoder/v2/?ak=3U5oUDdBi7i7FjEzHUOqpaa1K9HrY4Ew&callback=renderReverse&output=json&pois=1&location='.getgpc("gps");
        $s_s = ',"formatted_address":"';
        $s_e = '","business":"';
        preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$this->getcontent($bdMapApi), $ret);
        // echo $ret = $this->getcontent($bdMapApi);
        // exit;
        returnJson('200','OnSuccess',$ret[1]);

    }
    /*
     *
    */
    public function address2gps()
    {
        // $bdMapApi = 'http://api.map.baidu.com/geocoder/v2/?output=json&ak=3U5oUDdBi7i7FjEzHUOqpaa1K9HrY4Ew&callback=showLocation&address='.getgpc("address");
        // $s_s = '"result":{"location":';
        // $s_e = ',"precise":1,"';
        // preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$this->getcontent($bdMapApi), $ret);
        // // echo $ret = $this->getcontent($bdMapApi);
        // // exit;
        //
        // returnJson('200','OnSuccess',$ret[1]);

        $bdMapApi = 'http://api.map.baidu.com/geocoder?output=json&address='.getgpc("address");
        $s_s = 'lng":';
        $s_e = ',';
        preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$this->getcontent($bdMapApi), $ret);
        $lng = $ret[1];
        $s_s = 'lat":';
        $s_e = '\n';
        preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$this->getcontent($bdMapApi), $ret);
        $lat = $ret[1];
        // echo $ret = $this->getcontent($bdMapApi);
        // var_dump($ret);
        // exit;

        returnJson('200','OnSuccess',array('lng'=>$lng,'lat'=>$lat));

    }

    public function phone2city()
    {
        $Api = 'http://life.tenpay.com/cgi-bin/mobile/MobileQueryAttribution.cgi?chgmobile='.getgpc("phone");
        $body = $this->getcontent($Api);
        $charset = mb_detect_encoding($body,array('UTF-8','GBK','GB2312'));
         $charset = strtolower($charset);
         if('cp936' == $charset){
             $charset='GBK';
         }
         if("utf-8" != $charset){
             $body = iconv($charset,"UTF-8//IGNORE",$body);
         }
        $s_s = '<city>';
        $s_e = '<\/city>';
        preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$body, $city);
        $s_s = '<province>';
        $s_e = '<\/province>';
        preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$body, $province);



        // echo $ret = $this->getcontent($bdMapApi);
        // exit;
        returnJson('200','OnSuccess',$province[1]." ".$city[1]);

    }

    /*
     * gps格式经纬度转百度经纬度 换算接口
    */
    public function gps2bdmap()
    {

      $xy = file_get_contents('http://api.map.baidu.com/ag/coord/convert?from=0&to=4&x='.getgpc("xx").'&y='.getgpc("yy"));
      //{"error":0,"x":"MTE4LjczNzY5MDE2MTM=","y":"MzIuMjA3MzE4OTM5MTQ3"}
       $x_bs64 = base64_decode(substr($xy,strlen('{"error":0,"x":"'),strpos($xy,'","y":"')-strlen('{"error":0,"x":"')));
       $y_bs64 = base64_decode(substr($xy,strpos($xy,'","y":"')+strlen('","y":"'),-strlen('"}"')+1));
      returnJson('200','gps转百度地图经纬度',array('xx'=>$x_bs64,'yy'=>$y_bs64));
    }
}
?>
