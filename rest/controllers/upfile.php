<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class upfile extends BaseAction
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
  public function attms()
  {
    $file = getgpc("attmsurl");
    $power = '<footer>Powered by:';
    $power1 = '<a href="http://www.yozodcs.com">永中DCS</a>&nbsp;&nbsp;&nbsp;Email:';
    $power2 = '<a href="mailto:dcs@yozosoft.com">dcs@yozosoft.com</a>';
    $power3 = '</footer>';
    if(strpos($file,'.ppt')>0)
    {
      echo str_replace($power3,'',str_replace($power2,'',str_replace($power1,'',str_replace($power,'',str_replace('<img src="','<img src="http://139.196.234.4:8080/dcsUserCenter/preview/',str_replace('永中云转换','蒽凯文档云转换 Powered by ENRY.CN',str_replace('"url":  "','"url":  "http://139.196.234.4:8080/dcsUserCenter/preview/',str_replace('href="','href="http://139.196.234.4:8080/dcsUserCenter/preview/',str_replace('script src="','script src="http://139.196.234.4:8080/dcsUserCenter/preview/',file_get_contents('http://139.196.234.4:8080/dcsUserCenter/checkUrl.do?k=19585833&url='.getgpc("attmsurl")))))))))));
    }
    else
    {

      echo str_replace($power3,'',str_replace($power2,'',str_replace($power1,'',str_replace($power,'',str_replace('class="navbar','style="display:none;" class="navbar',str_replace('永中云转换','蒽凯文档云转换 Powered by ENRY.CN',str_replace('href="./','href="http://139.196.234.4:8080/dcsUserCenter/preview/',str_replace('src="./','src="http://139.196.234.4:8080/dcsUserCenter/preview/',file_get_contents('http://139.196.234.4:8080/dcsUserCenter/checkUrl.do?k=19585833&url='.getgpc("attmsurl"))))))))));

    }
    exit;
  }
  /*
   * 上传图片并返回
   * img:base64
  */
  public function img()
  {

  	$base64_image_content = urldecode(getgpc('img'));
  	/* Create new image object */

    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){

      $type = $result[2];
      $new_file = $this->path."img_".time().".{$type}";
      $new_thumb_file = str_replace('img_','thumb_img_',$new_file);
      if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){

        $this->img2thumb($new_file, $new_thumb_file);
        returnJson('200','onSuccess',str_replace("../attms/upfile/","http://cdn.51daniu.cn/upfile/",$new_file));
      }
  	  else
  	  {
        returnJson('500','写入失败');
  	  }
    }
    else
    {
      returnJson('500','读取文件失败');
    }


  }
  //word pdf ppt附件上传
  public function exfiles()
  {
returnJson('403','即将开放');
    $base64_image_content = urldecode(getgpc('img'));
    /* Create new image object */

    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){

      $type = $result[2];
      $new_file = $this->path."img_".time().".{$type}";
      $new_thumb_file = str_replace('img_','thumb_img_',$new_file);
      if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){

        $this->img2thumb($new_file, $new_thumb_file);
        returnJson('200','onSuccess',str_replace("../attms/upfile/","http://cdn.51daniu.cn/upfile/",$new_file));
      }
      else
      {
        returnJson('500','写入失败');
      }
    }
    else
    {
      returnJson('500','读取文件失败');
    }


  }
  /*
   * 上传音频并返回
   * audio:file
  */
	public function audio()
	{

		$type = ".".substr($_FILES["file"]['name'], strrpos($_FILES["file"]['name'], '.')+1);

    file_put_contents("A.txt",$type);
		if(!in_array($type,array('.m4a','.amr','.mp3'.'.wma','.wav','.avi','.o-filename')))
		{

			returnJsonp('500',"格式错误");
		}


			$data=$_FILES["file"]["tmp_name"];
			$upload_root= pc_base::load_config('system','upload_path');
			$file_name= date('Ymdhis').rand(10000, 99999).str_replace(".o-filename",".jpg",$type);//o-filename ios拍照

			$flag = move_uploaded_file($_FILES["file"]["tmp_name"],$this->path.$file_name);


			if(!$flag)
			{
					returnJsonp('403',"上传失败");
			}

			if($type=='.amr')
			{
				exec('ffmpeg -i '.$this->path.$file_name.' '.str_replace(".amr",".wav",$this->path.$file_name));
				$full_path=str_replace(".amr",".wav",$this->path.$file_name);

			}
      elseif($type=='.m4a')
      {
        exec('ffmpeg -i '.$this->path.$file_name.' '.str_replace(".m4a",".wav",$this->path.$file_name));
				$full_path=str_replace(".m4a",".wav",$this->path.$file_name);
      }
			else
			{
				$full_path=$this->path.$file_name;
			}


      returnJson('200','onSuccess',str_replace("../attms/upfile/","http://cdn.51daniu.cn/upfile/",$full_path));


		}


static function img2thumb($src_img, $dst_img, $width = 120, $height = 120, $cut = 1, $proportion = 0)
{
    if(!is_file($src_img))
    {
        return false;
    }
    $ot = pathinfo($dst_img, PATHINFO_EXTENSION);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);

    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;

    /**
     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
     */
    if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
    {
        $proportion = 1;
    }
    if($width> $src_w)
    {
        $dst_w = $width = $src_w;
    }
    if($height> $src_h)
    {
        $dst_h = $height = $src_h;
    }

    if(!$width && !$height && !$proportion)
    {
        return false;
    }
    if(!$proportion)
    {
        if($cut == 0)
        {
            if($dst_w && $dst_h)
            {
                if($dst_w/$src_w> $dst_h/$src_h)
                {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                }
                else
                {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            }
            else if($dst_w xor $dst_h)
            {
                if($dst_w && !$dst_h)  //有宽无高
                {
                    $propor = $dst_w / $src_w;
                    $height = $dst_h  = $src_h * $propor;
                }
                else if(!$dst_w && $dst_h)  //有高无宽
                {
                    $propor = $dst_h / $src_h;
                    $width  = $dst_w = $src_w * $propor;
                }
            }
        }
        else
        {
            if(!$dst_h)  //裁剪时无高
            {
                $height = $dst_h = $dst_w;
            }
            if(!$dst_w)  //裁剪时无宽
            {
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int)round($src_w * $propor);
            $dst_h = (int)round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    }
    else
    {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width  = $dst_w = $src_w * $proportion;
    }

    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);

    if(function_exists('imagecopyresampled'))
    {
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    else
    {
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}



}
?>
