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

<link rel="stylesheet" href="/Public/css/login.css" />

    <div class="container">

      <form class="form-signin" method="post">
        <h3 class="form-signin-heading"><?php echo (L("update_personal_info")); ?></h3>
        <input type="text" class="input-block-level" value="<?php echo ($user["username"]); ?>" disabled >
        <input type="password" class="input-block-level" name="new_password"  placeholder="<?php echo (L("new_password_description")); ?>">
        <input type="password" class="input-block-level" name="password"  placeholder="<?php echo (L("old_password_description")); ?>">
        <button class="btn  btn-primary" type="submit"><?php echo (L("submit")); ?></button>
        <a href="javascript:history.go(-1)" class="btn"><?php echo (L("goback")); ?></a>
      </form>

    </div> <!-- /container -->


 
	<script src="/Public/js/common/jquery.min.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Public/js/common/apistore.js?v=1.1"></script>
    <div style="display:block">
    版权所有 南京蒽凯网络科技有限公司 <a href="http://www.miitbeian.gov.cn" target="_blank">苏ICP备15034057号-1</a>
    </div>
  </body>
</html>