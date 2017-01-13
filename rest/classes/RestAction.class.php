<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
import('@.libs.classes.BaseAction');
pc_base::load_app_class('Http');

class RestAction extends BaseAction
{
	protected $userInfo=array();
	protected $visitFrom='';
	protected $http;

	public function __construct()
	{
		@session_start();

	}



}
