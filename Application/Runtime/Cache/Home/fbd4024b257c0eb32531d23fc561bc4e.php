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

<link rel="stylesheet" href="/Public/css/item/index.css" />
<style type="text/css">
  .container-thumbnails{
    margin-top: 60px;
  }
  .thumbnails li a{
    color: #888;
    font-weight: bold;
    height: 100px;
  }
  .thumbnails li a:hover,
  .thumbnails li a:focus{
    border-color:#f2f5e9;
    -webkit-box-shadow:none;
    box-shadow:none;
    text-decoration: none;
    background-color: #f2f5e9;
  }
</style>
    <div class="container-narrow">

      <div class="masthead">
        <div class="btn-group pull-right">
        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
        <?php echo ($login_user["username"]); ?>
        <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
        <!-- dropdown menu links -->
          <li><a href="<?php echo U('Home/User/setting');?>"><?php echo (L("personal_setting")); ?></a></li>
          <li><a href="#share-home-modal"  data-toggle="modal"><?php echo (L("share_home")); ?></a></li>
          <li><a href="<?php echo U('Home/index/index');?>"><?php echo (L("web_home")); ?></a></li>
          <li><a href="<?php echo U('Home/User/exist');?>"><?php echo (L("logout")); ?></a></li>

        </ul>
        </div>

        </ul>
        <h3 class="muted">Apistore</h3>
      </div>

      <hr>

    <div class="container-thumbnails">
      <ul class="thumbnails">

        <?php if(is_array($items)): foreach($items as $key=>$item): ?><li class="span3 text-center">
            <a class="thumbnail" href="<?php echo U('Home/Item/show',array('item_id'=>$item['item_id']));?>" title="<?php echo ($item["item_description"]); ?>">
              <p class="my-item"><?php echo ($item["item_name"]); ?></p>
            </a>
          </li><?php endforeach; endif; ?>

        <li class="span3 text-center">
          <a class="thumbnail" href="<?php echo U('Home/Item/add');?>" title="<?php echo (L("add_an_item")); ?>添加一个新项目">
            <p class="my-item "><?php echo (L("new_item")); ?>&nbsp;<i class="icon-plus"></i></p>
          </a>
        </li>
      </ul>
    </div>


    </div> <!-- /container -->

<!-- 分享项目框 -->
<div class="modal hide fade" id="share-home-modal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><?php echo (L("share_my_home")); ?></h3>
  </div>
  <div class="modal-body">
    <p><?php echo (L("home_address")); ?>：<code id="share-home-link"><?php echo ($share_url); ?></code></p>
    <p><?php echo (L("home_address_description")); ?></p>
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

 <script type="text/javascript">


 </script>