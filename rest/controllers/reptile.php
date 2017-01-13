<?
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class reptile extends BaseAction
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

  public function wx()
  {
    $url = urldecode(getgpc("url"));
    //$url = 'http%3A%2F%2Fmp.weixin.qq.com%2Fs%3F__biz%3DMzA5NTQ2NjUzMA%3D%3D%26mid%3D207136729%26idx%3D1%26sn%3Da82af7b7ba0bee9a7017b607dc7e5d4b%26scene%3D5%23rd';
    //$url = 'http://mp.weixin.qq.com/s?__biz=MzA5NTQ2NjUzMA==&mid=207136729&idx=1&sn=a82af7b7ba0bee9a7017b607dc7e5d4b&scene=5#rd';

    //var_dump(urlencode($url));
    $site_data = str_replace('data-src="http://','data-src="http://read.html5.qq.com/image?src=forum&q=5&r=0&imgflag=7&imageUrl=http://',$this->docurl($url));
    //var_dump($content);
    $s_s = '<h2 class="rich_media_title" id="activity-name">';
		$s_e = '<\/h2>';
		preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr_title);
    //var_dump($arr_title);
    $s_s = '<div class="rich_media_content " id="js_content">';
		$s_e = '<\/div>';
		preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr_body);

    //var_dump($arr_body);

  	if($site_data){
  		$result = json_decode($content,true);

  			returnJson('200','onSuccess',array('wx_title'=>$arr_title[1],'wx_body'=>$arr_body[1]));

  	}else{
  		//返回内容异常，以下可根据业务逻辑自行修改
  		returnJson('500','onFail');
  	}

  }
	/**
	 * 请求接口返回内容
	 * @param  string $url [请求的URL地址]
	 * @param  string $params [请求的参数]
	 * @param  int $ipost [是否采用POST形式]
	 * @return  string
	 */
	function docurl($url){
		$httpInfo = array();
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );

	  curl_setopt( $ch , CURLOPT_URL , $url);

		$response = curl_exec( $ch );
		if ($response === FALSE) {
			//echo "cURL Error: " . curl_error($ch);
			return false;
		}
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		return $response;
	}

}
?>
