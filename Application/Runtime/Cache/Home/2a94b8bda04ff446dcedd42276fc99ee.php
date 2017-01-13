<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
<title>Apistore 软件众包技术团队的在线API文档、技术文档工具</title>
 <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">

 <link rel="stylesheet" href="/Public/css/jquery.fullPage.css">
 <style>
.section { text-align: center; font: 30px "Microsoft Yahei"; color: #fff;}
.header{
 padding-right: 100px;
 padding-top: 30px;
 font-size: 18px;
 position: fixed;
    right: 0;
    left: 0;
    z-index: 1030;
    margin-bottom: 0;
}
.header a {
    color: white;
    font-size: 22px;
    font-weight: bold;
}
</style>
</head>

<body>
<div class="row header  ">
  <div class="right pull-right">
    <ul class="inline pull-right">
	  <?php if($login_user): ?><li ><a href="<?php echo U('Home/Item/index');?>"><?php echo (L("my_item")); ?></a></li>
	    <?php else: ?>
	    <li ><a href="<?php echo U('Home/User/login');?>"><?php echo (L("index_login_or_register")); ?></a></li><?php endif; ?>
    </ul>
    </div>
  </div>

<div id="dowebok">
    <div class="section">
        <h1><?php echo (L("section_title1")); ?></h1>
        <br>
        <p>一个非常适合软件众包技术团队的在线API文档、技术文档工具</p>
        <br>
        <p>
          <a class="btn  btn-large" href="http://apistore.51daniu.cn/index.php?s=/1&page_id=1" target="_blank" >开放平台&nbsp;</i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <a class="btn   btn-large " href="http://www.zbk8.com/" target="_blank">众包平台</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn  btn-large" href="http://www.51daniu.cn/" target="_blank" >共享平台&nbsp;</i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="btn  btn-large" href="http://www.zbk8.com/product.html" target="_blank" >产品平台&nbsp;</i></a>

        </p>
    </div>
    <div class="section">
        <h1><?php echo (L("section_title2")); ?></h1>
        <br>
        <p> mapp、mweb、pcweb前端与服务器常用API来进行交互<br/>
用Apistore可以非常方便快速地编写出美观的API文档
</p>
        <br>
    </div>
    <div class="section">
        <h1><?php echo (L("section_title3")); ?></h1>
        <br>
        <p><?php echo (L("section_description3")); ?></p>
        <br>
    </div>
    <div class="section">
        <h1><?php echo (L("section_title4")); ?></h1>
        <br>
        <p><?php echo (L("section_description4")); ?></p>
        <br>
    </div>

    <div class="section">
        <h1><?php echo (L("section_title5")); ?></h1>
        <br>
        <p><?php echo (L("section_description5")); ?></p>
        <br>
    </div>

    <div class="section">
        <h1><?php echo (L("section_title6")); ?></h1>
        <br>
        <p><?php echo (L("section_description6")); ?></p>
        <br>
    </div>

    <div class="section">
        <h1><?php echo (L("section_title7")); ?></h1>
        <br>
        <p><?php echo (L("section_description7")); ?></p>
        <br>
    </div>
    <div class="section">
        <h1></h1>
        <br>
        <p><?php echo (L("section_description8")); ?></p>
        <br>
        <p>
            <a class="btn   btn-large " href="<?php echo U('Home/User/register');?>"><?php echo (L("section_title8")); ?></a>
        </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p><p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>
        版权所有 南京蒽凯网络科技有限公司 <a href="http://www.miitbeian.gov.cn" target="_blank">苏ICP备15034057号-1</a>
      </p>
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


<script src="/Public/js/jquery.fullPage.min.js"></script>
<script>
$(function(){
    $('#dowebok').fullpage({
        sectionsColor : ['#1bbc9b', '#4BBFC3', '#2C606A', '#f90','#7CBD9D','#A77DC2','#85CE92','#1bbc9b'],
        navigation:true,
    });

    $(window).resize(function(){
        autoScrolling();
    });

    function autoScrolling(){
        var $ww = $(window).width();
        if($ww < 1024){
            $.fn.fullpage.setAutoScrolling(false);
        } else {
            $.fn.fullpage.setAutoScrolling(true);
        }
    }

    autoScrolling();
});
</script>

</body>
</html>