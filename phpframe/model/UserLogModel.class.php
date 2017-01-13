<?php
pc_base::load_sys_class('BaseModel');

class UserLogModel extends BaseModel
{

    public function getLists($filter, $page = 1, $page_size)
    {
        $where = '1';
        if (isset($filter['user_name']) && $filter['user_name'] != '') {
            $where .= " and a.user_name like '%" . $filter['user_name'] . "%'";
        }
        if (isset($filter['phone']) && $filter['phone'] != '') {
            $where .= " and a.phone like '%" . $filter['phone'] . "%'";
        }
        if (isset($filter['name']) && $filter['name'] != '') {
            $where .= " and a.name like '%" . $filter['name'] . "%'";
        }
        if (isset($filter['type']) && $filter['type'] != '') {
            $where .= " and b.type = " . $filter['type'];
        }
        $order = ' ORDER BY b.log_id DESC ';
        $limit = ($page - 1) * $page_size . ',' . $page_size;
        $sql = "
            select 
                b.log_id, b.type, b.order_id, b.type, b.old_money, b.money, b.remark, b.time,
                a.user_id, a.user_name, a.phone, a.name
            from 
                sdmb_user_log b 
            left join sdmb_user a 
            on b.user_id = a.user_id 
            where $where $order limit " . $limit;
        $rs = $this->query($sql);
        return $rs;
    }

    public function getCounts($filter)
    {
        $where = '1';
        if (isset($filter['user_name']) && $filter['user_name'] != '') {
            $where .= " and a.user_name like '%" . $filter['user_name'] . "%'";
        }
        if (isset($filter['phone']) && $filter['phone'] != '') {
            $where .= " and a.phone like '%" . $filter['phone'] . "%'";
        }
        if (isset($filter['name']) && $filter['name'] != '') {
            $where .= " and a.name like '%" . $filter['name'] . "%'";
        }
        if (isset($filter['type']) && $filter['type'] != '') {
            $where .= " and b.type = " . $filter['type'];
        }
        $sql = "select count(1) as num from sdmb_user_log b left join sdmb_user a on b.user_id = a.user_id where $where";
        $rs = $this->query($sql);
        return $rs[0]['num'];
    }

    public function getWithdrawLists($filter, $page = 1, $page_size, $get_count = false)
    {
        $where = '1 and b.type=2 ';
        if (isset($filter['user_name']) && $filter['user_name'] != '') {
            $where .= " and a.user_name like '%" . $filter['user_name'] . "%'";
        }
        if (isset($filter['phone']) && $filter['phone'] != '') {
            $where .= " and a.phone like '%" . $filter['phone'] . "%'";
        }
        if (isset($filter['name']) && $filter['name'] != '') {
            $where .= " and a.name like '%" . $filter['name'] . "%'";
        }
        if (isset($filter['is_admin_oprate']) && $filter['is_admin_oprate'] != '') {
            $where .= " and b.is_admin_oprate = " . $filter['is_admin_oprate'];
        }
        if ($get_count) {
            $sql = "select count(1) as num from sdmb_user_log b left join sdmb_user a on b.user_id = a.user_id where $where";
            $rs = $this->query($sql);
            return $rs[0]['num'];
        }
        $order = ' ORDER BY b.log_id DESC ';
        $limit = ($page - 1) * $page_size . ',' . $page_size;
        $sql = "
        select
        b.log_id, b.type, b.order_id, b.type, b.old_money, b.money, b.remark, b.time, b.is_admin_oprate,
        a.user_id, a.user_name, a.phone, a.name
        from
        sdmb_user_log b
        left join sdmb_user a
        on b.user_id = a.user_id
        where $where $order limit " . $limit;
        $rs = $this->query($sql);
        return $rs;
    }
}
