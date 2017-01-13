<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_sys_class('BaseAction');

class index extends BaseAction
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->jump(pcUrl('index','login'));
	}

	public function login()
	{
		if(isPost())
		{
			$code = trim(getgpc("checkcode"));
			$username  = trim(getgpc("username"));
			$password = trim(getgpc("password"));

			if(empty($code)||empty($username)||empty($password))
			{
				$this->error("用户名 密码 或验证码 均不能为空",pcUrl("index","login"));
			}

			if(strtolower($_SESSION['code'])!=strtolower($code))
			{
				$this->error("验证码错误",pcUrl("index","login"));
			}

			$adminModel=D('Admin');
			$result=$adminModel->login($username,$password);
			if(!$result['flag'])
				$this->error($result['message']);
			else
				$this->jump(pcUrl('menu','index'));
		}
		
		pc_base::load_sys_class('form');
		$site_name=D('Config')->getValue('site_name');
		$this->assign('site_name',$site_name);
		$this->display();
	}

	public function logout()
	{
		D('Admin')->logout();
		$this->jump(pcUrl('index','login'));
	}

	/**
	 * 获取验证码
	 */
	public function checkcode()
	{
		$checkcode = pc_base::load_sys_class('checkcode');
		$checkcode->doimage();
		$_SESSION['code'] = $checkcode->get_code();
	}

	//刷新缓存
	public function flush()
	{
		$cache = pc_base::load_sys_class('cache_file');
		$flag=$cache->flush();
		if($flag)
			$this->success('清除成功');
		else
			$this->error('清除失败');
	}
}
