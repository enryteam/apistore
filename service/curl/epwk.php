<?php
//以腾讯企业邮箱做了测试
$mailServer="imap.189.cn"; //IMAP主机

$mailLink="{{$mailServer}:143}INBOX" ; //imagp连接地址：不同主机地址不同

$mailUser = '18061208098@189.cn'; //邮箱用户名

$mailPass = 'adminchen'; //邮箱密码

$mbox = imap_open($mailLink,$mailUser,$mailPass); //开启信箱imap_open

echo $totalrows = imap_num_msg($mbox); //取得信件数

for ($i=1;$i<5;$i++){

    $headers = imap_fetchheader($mbox, $i); //获取信件标头

    $headArr = matchMailHead($headers); //匹配信件标头

    $mailBody = imap_fetchbody($mbox, $i, 1); //获取信件正文
		preg_match_all('/<div style="line-height:25px;">(.*?)<a  href="(.*?)" target=\'_blank\' >(.*?)<\/a>，最新匹配任务请您及时参与，任务详情如下：(.*?)<\/div>(.*?)<td height="25" align="left">(.*?)<\/td>(.*?)<tr><td height=\'25\' colspan=\'2\' align=\'left\'>联系方式：(.*?)&nbsp;&nbsp;&nbsp;<\/td><\/tr>/isU',$mailBody, $str);
		//print_r($str);
		$title = $str[3][0];
		$price = str_replace('尊敬的mf5413e4d35c9bd，','',$str[1][0]);
		$content = $str[4][0];
		$type = $str[6][0];
		$contact = $str[8][0];




		echo '<hr>';

}

/**
 *
 * 匹配提取信件头部信息
 * @param String $str
 */
function matchMailHead($str){
    $headList = array();
    $headArr = array(
        'from',
        'to',
        'date',
        'subject'
    );

    foreach ($headArr as $key){
        if(preg_match('/'.$key.':(.*?)[\n\r]/is', $str,$m)){
            $match = trim($m[1]);
            $headList[$key] = $key=='date'?date('Y-m-d H:i:s',strtotime($match)):$match;
        }
    }
    return $headList;
}
