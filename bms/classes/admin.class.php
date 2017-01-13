<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
$session_storage = 'session_' . pc_base::load_config('system', 'session_storage');
pc_base::load_sys_class($session_storage);
pc_base::load_sys_class('controller');

/**
 * 后台管理公共基类，构造方法验证登陆状态 
 * @author oliver
 *
 */
class admin extends controller{

	public function __construct(){
	
		if(!isset($_SESSION['uinfo']['userid'])){
		
			$this->showmessage('请登录',pfUrl('null','index','login'),3000);
		}
		$c =  getgpc("c");
		$this->protectAction($c);
		$detail =  $this->getUserRoleMenu();
		$menu_list = $this->getMenu();
		$menu_list=$this->getMenusforDetail($menu_list,$detail);
		$this->assign("menu_list",$menu_list);
	}
	
	/**
	 * 获取菜单
	 */
	
	public function getMenu()
	{
		$uid = $_SESSION['uinfo']['userid'];
		$res = $this->excuteSql("select * from master_admin_role_setting where uid = '".$uid."' ");
		if($_SESSION['uinfo']['username'] == 'admin'){
			$result  =  $this->excuteSql("select * from master_module");
		}else{
			$result = json_decode($res['0']['detail'],true);
		}
		$c = getgpc('c');
		$arr = array();
		$e_arr = array();
		foreach ($result as $k => $v){
			$e_arr[] = $v['controller'];
		}
		array_push($e_arr,'menu');
		if(!in_array($c,$e_arr)){
			$this->showmessage("无权限访问");
		}
		foreach($result  as $key=>$list)
		{
			
			if($list['pid']==0)
			{
				$arr['father'][] =  $list;
				unset($result[$key]);
			}
		
			foreach($result as $ke=>$lis)
			{
				if($lis['pid'] ==$arr['father'][$key]['id'])
				{
					$arr['father'][$key]['child'][] = $lis  ;
					unset($result[$ke]);
				}
			}
		}
		foreach($arr['father'] as $key=>$r)
		{
			foreach($result as $r =>$res)
			{
			    if (isset($arr ['father'] [$key] ['child'])) {
    			    foreach ( $arr ['father'] [$key] ['child'] as $k => $row ) {
    		
    					if ($row ['id'] == $res ['pid']) {
    						$arr ['father'] [$key] ['child'] [$k] ['child_child'] [] = $res;
    					}
    				}
			    }
			}
		}
		return $arr;
	}
	/**
	 * 根据用户拥有的权限 获得菜单
	 * @param  array menu_list  所有菜单列表
	 * @param  array detail  用户拥有的权限列表
	 */
	public function getMenusforDetail($menu_list,$detail)
	{
		 foreach($menu_list['father'] as $key=>$lists)
		 {
		     if (isset($lists['child'])) {
    		     foreach($lists['child'] as $ke=>$list)
    		 	 {
    		 	 	foreach($detail as $d_key=>$deta)
    		 	 	{
    		 	 		 if($deta['c']==$list['controller'])
    		 	 		 {
    		 	 		 	   if($deta['flag']==0)
    		 	 		 	   {
    		 	 		 	   	   unset($menu_list['father'][$key]['child'][$ke]);
    		 	 		 	   }
    		 	 		 }
    		 	 	}
    		 	 }
		     }
		 }
		 return $menu_list;
	}
	
	
	public function getUserRoleMenu()
	{
		$result  =$this->getDetailByUid();
		$result  = json_decode($result[0]['detail'],true);
		return $result;
	}
	/**
	 * @param string  $sql  查询语句
	 * 执行查询语句
	 * @return array
	 */
	public function excuteSql($sql)
	{
		$admin_model = pc_base::load_model('admin_model');
		$result  = $admin_model->query($sql);
		$result = $admin_model->fetch_array($result);
		return $result;
	}
	/**
	 * @param string  $sql  查询语句
	 * 执行除查询语句外的语句
	 * @return array
	 */
	public function excuteOtherSql($sql)
	{
		$admin_model = pc_base::load_model('admin_model');
		$result  = $admin_model->query($sql);
		return $result;
	}
	/**
	 * 获得最后一次插入的id
	 */
	public function getId()
	{
		$admin_model = pc_base::load_model('admin_model');
		return $admin_model->insert_id();
		
	}
	
	
	/**
	 * 控制 用户的动作
	 * @param  string  a   url链接中的 action
	 * @param string  c  url 链接中的controller
	 */
	public function protectAction($c)
	{
		 $result  =  $this->getDetailByUid();
		 $result =json_decode($result[0]['detail'],true);
		 foreach($result  as $key=>$row)
		 {
		 	if($row['c']==$c)
		 	{
		 		if($row['flag']!=1)
		 		{
		 			$this->showmessage("您没有权限访问该模块","",3000);
		 		}
		 	}
		 }
		 
	}
	/**
	 * 根据用户id获取用户权限列表
	 */
	public function getDetailByUid()
	{
		$admin_model = pc_base::load_model('admin_model');
		
		$result  = $admin_model->query('select a.detail from master_admin_role_setting a where a.uid ='.$_SESSION['uinfo']['userid']);
		$result = $admin_model->fetch_array($result);
		return $result;
	}
    /**
     * 获取 用户 拥有的权限 列表
     * 显示控制
     */
	public function protectView($c){
		$result  = $this->getDetailByUid();
		$result  = json_decode($result[0]['detail'],true);
		$flag  = array("0"=>"add","1"=>"edit","2"=>"delete");
		foreach($result as $key=>$row)
		{
			foreach($flag as $fl)
			{   	
				 if($row['c'] == $c)
			        {
						if($row['tag']==$fl)
						{
							if($row['flag']=="1")
							{
								$data[$fl] = 1;
							}
							else
							{
								$data[$fl]= 0;
							}
						}
			    }
			}
		}
		return $data;
	}
	 
}