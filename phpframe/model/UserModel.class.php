<?php
pc_base::load_sys_class('BaseModel');

class UserModel extends BaseModel
{
	public function getLists($filter, $page=1, $page_size) {
	    $where = '1';
	    if (isset($filter['user_name']) && $filter['user_name'] != '') {
	    	$where .= " and a.user_name like '%".$filter['user_name']."%'";
	    }
	    if (isset($filter['phone']) && $filter['phone'] != '') {
	        $where .= " and a.phone like '%".$filter['phone']."%'";
	    }
	    if (isset($filter['name']) && $filter['name'] != '') {
	        $where .= " and a.name like '%".$filter['name']."%'";
	    }
	    if (isset($filter['s_reg_time']) && $filter['s_reg_time'] != '') { // 注册开始时间
	        $where .= " and a.reg_time >= '" . strtotime($filter['s_reg_time']) . "'";
	    }
	    if (isset($filter['e_reg_time']) && $filter['e_reg_time'] != '') { // 注册结束时间
	        $where .= " and a.reg_time <= '" . strtotime($filter['e_reg_time']) . "'";
	    }
	    // 排序条件
	    if (isset($filter['order']) && $filter['order'] != '') {
	        $order = " ORDER BY a." . $filter['order'] . " DESC ";
	    } else {
	        $order = ' ORDER BY a.user_id DESC ';
	    }
	    $limit = ($page - 1) * $page_size . ',' . $page_size;
	    $sql = "
	        select * from sdmb_user a where $where $order limit " . $limit;
	    $rs = $this->query($sql);
	    return $rs;
	}
	
	
	public function getCounts($filter) {
	    $where = '1';
	    if (isset($filter['user_name']) && $filter['user_name'] != '') {
	        $where .= " and a.user_name like '%".$filter['user_name']."%'";
	    }
	    if (isset($filter['phone']) && $filter['phone'] != '') {
	        $where .= " and a.phone like '%".$filter['phone']."%'";
	    }
	    if (isset($filter['name']) && $filter['name'] != '') {
	        $where .= " and a.name like '%".$filter['name']."%'";
	    }
	    $sql = "
	        select count(1) as num from sdmb_user a where $where 
	        ";
	    $rs = $this->query($sql);
	    return $rs[0]['num'];
	}
}
