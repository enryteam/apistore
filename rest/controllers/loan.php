<?
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class loan extends BaseAction
 {
 	public $path;
	public function __construct()
 	{
 		parent::__construct();
		$this->path = '../attms/loan/';
		//mk_dir($this->path);
 	}

 	public function index()
 	{
   		returnJson('200','Welcome to 51daniu.cn');

 	}

  public function small()
  {
    $files = scandir($this->path);
    $array = array();
    foreach ($files as $key => $value) {
      $ext = substr($value, strpos($value, ".")+1);
      if(filetype($this->path.$value)=='file')
      {
        $array[$key]['name'] = $value;
        $array[$key]['size'] = round(filesize($this->path.$value)*0.0001,2).'M';
        $array[$key]['time'] = date("Y-m-d H:i:s",filectime($this->path.$value));
        $array[$key]['type'] = $ext;
        $array[$key]['typeICO'] = 'http://cdn.51daniu.cn/'.$ext.'.png';
        $array[$key]['link'] = 'http://cdn.51daniu.cn/loan/'.$value;
        $array[$key]['downICO'] = 'http://cdn.51daniu.cn/down.png';

      }

    }

    returnJson('200','小贷口子',$array);

  }
  public function demo()
  {
    $files = scandir($this->path);
    $array = array();
    echo '<table width="600" border="0" cellspacing="0" cellpadding="5">';
    foreach ($files as $key => $value) {
      $ext = substr($value, strpos($value, ".")+1);
      if(!in_array($ext,array('doc','docx','ppt','pptx','pdf')))
      {
        $ext = 'pdf';
      }
      if(filetype($this->path.$value)=='file')
      {
        $array[$key]['name'] = $value;
        $array[$key]['size'] = round(filesize($this->path.$value)*0.0001,2).'M';
        $array[$key]['time'] = date("Y-m-d H:i:s",filectime($this->path.$value));
        $array[$key]['type'] = $ext;
        $array[$key]['typeICO'] = 'http://cdn.51daniu.cn/'.$ext.'.png';
        $array[$key]['link'] = 'http://cdn.51daniu.cn/loan/'.$value;
        $array[$key]['downICO'] = 'http://cdn.51daniu.cn/down.png';
        echo '<tr><td><img src="'.$array[$key]['typeICO'].'" title="'.$array[$key]['name'].'" /></td><td><font color=green>'.$array[$key]['name'].'</font><br />'.$array[$key]['size'].'<br />'.$array[$key]['time'].'</td><td><a href="'.$array[$key]['link'].'" target="_blank"><img title="点击下载 '.$array[$key]['name'].'" src="'.$array[$key]['downICO'].'" /></a></td></tr>';
      }

    }
    echo '</table>';

    exit;
  }


}
?>
