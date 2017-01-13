<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('AdminAction');

/**
 * 后台管理首页
 */
class order extends AdminAction
{

    private $pageSize = 10;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $page = max(intval(getgpc('page')), 1);
        $page_size = intval(getgpc('page_size'));
        $page_size = empty($page_size) ? $this->pageSize : $page_size;
        $filter = $_GET;
        $rs = D('Order')->getLists($filter, $page, $page_size);
        $counts = D('Order')->getCounts($filter);
        $this->assign('lists', $rs);
        $this->assign("pages", pages($counts, $page, $page_size));
        $this->assign('filter', $filter);
        $this->display();
    }
}
