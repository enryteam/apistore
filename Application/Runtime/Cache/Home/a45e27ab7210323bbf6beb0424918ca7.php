<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo ($item["item_name"]); ?> 接口文档/技术文档/在线Api文档</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="DNT">
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/css/apistore.css" rel="stylesheet">
      <script type="text/javascript">
      var DocConfig = {
          host: window.location.origin,
          app: "<?php echo U('/');?>",
          pubile:"/Public",
      }

      DocConfig.hostUrl = DocConfig.host + "/" + DocConfig.app;
      </script>
      <script src="/Public/js/lang.<?php echo LANG_SET;?>.js?v=2"></script>
  </head>
  <body>

<link rel="stylesheet" href="/Public/css/item/show.css?1.1d.1thddde" />


<div class="doc-head row" >
  <div class="left "><h2><?php echo ($item["item_name"]); ?></h2></div>
  <div class="right">
    <ul class="inline pull-right">

      <?php if($ItemPermn): ?><li>
          <div class="btn-group ">
            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
              <?php echo (L("item")); ?>
              <span class="caret"></span>
            </a>
          <ul class="dropdown-menu">
          <!-- dropdown menu links -->
            <li><a href="#" id="share"><?php echo (L("share")); ?></a></li>
             <li><a href="<?php echo U('Home/Item/word',array('item_id'=>$item['item_id']));?>"><?php echo (L("export")); ?></a></li>

             <?php if($ItemCreator): ?><li><a href="<?php echo U('Home/Item/add',array('item_id'=>$item['item_id']));?>"><?php echo (L("update_info")); ?></a></li>          
              <li><a href="<?php echo U('Home/Member/edit',array('item_id'=>$item['item_id']));?>"><?php echo (L("manage_members")); ?></a></li>
              <li><a href="<?php echo U('Home/Attorn/index',array('item_id'=>$item['item_id']));?>"><?php echo (L("attorn")); ?></a></li>
              <li><a href="<?php echo U('Home/Item/delete',array('item_id'=>$item['item_id']));?>"><?php echo (L("delete")); ?></a></li><?php endif; ?>

            <li><a href="<?php echo U('Home/Item/index');?>"><?php echo (L("more_item")); ?></a></li>
          </ul>
      </li>
      <?php else: ?>

      <?php if(! $login_user): ?><li ><a href="<?php echo U('Home/User/login');?>"><?php echo (L("login_or_register")); ?></a></li>
        <li ><a href="<?php echo ($help_url); ?>" target="_blank"><?php echo (L("about_showdoc")); ?></a></li>
        <?php else: ?>
        <li><a href="<?php echo U('Home/Item/index');?>"><?php echo (L("my_item")); ?></a></li><?php endif; endif; ?>

    </ul>
    </div>  
  </div>
</div>

