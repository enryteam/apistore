<?php
return array(
    // 网站路径
    'web_path' => '/',
    // Session配置
    'session_storage' => 'files',
    'session_ttl' => 18000000,
    // 'session_savepath' => CACHE_PATH . 'sessions/',
    'session_n' => 0,
    // Cookie配置
    'cookie_domain' => '', // Cookie 作用域
    'cookie_path' => '', // Cookie 作用路径
    'cookie_pre' => 'dnw51DaNiu_', // Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀
    'cookie_ttl' => 0, // Cookie 生命周期，0 表示随浏览器进程
                       // 附件相关配置
    'upload_path' => PHPFRAME_PATH . 'attms/im/',//聊天附件
	'upface_path' =>PHPFRAME_PATH . 'attms/face/',//头像
	'upatd_path' =>PHPFRAME_PATH . 'attms/atd/',//认证资料
	'upbarcode_path' =>PHPFRAME_PATH . 'attms/barcode/',//扫码
    'upload_url' => 'http://sdmb.51daniu.cn/attms/', // 附件路径
    'attachment_stat' => '1', // 是否记录附件使用状态 0 统计 1 统计， 注意: 本功能会加重服务器负担
    
    'js_url' => 'http://sdmb.51daniu.cn/attms/js/', // CDN JS
    'css_url' => 'http://sdmb.51daniu.cn/attms/css/', // CDN CSS
    'img_url' => 'http://sdmb.51daniu.cn/attms/images/', // CDN img
    'app_url' => 'http://sdmb.51daniu.cn/m/', // 动态域名配置地址
    'www_url' => 'http://sdmb.51daniu.cn/',
    'attms_url' => 'http://sdmb.51daniu.cn/attms/',
    'charset' => 'utf-8', // 网站字符集
    'timezone' => 'Etc/GMT-8', // 网站时区（只对php 5.1以上版本有效），Etc/GMT-8 实际表示的是
                               // GMT+8
    'debug' => 1, // 是否显示调试信息
    'admin_log' => 1, // 是否记录后台操作日志
    'errorlog' => 1, // 1、保存错误日志到 weblogs/error | 0、在页面直接显示
    'gzip' => 1, // 是否Gzip压缩后输出
    'auth_key' => 'dnw51DaNiuACphpframe', // 密钥
    'lang' => 'zh-cn', // 网站语言包
    'lock_ex' => '1', // 写入缓存时是否建立文件互斥锁定（如果使用nfs建议关闭）
    
    'execution_sql' => 0, // EXECUTION_SQL
    
    'rewrite' => 0,
	'barSimple'=>array('BXB'=>array('白细胞','检测范围(0-500)','(cells/uL)',array(500,125,70,15,0)),
					   'YXSY'=>array('亚硝酸盐','检测范围(阴性、阳性)',' ',array('阳性','阳性','阴性')),
					   'NDY'=>array('尿胆原','检测范围(3.3-135)','(u mol/L)',array(135,68,34,17,3.3)),
					   'NDB'=>array('尿蛋白','检测范围(0-20)','(g/L)',array(20,3.0,1.0,0.3,0.15,0)),
					   'PH'=>array('PH','检测范围(5.0-8.5)',' ',array(8.5,8.0,7.5,7.0,6.5,6.0,5.0)),
					   'XUE'=>array('血','检测范围(0-200)','(cells/uL)',array(200,80,25,10,10,0)),
					   'NBZ'=>array('尿比重','检测范围(1.000-1.030)',' ',array(1.030,1.025,1.020,1.015,1.010,1.005,1.000)),
					   'KHXS'=>array('抗坏血酸','检测范围(0-5.7)','(mmol/L)',array(5.7,2.8,1.4,0.6,0)),
					   'TTI'=>array('酮体','检测范围(0-16)','(mmol/L)',array(16,7.8,3.9,1.5,0.5,0)),
					   'DHS'=>array('胆红素','检测范围(0-100)','(umol/L)',array(100,50,17,0)),
					   'PTT'=>array('葡萄糖','检测范围(0-56)','(mmol/L)',array(56,28,14,5.6,0)),
					   'BDB'=>array('钙离子','检测范围(0 ~ 10.0)','(mmol/L)',array(10,7.5,5,2.5,1.25,0.625,0)))
);
//BDB--->GAI
?>
