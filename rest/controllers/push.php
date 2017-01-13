<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_sys_class('BaseAction');

class push extends BaseAction
{
	public function __construct()
 	{
 		parent::__construct();

 	}

 	public function index()
 	{
   		returnJson('200','Welcome to apistore.51daniu.cn');

 	}

	public function send()
	{
    $pc = getgpc('pc');
    $sendno = time();
    if($pc == 'tjsj')
    {
      //(必填)待发送的应用程序(appKey)
  		$appkeys = '6ada0c4d01c1544d1186c3b9';

  		//(必填)API MasterSecret
  		$masterSecret = 'f722974bc8c2cf68677e62ec';
    }
		elseif($pc == 'yxx')
		{
			//(必填)待发送的应用程序(appKey)
  		$appkeys = 'ef807f7924afe4b2ebfeab1f';

  		//(必填)API MasterSecret
  		$masterSecret = 'a5567697117b38a13b33ba0b';

		}
    else
    {
      returnJson('403','参数非法');

    }
		//(必填)调用地址
		$url = 'http://api.jpush.cn:8800/v2/push';



		//(必填)接收者类型。1、指定的 IMEI。此时必须指定 appKeys。2、指定的 tag。3、指定的 alias。4、 对指定 appkey 的所有用户推送消息 5指定发送  。
		$receiver_type = 5;

		//(选填)发送范围值，与 receiver_type相对应。 1、IMEI只支持一个 2、tag 支持多个，使用 "," 间隔。 3、alias 支持多个，使用 "," 间隔。 4、不需要填
		$receiver_value = getgpc('pushid');

		//(必填)发送消息的类型，1、通知，2、自定义消息（只支持android）
		$msg_type = 1;

		//(必填)发送消息的内容。
		$msg_content = '';

		//(必填)目标用户终端手机的平台类型，如： android, ios 多个请使用逗号分隔。
		$platform = 'android,ios';

		//(选填)从消息推送时起，保存离线的时长。秒为单位。最多支持10天（864000秒）。
		// 0 表示该消息不保存离线。即：用户在线马上发出，当前不在线用户将不会收到此消息。
		//此参数不设置则表示默认，默认为保存1天的离线消息（86400秒）。
		$time_to_live = 86400;

		//生成验证串
		$verification_code = md5($sendno . $receiver_type . $receiver_value . $masterSecret);

		//消息内容格式化
		$content                 = array();
		$content['n_builder_id'] = 0; //（可选）1-1000的数值，不填则默认为 0，使用 极光Push SDK 的默认通知样式。只有 Android 支持这个参数
		$content['n_title']      = '通知消息'; //（可选）通知标题。不填则默认使用该应用的名称。只有 Android支持这个参考。
		$content['n_content']    = getgpc('msg'); //（必填）通知内容。
		$content['n_extras']     = ''; //（可选）通知附加参数。客户端可取得全部内容。

		//附加参数
		$additionalParameters                = array();
		// $additionalParameters['article_id']  = $data['article_id'];
		// $additionalParameters['from_where']  = $data['article_fromWhere'];
		// $additionalParameters['displayTime'] = $data['article_displayTime'];

		$content['n_extras'] = $additionalParameters;

		$msg_content = json_encode($content);

		//组装请求参数
		$param = '';
		$param .= "&sendno={$sendno}";
		$param .= "&app_key={$appkeys}";
		$param .= "&receiver_type={$receiver_type}";
		$param .= "&receiver_value={$receiver_value}";
		$param .= "&verification_code={$verification_code}";
		$param .= "&msg_type={$msg_type}";
		$param .= "&msg_content={$msg_content}";
		$param .= "&platform={$platform}";

		//发送请求
		$pushResult = $this->request_post($url, $param);

		if($pushResult === false)
		{
			return false;
		}

		$pushResult = json_decode($pushResult, true);
    //var_dump($pushResult);
		$message = array();
		switch(intval($pushResult['errcode']))
		{
			case 0:
				$message['msg'] = '消息推送成功';
				break;
			case 10:
				$message['msg'] = '系统内部错误';
				break;
			case 1001:
				$message['msg'] = '只支持 HTTP Post 方法，不支持 Get 方法';
				break;
			case 1002:
				$message['msg'] = '缺少了必须的参数';
				break;
			case 1003:
				$message['msg'] = '参数值不合法';
				break;
			case 1004:
				$message['msg'] = '验证失败';
				break;
			case 1005:
				$message['msg'] = '消息体太大';
				break;
			case 1007:
				$message['msg'] = 'receiver_value 参数 非法';
				break;
			case 1008:
				$message['msg'] = 'appkey参数非法';
				break;
			case 1010:
				$message['msg'] = 'msg_content 不合法';
				break;
			case 1011:
				$message['msg'] = '没有满足条件的推送目标';
				break;
			case 1012:
				$message['msg'] = 'iOS 不支持推送自定义消息。只有 Android 支持推送自定义消息';
				break;
			default:
				break;
		}

    returnJson('200','onSuccess',$message);

	}
  static function request_post($url = '', $param = '')
	{
		if(empty($url) || empty($param))
		{
			return false;
		}

		$postUrl  = $url;
		$curlPost = $param;
		$ch       = curl_init(); //初始化curl
		curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0); //设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch); //运行curl
		curl_close($ch);

		return $data;
	}
}
?>
