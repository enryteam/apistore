<?php
defined('IN_PHPFRAME') or exit('No permission resources.');

pc_base::load_app_class('RestAction');

class index extends RestAction
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//header("Location:http://www.enry.cn/");exit;
		returnJson('200','Welcome to CN.ENRY.APISTORE!');
	}
	//升级开关
	public function updatecheck()
	{

		$v = "1.0";//最新版本号
		//下载地址 http://www.wwcode.net/s/hed7e
		if(getgpc("cv")<$v)
		{
			returnJson('200',getgpc("cv").$v,"http://www.wwcode.net/s/hed7e");
		}
		else
		{

			returnJson('201',getgpc("cv").'已是最新版本');
		}

	}

	//验证图形验证码
	public function codecheck()
  {
		$code = getgpc("checkcode");
		$redis = new Redis();
		$redis->connect('127.0.0.1',6379);
		$check = $redis->get($code);
		if(empty($check))
		{
			$check = $redis->get(strtoupper($code));
		}
		if($check == md5(strtoupper($code)))
		{
			$redis->set($code,'enry');
			returnJson('200', '验证码正确');
		}
		if($check != md5($code))
		{
			returnJson('500', '验证码有误'.$code."#".$check);

		}
		else
		{
			$redis->set($code,'enry');
			returnJson('200', '验证码正确');

		}
  }
	//获取图形验证码
	public function checkcode()
  {
      $srcstr = "1A2C3D4E5F6HK8L9MPRSUVWXWZ";
      mt_srand();
      $code = "";
      for ($i = 0; $i < 4; $i++) {
          $code .= $srcstr[mt_rand(0, 26)];
      }
			//$_SESSION["checkcode"] = md5($code);
			$redis = new Redis();
			$redis->connect('127.0.0.1',6379);
			$redis->set($code,md5($code));



      //验证码图片的宽度
      $width  = 40;
      //验证码图片的高度
      $height = 30;
      //声明需要创建的图层的图片格式
      @ header("Content-Type:image/png");
      //创建一个图层
      $im = imagecreate($width, $height);
      //背景色
      $back = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);
      //模糊点颜色
      $pix  = imagecolorallocate($im, rand(100,255), rand(100,255), rand(100,255));

      //字体色
      $font = imagecolorallocate($im, rand(1,50), rand(0,50), rand(0,30));
      //绘模糊作用的点
      mt_srand();
      for ($i = 0; $i < 80; $i++) {
          imagesetpixel($im, mt_rand(0, $width), mt_rand(0, $height), $pix);
      }
      //输出字符
      imagestring($im, 5, 3, 10, $code, $font);
      //输出矩形
      //imagerectangle($im, 0, 0, $width -1, $height -1, $font);
			//生成干扰线
			for ($i=0; $i<10; $i++) {
					$x1 = rand(1,$width-1);
					$y1 = rand(1,$height-1);
					$x2 = rand(1,$width-1);
					$y2 = rand(1,$height-1);
					imageline($im,$x1,$y1,$x2,$y2,$pix);
			}
      //输出图片
      imagepng($im);
      imagedestroy($im);
      //选择 Session

  }


}
