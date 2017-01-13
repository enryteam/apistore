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
        <h3 class="form-signin-heading"><?php echo (L("login")); ?></h3>
        <input type="text" class="input-block-level"  name="username" placeholder="<?php echo (L("username")); ?>">
        <input type="password" class="input-block-level" name="password" placeholder="<?php echo (L("password")); ?>">
        <?php if($CloseVerify != 1): ?><input type="text" class="input-block-level"  name="v_code" placeholder="<?php echo (L("verification_code")); ?>">
        <div class="control-group">
          <div class="controls">
            <img src="#" id="v_code_img">
          </div>
        </div><?php endif; ?>
        <button class="btn btn-large btn-primary" type="submit"><?php echo (L("login")); ?></button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?s=/home/user/register"><?php echo (L("no_account")); ?></a>
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


 <script type="text/javascript">
 $(function(){
    $("#v_code_img").attr("src" , DocConfig.pubile+'/verifyCode.php');
    $("#v_code_img").click(function(){
      var v_code_img = $("#v_code_img").attr("src");
      $("#v_code_img").attr('src' ,v_code_img+'?'+Date.parse(new Date()) );
    }); 
 });
</script>