<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('AdminAction');

/**
 * 商品管理首页
 */
class goods extends AdminAction
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
        $rs = D('Goods')->getLists($filter, $page, $page_size);
        $counts = D('Goods')->getLists($filter, $page, $page_size, true);
        $this->assign('lists', $rs);
        $this->assign("pages", pages($counts, $page, $page_size));
        $this->assign('filter', $filter);
        $this->display();
    }

    public function detail()
    {
        if (isPost()) {
            $goods_id = intval(getgpc('goods_id'));
            $title = cut_str(trim(getgpc("title")), 18, "");
            $intro = getgpc("intro");
            $sort = intval(getgpc("sort"));
            $description = getgpc("description");
            $cover = getgpc('cover');
            $price = getgpc('price');
            $update_time = SYS_TIME;
            
            if ($title == "") {
                $this->showmessage("请填写商品标题");
            }
            if ($description == "") {
                $this->showmessage("请输入商品内容");
            }
            if ($cover == "") {
            	$this->showmessage('请上传封面图');
            }
            if (!is_numeric($price)) {
            	$this->showmessage('请输入正确的价格');
            }
            $description = preg_replace("/^width=\"\d*\"$/ies", "", $description);
            $description = preg_replace("/^height=\"\d*\"$/ies", "", $description);
            $data = array(
                "title" => $title,
                "intro" => $intro,
                "status" => 0,
                "sort" => $sort,
                "description" => $description,
                "update_time" => $update_time,
                'cover'=>$cover,
                'price'=>$price
            );
            if ($goods_id) {
                $rs = D('Goods')->update($data, array(
                    'goods_id' => $goods_id
                ));
                if ($rs) {
                    $this->showmessage('操作成功', pfUrl('', 'goods', 'index'));
                } else {
                    $this->showmessage('操作失败');
                }
            } else {
                $data['create_time'] = SYS_TIME;
                $rs = D('Goods')->add($data);
                if ($rs) {
                    $this->showmessage('操作成功', pfUrl('', 'goods', 'index'));
                } else {
                    $this->showmessage('操作失败');
                }
            }
        }
        $goods_id = intval(getgpc('goods_id'));
        if ($goods_id) {
            $goods = D('Goods')->getItemById($goods_id);
            if ($goods) {
                $this->assign('details', $goods);
            }
        }
        // 查询当前最大排序值
        $this->assign('max_sort', D('Goods')->getMaxSort());
        $this->display();
    }

    public function audit()
    {
        $goods_id = getgpc('goods_id');
        $is_audit = getgpc('is_audit');
        $flag = D('Goods')->update(array(
            'status' => $is_audit
        ), array(
            'goods_id' => $goods_id
        ));
        if ($flag) {
            $this->showmessage("商品审核成功", pfUrl(null, "goods", "index"));
        } else {
            $this->showmessage("商品审核失败", pfUrl(null, "goods", "index"));
        }
    }

    public function remove()
    {
        $goods_id = isset($_GET['goods_id']) ? intval(getgpc("goods_id")) : $this->showmessage("商品不存在", pfUrl(null, "goods", "index"));
        // 查询体验商品
        $goods = D('Goods')->getItemById($goods_id);
        if (empty($goods)) {
            $this->showmessage("商品不存在", pfUrl(null, "goods", "index"));
        }
        $flag = D('Goods')->update(array(
            "is_del" => 1,
            "status" => 0
        ), array(
            "goods_id" => $goods_id
        ));
        if ($flag) {
            $this->showmessage("商品删除成功", pfUrl(null, "goods", "index"));
        } else {
            $this->showmessage("商品删除失败", pfUrl(null, "goods", "index"));
        }
    }
}
