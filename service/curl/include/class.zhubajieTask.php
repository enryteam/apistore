<?php
if(!class_exists('baseCore')){
	require_once(DIRROOT.'./include/class.basecore.php');
}
class zhubajieTask extends baseCore{

	private $login_username = MYNAME; //登陆用户名
	private $login_userpassword = MYPWD; //登陆用户密码
	private $login_url = 'http://www.zhubajie.com/task/user/login'; //登陆入口
	private $login_urlvars = ''; //登陆入口参数
	private $task_listurl = 'http://www.zhubajie.com/list_tasksall-0-1-170-0-0-0-0-1.html'; //最新任务列表网址
	private $task_sitetag_bid = '<input value="我要投标" class="bid_ico ico13 mr10" id="terder_button" type="button">';
	private $task_sitetag_done_bid = '<input value="编辑投标" class="bid_ico ico16 mr10 mt5" id="terder_button" type="button">';
	private $task_sitetag_apply = '<a href="javascript:void(0);" onclick="add_rest(\'task_sign\',408006)" class="yellow_button bid_ico ico21">任务报名</a>';
	private $task_sitetag_done_apply = 'href="javascript:void(0);">取消报名</a>';
	
	private $task_tid = '';//任务参数
	private $task_myabout = '专注 Discuz!X,uchome，discuz,supesite,ecshop,ecmall康盛产品二次开发QQ1467056255';
	private $task_myamount = '';
	private $task_myday = '';

	private $addbid_url = 'http://www.zhubajie.com/task/?mod=bid&com=handle'; //投标入口
	private $addbid_urlvars = ''; //投标入口参数

	private $addapply_url = 'http://www.zhubajie.com/task/?com=ajax'; //报名入口
	private $addapply_urlvars = ''; //报名入口参数

    function __construct()
    {
		$this->login_urlvars = 'username='.$this->login_username.'&userpass='.$this->login_userpassword.'&forward=&url=http%3A%2F%2Fwww.zhubajie.com%2F&code=b57190da0a0ef867120cc7a2101cbae7&login=';

    }
	function __destruct()
    {
		$this->login_url = NULL;
		$this->login_urlvars = NULL;
		$this->login_username = NULL;
		$this->login_userpassword = NULL;
		$this->task_listurl = NULL;
		$this->task_sitetag_apply = NULL;
		$this->task_sitetag_done_apply = NULL;
		$this->task_sitetag_bid = NULL;
		$this->task_sitetag_done_bid = NULL;
		$this->task_tid = NULL;
		$this->addbid_url = NULL;
		$this->addbid_urlvars = NULL;
		$this->addapply_url = NULL;
		$this->addapply_urlvars = NULL;

    }


	//获取最新任务
	private function getTaskList(&$tasklist)
	{
		parent::curl_get_url($this->task_listurl,$site_data);
		$s_s = '<table class="task_list">';
		$s_e = '<table border="0" cellspacing="0" cellpadding="0" style="background:#E9F7FF;width:100%;height:30px;">';
		preg_match('/'.$s_s.'(.*)'.$s_e.'/isU',$site_data, $arr);
		$str = $s_s.str_replace("href=\"/task/","href=\"http://www.zhubajie.com/task/",$arr[1]);
		$pat = '/<a(.*?)href="(.*?)"(.*?)>(.*?)<\/a>/i';
		preg_match_all($pat, $str, $m);
		foreach($m[2] as $key=>$val){
			$tasklist[$key][url] = $val;
		}
		foreach($m[4] as $key=>$val){
			$tasklist[$key][title] = $val;
		}
		if($tasklist){
			return true;
		}else{
			return false;
		}
	}
	//竞标任务
	private function bidTask(&$result)
	{
		$this->addbid_urlvars = '&t=6&tid='.$this->task_tid.'&myabout='.urlencode($this->task_myabout).'&myamount='.$this->task_myamount.'&myday='.$this->task_myday.'&bmid=';
		parent::curl_post_url($this->addbid_url, $data, $this->addbid_urlvars);
		//结果状态
		$j = json_decode($data);
		$result[posturi] = $this->addbid_url.$this->addbid_urlvars;
		$result[t] = $j->t;
		$result[msg] = $j->msg;
		$result[rurl] = $j->url;
		$result[redirect] = $j->redirect;

	}
	//报名投稿
	private function applyTask(&$result)
	{

		$this->addapply_urlvars = "&type=task_sign&id=".$this->task_tid."&tid=".$this->task_tid."";
		parent::curl_post_url($this->addapply_url, $data, $this->addapply_urlvars);
		//结果状态
		$j = json_decode($data);
		$result[posturi] = $this->addapply_url.$this->addapply_urlvars;
		$result[t] = $j->t;
		$result[msg] = $j->msg;
		$result[rurl] = $j->url;
		$result[redirect] = $j->redirect;

	}
	//批量参加任务
	public function joinTaskList()
	{

		parent::curl_post_vars($this->login_url, $this->login_urlvars);
		self::getTaskList($tasklist);

		foreach($tasklist as $key=>$val)
		{
			echo $this->task_tid = str_replace('http://www.zhubajie.com/task/iv/','',$val[url]);
			echo 'Run At'.date("YmdHis",time());
			echo '<br />';
			//获取前往url
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$val[url]);
			curl_setopt($ch,CURLOPT_HEADER, 1);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			$d = curl_exec($ch);
			preg_match('/Location:(.*)\r\n/isU',$d, $arr);
			if($arr)
			{
				$val[url] = 'http://www.zhubajie.com'.str_replace(" ","",$arr[1]);
			}
			parent::curl_post_url($val[url],$sitedata);
			//投标
			if(strpos($sitedata,$this->task_sitetag_bid))
			{
//				if(strpos($sitedata,$this->task_sitetag_done_bid))
//				{
//					$val[result] = 'success done';
//					parent::writetext('joinTask_Result',$val);
//					echo '<pre>';
//					print_r($val);
//					echo '</pre>';
//
//				}else{

					$this->task_myamount = 50;
					$this->task_myday = 2;

					self::bidTask($bTrnt);
					
					foreach($bTrnt as $k=>$v)
					{
						$val[$k] = $v;
					}
					parent::writetext('joinTask_Process',$val);
					echo '<pre>';
					print_r($val);
					echo '</pre>';

//				}

			}
			//报名
			if(strpos($sitedata,$this->task_sitetag_apply)){

//				if(strpos($sitedata,$this->task_sitetag_done_apply))
//				{
//					$val[result] = 'success done';
//					parent::writetext('joinTask_Result',$val);
//					echo '<pre>';
//					print_r($val);
//					echo '</pre>';
//				}else{
					self::applyTask($aTrnt);
					foreach($aTrnt as $k=>$v)
					{
						$val[$k] = $v;
					}
					parent::writetext('joinTask_Process',$val);
					echo '<pre>';
					print_r($val);
					echo '</pre>';
//				}

			}

		flush();

		}

	}


}
?>