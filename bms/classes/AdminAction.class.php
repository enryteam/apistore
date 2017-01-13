<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
import('@.libs.classes.BaseAction');

class AdminAction extends BaseAction
{
	public function __construct()
	{
		if(!isset($_SESSION['uinfo']['userid']))
		{
			$this->error('请登录',pcUrl('index','login'));
		}
		
		$menu_list = $this->getMenu();
		$this->assign("menu_list",$menu_list);

		$site_name=D('Config')->getValue('site_name');
		$this->assign('site_name',$site_name);
		parent::__construct();
	}
	
	/**
	 * 获取菜单
	 */
	public function getMenu()
	{
		return D('AdminMenu')->getAllMenu();
	}
	
	public function upload($watermark_enable=0,$thumb_setting=array(),$is_ajax=false,$max_size=0)
	{
		$result=array(
			'flag'	=>false,
			'message'=>''
		);
		$upload_url = pc_base::load_config('system','upload_url');
		$upload_file_type='jpg|gif|png';
		
		if(!count($_FILES)) return false;
		foreach($_FILES as $key=>$row)
		{
			if($row['name']=='') continue;
			$Attachment = pc_base::load_sys_class('attachment');
			$rs=$Attachment->upload($key,$upload_file_type,$max_size,0,$thumb_setting,$watermark_enable);
			
			if($rs===false)
			{
				if(!$is_ajax)
					$this->error($Attachment->error());
				else
				{
					$result['message']=$Attachment->error();
					return $result;
				}
			}
			if(is_array($rs))
			{
				$_POST[$key]=array();
				foreach($rs as $k=>$val)
					$_POST[$key][$k]=$upload_url.$val;
			}
			else
				$_POST[$key]=$upload_url.$rs;
			/*	
			foreach($rs as $key1=>$val)
			{
			
				$info=M('attachment')->where(array('aid'=>$val))->find();
				if(count($rs)>1)
					$_POST[$key][$key1]=$upload_url.$Attachment->upload_dir.$info['filepath'];
				else
					$_POST[$key]=$upload_url.$Attachment->upload_dir.$info['filepath'];
			}
			*/
			$result['flag']=true;
		}
		return $result;
	}
}
