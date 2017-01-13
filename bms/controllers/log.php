<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('AdminAction');

/**
 * 后台管理首页
 */
class log extends AdminAction
{

    private $pageSize = 10;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 流水记录
     */
    public function index()
    {
        $page = max(intval(getgpc('page')), 1);
        $page_size = intval(getgpc('page_size'));
        $page_size = empty($page_size) ? $this->pageSize : $page_size;
        $filter = $_GET;
        $rs = D('UserLog')->getLists($filter, $page, $page_size);
        $counts = D('UserLog')->getCounts($filter);
        $this->assign('lists', $rs);
        $this->assign("pages", pages($counts, $page, $page_size));
        $this->assign('filter', $filter);
        $this->display();
    }

    /**
     * 提现管理
     */
    public function withdraw()
    {
        $page = max(intval(getgpc('page')), 1);
        $page_size = intval(getgpc('page_size'));
        $page_size = empty($page_size) ? $this->pageSize : $page_size;
        $filter = $_GET;
        $rs = D('UserLog')->getWithdrawLists($filter, $page, $page_size);
        $counts = D('UserLog')->getWithdrawLists($filter, $page, $page_size, true);
        $this->assign('lists', $rs);
        $this->assign("pages", pages($counts, $page, $page_size));
        $this->assign('filter', $filter);
        $this->display();
    }

    public function oprate()
    {
        $log_id = intval(getgpc('log_id'));
        $is_exist = D('UserLog')->count(array(
            'log_id' => $log_id,
            'is_admin_oprate' => 0
        ));
        if ($is_exist) {
            $status = getgpc('status');
            $rs = D('UserLog')->where(array(
                'log_id' => $log_id
            ))->save(array(
                'is_admin_oprate' => $status
            ));
            if ($rs) {
                $this->success('操作成功');
            } else {
                $this->error('操作成功');
            }
        } else {
            $this->error('申请不存在');
        }
    }
}
