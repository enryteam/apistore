<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
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

<style type="text/css">
.message {
  width: 600px;
  min-height: 80px;
  padding: 20px 20px 10px 20px;
  margin: 50px auto 0 auto;
  border-width: 5px;
  overflow: hidden;
}
.message .content {
  overflow: hidden;
}
.message h4 {
  margin: 10px 0;
  line-height: 30px;
}

</style>
<div class="message alert alert-<?php echo ($type); ?>">
	<div class="icon pull-left"><i class="{if $type=='success'}icon-ok{else if $type=='error'}icon-remove{else if $type=='tips'}icon-exclamation-sign{else if $type=='sql'}icon-warning-sign{/if}"></i></div>
	<div class="content">
		<h4><?php echo $msg;?></h4>
		<?php if($redirect){ ?>
		<p><a href="<?php echo $redirect;?>"><?php echo (L("redirect_message")); ?></a></p>
		<script type="text/javascript">
			setTimeout(function () {
				location.href = "<?php echo $redirect;?>";
			}, 3000);
		</script>
		<?php }else{ ?>
		<p>[<a href="javascript:history.go(-1);"><?php echo (L("click_to_goback")); ?></a>] &nbsp; [<a href="/index.php?s=/"><?php echo (L("home")); ?></a>]</p>
		<?php } ?>
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