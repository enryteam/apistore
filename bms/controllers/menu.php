<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('AdminAction');

/**
 * 
 * 后台管理首页
 *
 */
class menu extends AdminAction
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$title='dash';
		$this->assign('title',$title);
		$this->display();
	}
}