<div class="doc-body row">
  <!-- 左侧栏菜单 -->
    <div class="doc-left span3 bs-docs-sidebar pull-left">
        <form class="form-search text-center" action="<?php echo U('Home/item/show',array('item_id'=>$item['item_id']));?>" method="post">
          <div class="input-append search-input-append">
            <i class="icon-blank"></i>
            <input type="text" name="keyword" class="search-query search-query-input" value="<?php echo ($keyword); ?>">
            <input type="hidden" name="item_id" value="<?php echo ($item["item_id"]); ?>">
            <button type="submit" class="btn"><i class="icon-search"></i></button>
          </div>
        </form>

      <ul class="nav nav-list bs-docs-sidenav">

        <!-- 一级目录的页面在前面 -->
        <?php if(is_array($pages)): foreach($pages as $key=>$page): ?><li ><a href="<?php echo U('Home/Page/index',array('page_id'=>$page['page_id']));?>" data-page-id="<?php echo ($page["page_id"]); ?>" ><i class="icon-blank"></i><?php echo ($page["page_title"]); ?></a></li><?php endforeach; endif; ?>

        <?php if(is_array($catalogs)): foreach($catalogs as $key=>$catalog): ?><li><a href="#"><i class="icon-chevron-right"></i><?php echo ($catalog["cat_name"]); ?></a>
            <ul class="child-ul nav-list hide">
              <!-- 二级目录的页面们 -->
              <?php if(is_array($catalog["pages"])): foreach($catalog["pages"] as $key=>$catalog_page): ?><li><a href="<?php echo U('Home/Page/index',array('page_id'=>$catalog_page['page_id']));?>" data-page-id="<?php echo ($catalog_page["page_id"]); ?>" ><?php echo ($catalog_page["page_title"]); ?></a></li><?php endforeach; endif; ?>
              <!-- 二级目录的子目录们（三级目录） -->
                <?php if(is_array($catalog["catalogs"])): foreach($catalog["catalogs"] as $key=>$catalog3): ?><li class="third-child-catalog"><a href="#"><i class="icon-chevron-right"></i><?php echo ($catalog3["cat_name"]); ?></a>
                    <ul class="child-ul nav-list hide">
                      <!-- 二级目录的页面们 -->
                      <?php if(is_array($catalog3["pages"])): foreach($catalog3["pages"] as $key=>$catalog3_page): ?><li><a href="<?php echo U('Home/Page/index',array('page_id'=>$catalog3_page['page_id']));?>" data-page-id="<?php echo ($catalog3_page["page_id"]); ?>" ><?php echo ($catalog3_page["page_title"]); ?></a></li><?php endforeach; endif; ?>
                    </ul>
                  </li><?php endforeach; endif; ?>

            </ul>
          </li><?php endforeach; endif; ?>

      </ul>
      <!-- 新建栏 -->
      <div class="doc-left-newbar">

        <?php if($ItemPermn): ?><div><a href="<?php echo U('Home/Page/edit',array('item_id'=>$item['item_id'],'type'=>'new'));?>" id="new-like"><i class="icon-plus"></i>&nbsp;<?php echo (L("new_page")); ?></a></div>
          <div><a href="<?php echo U('Home/Catalog/edit',array('item_id'=>$item['item_id']));?>" id="dir-like" ><i class="icon-folder-open"></i><?php echo (L("new_catalog")); ?></a></div><?php endif; ?>

      </div>

      <input type="hidden" id="item_id" value="<?php echo ($item["item_id"]); ?>">
      <input type="hidden" id="item_domain" value="<?php echo ($item["item_domain"]); ?>">
      <input type="hidden" id="current_page_id" value="<?php echo ($current_page_id); ?>">
      <input type="hidden" id="base_url" value="/index.php?s=">


    </div>
    <div class="doc-right  span12 ">
      <!-- 编辑栏 -->
      <div class='page-edit-link pull-right hide'>
        <ul class="inline">
          <?php if($ItemPermn): ?><li><a href="" id="share-page" title="<?php echo (L("share_address_to_your_friends")); ?>"><?php echo (L("share")); ?></a></li>
            <li><a href="" id="copy-link" title="<?php echo (L("copy_interface_to_new")); ?>"><?php echo (L("copy")); ?></a></li>
            <li><a href="" id="edit-link" title="<?php echo (L("edit_interface")); ?>"><?php echo (L("edit")); ?></a></li>
            <li><a href="" title="<?php echo (L("delete_interface")); ?>" onclick="return confirm('<?php echo (L("comfirm_delete")); ?>');return false;" id="delete-link"><?php echo (L("delete")); ?></a></li>
          <?php else: ?>
            <li></li>
            <li></li><?php endif; ?>
        </ul>
      </div>
      <!-- 页面内容 -->
      <div class='iframe_content'>
        <iframe id="page-content" width="100%" scrolling="yes"  height="100%" frameborder="0" style=" overflow:visible; height:100%;" name="main"  seamless ="seamless"src=""></iframe>
      </div>

    </div>


	<script src="/Public/js/common/jquery.min.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Public/js/common/apistore.js?v=1.1"></script>
    <div style="display:block">
    版权所有 南京蒽凯网络科技有限公司 <a href="http://www.miitbeian.gov.cn" target="_blank">苏ICP备15034057号-1</a>
    </div>
  </body>
</html>

<!-- 分享项目框 -->
<div class="modal hide fade" id="share-modal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo (L("share")); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo (L("item_address")); ?>：<code><?php echo ($share_url); ?></code></p>
    <p><?php echo (L("copy_address_to_your_friends")); ?></p>
  </div>
</div>

<!-- 分享页面框 -->
<div class="modal hide fade" id="share-page-modal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo (L("share_page")); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo (L("page_address")); ?>：<code id="share-page-link"></code></p>
    <p><?php echo (L("copy_address_to_your_friends")); ?></p>
  </div>
</div>
<script src="/Public/js/jquery.bootstrap-growl.min.js"></script>
<script src="/Public/js/jquery.goup.min.js"></script>
<script src="/Public/js/jquery.hotkeys.js"></script>

<script src="/Public/js/item/show.js?v=1.2121"></script>