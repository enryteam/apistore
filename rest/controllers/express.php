<?php
 defined('IN_PHPFRAME') or exit('No permission resources.');
 pc_base::load_sys_class('BaseAction');

 class express extends BaseAction
 {
 	public function __construct()
 	{
 		parent::__construct();
 	}
  public function index()
 {
   returnJson('200','onSuccess','Welcome to apistore.51daniu.cn!');

 }
 	public function search()
 	{
    returnJson('200','onSuccess',$this->getorder(getgpc('num')));

 	}

    /*
     * 网页内容获取方法
    */
    public function getcontent($url)
    {
        if (function_exists("file_get_contents")) {
            $file_contents = file_get_contents($url);
        } else {
            $ch      = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }
    /*
     * 获取对应名称和对应传值的方法
    */
    public function expressname($order)
    {
        $name   = json_decode($this->getcontent("http://www.kuaidi100.com/autonumber/auto?num={$order}"), true);
        $result = $name[0]['comCode'];

        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    /*
     * 返回$data array      快递数组查询失败返回false
     * @param $order        快递的单号
     * $data['ischeck'] ==1 已经签收
     * $data['data']        快递实时查询的状态 array
    */
    public function getorder($order)
    {
        $keywords = $this->expressname($order);

        $result = $this->getcontent("http://www.kuaidi100.com/query?type={$keywords}&postid={$order}");
        $data   = json_decode($result, true);
        return $data;

    }
}
?>
