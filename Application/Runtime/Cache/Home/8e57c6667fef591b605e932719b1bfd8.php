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
  margin: 5px;
}
.cat-list{
  max-height: 250px;
}
.cat-content{
    max-height: 195px;
    overflow-y: auto;
}
</style>
 <div id="edit-cat" class="modal hide fade">
  <!-- 编辑框 -->
  <div class="cat-edit">
      <div class="modal-header">
      <h4><?php echo (L("new_or_edit_catalog")); ?></h4>
      </div>
      <input type="hidden" id="item_id" value="<?php echo ($item_id); ?>">
      <input type="hidden" id="cat_id" value="<?php echo ($Catalog["cat_id"]); ?>">
      <div class="add-cat">
          <form class="form-horizontal">
            <div class="control-group">
              <label class="control-label" for="inputEmail"><?php echo (L("catalog_name")); ?></label>
              <div class="controls">
                <input type="text" id="cat_name" placeholder="<?php echo (L("catalog_name")); ?>" value="<?php echo ($Catalog["cat_name"]); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="inputPassword"><?php echo (L("s_number")); ?></label>
              <div class="controls">
                <input type="text" id="s_number" placeholder="<?php echo (L("s_number_explain")); ?>" value="<?php echo ($Catalog["s_number"]); ?>">
              </div>
            </div>
             <div class="control-group">
              <label class="control-label" for="inputPassword"><?php echo (L("last_catalog")); ?></label>
              <div class="controls">
                  <select name="parent_cat_id" id="parent_cat_id" ></select>
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <button  class="btn" id="save-cat"><?php echo (L("save")); ?></button>
                <button  class="btn btn-link" id="delete-cat"><?php echo (L("delete_catalog")); ?></button>
              </div>
            </div>
          </form>

      </div>
    </div>
  <!-- 目录列表 -->
  <div class="cat-list">
    <div class="modal-header">
    <h4><?php echo (L("catalog_list")); ?>&nbsp;<small>(<?php echo (L("click_to_edit")); ?>)</small></h4>
    </div>
    <div id="show-cat" class="cat-content">

    <br>
    <br>
    </div>
  </div>

    <div class="modal-footer">
      <a href="#" class="btn exist-cat"><?php echo (L("close")); ?></a>
    </div>
 </div>

<input type="hidden" id="default_parent_cat_id"  value="<?php echo ($default_parent_cat_id); ?>">
 
	<script src="/Public/js/common/jquery.min.js"></script>
    <script src="/Public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/Public/js/common/apistore.js?v=1.1"></script>
    <div style="display:block">
    版权所有 南京蒽凯网络科技有限公司 <a href="http://www.miitbeian.gov.cn" target="_blank">苏ICP备15034057号-1</a>
    </div>
  </body>
</html>

 <script src="/Public/js/catalog/edit.js?v=1.1.10thirde"></script>