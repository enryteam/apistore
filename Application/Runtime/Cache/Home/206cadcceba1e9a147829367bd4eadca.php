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

<style type="text/css">
.single-cat{
  margin: 10px;
}
</style>
 <div id="edit-cat" class="modal hide fade">
  <!-- 编辑框 -->
  <div class="cat-edit">
      <div class="modal-header">
      <h4><?php echo (L("delete_item")); ?></h4>
      </div>
      <input type="hidden" id="item_id" value="<?php echo ($item_id); ?>">
      <div class="add-cat">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label" for="inputEmail"><?php echo (L("verify_your_identity")); ?></label>
              <div class="controls">
                <input type="password" id="password" placeholder="<?php echo (L("creator_password")); ?>" value="">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <button type="submit" class="btn" id="save-cat"><?php echo (L("delete")); ?></button>
              </div>
            </div>
          </form>

      </div>
    </div>

    <div class="modal-footer">
      <a href="#" class="btn exist-cat"><?php echo (L("close")); ?></a>
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

 <script src="/Public/js/item/delete.js?v=dd"></script>