<?php
pc_base::load_sys_class('BaseModel');

class OrderModel extends BaseModel
{

    public function getLists($filter, $page = 1, $page_size)
    {
        $where = '1';
        if (isset($filter['order_sn']) && $filter['order_sn'] != '') {
            $where .= " and a.order_sn like '%" . $filter['order_sn'] . "%'";
        }
        if (isset($filter['user_name']) && $filter['user_name'] != '') {
            $where .= " and b.user_name like '%" . $filter['user_name'] . "%'";
        }
        if (isset($filter['name']) && $filter['name'] != '') {
            $where .= " and b.name like '%" . $filter['name'] . "%'";
        }
        if (isset($filter['phone']) && $filter['phone'] != '') {
            $where .= " and a.phone like '%" . $filter['phone'] . "%'";
        }
        if (isset($filter['s_add_time']) && $filter['s_add_time'] != '') { // 注册开始时间
            $where .= " and a.add_time >= '" . strtotime($filter['s_add_time']) . "'";
        }
        if (isset($filter['e_add_time']) && $filter['e_add_time'] != '') { // 注册结束时间
            $where .= " and a.add_time <= '" . strtotime($filter['e_add_time']) . "'";
        }
        // 排序条件
        if (isset($filter['order']) && $filter['order'] != '') {
            $order = " ORDER BY a." . $filter['order'] . " DESC ";
        } else {
            $order = ' ORDER BY a.order_id DESC ';
        }
        $limit = ($page - 1) * $page_size . ',' . $page_size;
        $sql = "select a.*, b.user_name, b.name from sdmb_order a left join sdmb_user b on a.user_id = b.user_id where $where $order limit " . $limit;
        $rs = $this->query($sql);
        return $rs;
    }

    public function getCounts($filter)
    {
        $where = '1';
        if (isset($filter['order_id']) && $filter['order_id'] != '') {
            $where .= " and a.order_id like '%" . $filter['order_id'] . "%'";
        }
        if (isset($filter['user_name']) && $filter['user_name'] != '') {
            $where .= " and b.user_name like '%" . $filter['user_name'] . "%'";
        }
        if (isset($filter['name']) && $filter['name'] != '') {
            $where .= " and b.name like '%" . $filter['name'] . "%'";
        }
        if (isset($filter['phone']) && $filter['phone'] != '') {
            $where .= " and a.phone like '%" . $filter['phone'] . "%'";
        }
        if (isset($filter['s_add_time']) && $filter['s_add_time'] != '') { // 订单开始时间
            $where .= " and a.add_time >= '" . strtotime($filter['s_add_time']) . "'";
        }
        if (isset($filter['e_add_time']) && $filter['e_add_time'] != '') { // 订单结束时间
            $where .= " and a.add_time <= '" . strtotime($filter['e_add_time']) . "'";
        }
        $sql = "select count(1) as num from sdmb_order a left join sdmb_user b on a.user_id = b.user_id where $where";
        $rs = $this->query($sql);
        return $rs[0]['num'];
    }
}
