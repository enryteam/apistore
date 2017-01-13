<?php
defined('IN_PHPFRAME') or exit('No permission resources.');
pc_base::load_app_class('AdminAction');

/**
 * 后台管理首页
 */
class article extends AdminAction
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
        $rs = D('Article')->getLists($filter, $page, $page_size);
        $counts = D('Article')->getCounts($filter);
        $this->assign('lists', $rs);
        $this->assign("pages", pages($counts, $page, $page_size));
        $this->assign('filter', $filter);
        $this->display();
    }

    public function detail()
    {
        if (isPost()) {
            $article_id = intval(getgpc('article_id'));
            $title = cut_str(trim(getgpc("title")), 18, "");
            $intro = getgpc("intro");
            $sort = intval(getgpc("sort"));
            $description = getgpc("description");
            $update_time = SYS_TIME;
            
            if ($title == "") {
                $this->showmessage("请填写标题");
            }
            if ($description == "") {
                $this->showmessage("请输入文章内容");
            }
            $description = preg_replace("/^width=\"\d*\"$/ies", "", $description);
            $description = preg_replace("/^height=\"\d*\"$/ies", "", $description);
            $data = array(
                "title" => $title,
                "intro" => $intro,
                "status" => 0,
                "sort" => $sort,
                "description" => $description,
                "update_time" => $update_time
            );
            if ($article_id) {
                $rs = D('Article')->update($data, array(
                    'article_id' => $article_id
                ));
                if ($rs) {
                    $this->showmessage('操作成功', pfUrl('', 'article', 'index'));
                } else {
                    $this->showmessage('操作失败');
                }
            } else {
                $data['create_time'] = SYS_TIME;
                $rs = D('Article')->add($data);
                if ($rs) {
                    $this->showmessage('操作成功', pfUrl('', 'article', 'index'));
                } else {
                    $this->showmessage('操作失败');
                }
            }
        }
        $article_id = intval(getgpc('article_id'));
        if ($article_id) {
            $article = D('Article')->getItemById($article_id);
            if ($article) {
                $this->assign('details', $article);
            }
        }
        // 查询当前最大排序值
        $this->assign('max_sort', D('Article')->getMaxSort());
        $this->display();
    }

    public function audit()
    {
        $article_id = getgpc('article_id');
        $is_audit = getgpc('is_audit');
        $flag = D('Article')->update(array(
            'status' => $is_audit
        ), array(
            'article_id' => $article_id
        ));
        if ($flag) {
            $this->showmessage("文章审核成功", pfUrl(null, "article", "index"));
        } else {
            $this->showmessage("文章审核失败", pfUrl(null, "article", "index"));
        }
    }

    public function remove()
    {
        $article_id = isset($_GET['article_id']) ? intval(getgpc("article_id")) : $this->showmessage("文章不存在", pfUrl(null, "article", "index"));
        // 查询体验文章
        $article = D('Article')->getItemById($article_id);
        if (empty($article)) {
            $this->showmessage("文章不存在", pfUrl(null, "article", "index"));
        }
        $flag = D('Article')->update(array(
            "is_del" => 1,
            "status" => 0
        ), array(
            "article_id" => $article_id
        ));
        if ($flag) {
            $this->showmessage("文章删除成功", pfUrl(null, "article", "index"));
        } else {
            $this->showmessage("文章删除失败", pfUrl(null, "article", "index"));
        }
    }
}
