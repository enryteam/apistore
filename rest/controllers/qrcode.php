<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class qrcode extends BaseAction
 {
 	public function __construct()
 	{
 		parent::__construct();
 	}

 	public function index()
 	{
    returnJson('200','Welcome to 51daniu.cn');

 	}
  public function url2dwz()
  {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    $chars = array(
        "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
        "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
        "w", "x", "y", "z", "0", "1", "2",
        "3", "4", "5", "6", "7", "8", "9"
    );
    $charsLen = count($chars) - 1;
    shuffle($chars);
    $output = "";
    for ($i=0; $i<6; $i++)
    {
        $output .= $chars[mt_rand(0, $charsLen)];
    }
    $key = urlencode(getgpc('url'));
    if(!$redis->exists($key))
    {
      $value = 'http://'.$output.'.51daniu.cn';
      $redis->set($key,$value);
      $redis->set($value,$key);
    }
    else
    {
      $value = $redis->get($key);
    }
    returnJson('200','onSuccess',$value);

    // $return = file_get_contents('http://api.t.sina.com.cn/short_url/shorten.json?source=3271760578&url_long='.getgpc('url'));
    // $retarr = json_decode($return,true);
    // //var_dump($retarr);
    // returnJson('200','onSuccess',$retarr[0]['url_short']);


  }
  public function create()
  {
    if(file_exists("../phpframe/plugin/phpqrcode/qrlib.php"))
    {
      $QR_BASEDIR = '../phpframe/plugin/phpqrcode/';
      include $QR_BASEDIR."qrconst.php";
      include $QR_BASEDIR."qrconfig.php";
      include $QR_BASEDIR."qrtools.php";
      include $QR_BASEDIR."qrspec.php";
      include $QR_BASEDIR."qrimage.php";
      include $QR_BASEDIR."qrinput.php";
      include $QR_BASEDIR."qrbitstream.php";
      include $QR_BASEDIR."qrsplit.php";
      include $QR_BASEDIR."qrrscode.php";
      include $QR_BASEDIR."qrmask.php";
      include $QR_BASEDIR."qrencode.php";
      $value = getgpc("keyword"); //二维码内容
      $filename = "1.png";
      $errorCorrectionLevel = 'L';//容错级别
      $matrixPointSize = 6;//生成图片大小
      //生成二维码图片
      QRcode::png($value,$filename, $errorCorrectionLevel, $matrixPointSize, 2);
      returnJson('200','onSuccess',$filename);
    }
    else
    {
      returnJson('500','onFail');

    }

  }

}

?>
