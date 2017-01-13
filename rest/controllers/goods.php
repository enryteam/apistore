<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class goods extends BaseAction
 {
   public $path;
 	 public function __construct()
  	{
  		parent::__construct();
 		$this->path = '../attms/upfile/'.date("Y").'/'.date("m").'/'.date("d").'/'.date("H").'/';
 		mk_dir($this->path);
  	}
  public function index()
 {
   returnJson('200','onSuccess','Welcome to apistore.51daniu.cn!');

 }
 /*
 *goods_name商品名称:商品名称
 *goods_country商品国别：中国
 *goods_town商品产地：中华
 *goods_price参考价格：65元
 *goods_factorycode厂商代码：6901028
 *goods_factoryname厂商名称：上海烟草集团有限责任公司
 */
 	public function search()
 	{
    $local = $this->path.str_replace('http://www.liantu.com/tiaoma/eantitle.php?title=','',$rntArr['titleSrc']).'.png';
    $rntArr = json_decode(file_get_contents('http://www.liantu.com/tiaoma/query.php?ean='.getgpc('num')),true);
    file_put_contents($local,file_get_contents($rntArr['titleSrc']));
    returnJson('200','onSuccess',array('goods_code'=>getgpc('num'),
                                       'goods_name'=>$rntArr['name'],
                                       'goods_country'=>$rntArr['guobie'],
                                       'goods_town'=>$rntArr['place'],
                                       'goods_price'=>$rntArr['price'],
                                       'goods_factoryname'=>str_replace('../attms/upfile/','http://cdn.51daniu.cn/upfile/',$local),
                                       'goods_factorycode'=>$rntArr['faccode'],
                                     ));

 	}

}
?>
