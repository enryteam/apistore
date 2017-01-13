<?php
error_reporting(0);
header('Access-Control-Allow-Origin:*');
/**
 * index.php 入口
 */
// /**防攻击鉴权策略**************Start**/
$IPaddress='';
if (isset($_SERVER)){
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
        $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
    } else {
        $IPaddress = $_SERVER["REMOTE_ADDR"];
    }
} else {
    if (getenv("HTTP_X_FORWARDED_FOR")){
        $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
    } else if (getenv("HTTP_CLIENT_IP")) {
        $IPaddress = getenv("HTTP_CLIENT_IP");
    } else {
        $IPaddress = getenv("REMOTE_ADDR");
    }
}
$allowedIPARR = array('118.178.123.219','139.196.140.194','124.67.69.98','49.65.105.174','221.229.254.75','221.231.138.40');
$allowedIPARR[] = trim(file_get_contents("gydz.txt"));//吊gydz是动态ip..

if(in_array(trim($_GET['c']),array('sms'))&&!in_array($IPaddress,$allowedIPARR))
{
  if(!file_exists('hack'.date("Ym").'.php')){ file_put_contents('hack'.date("Ym").'.php','<?php exit;?>'."\r\n");}
  file_put_contents('hack'.date("Ym").'.php',$IPaddress."\r\n".serialize($_SERVER)."\r####################################################\n",FILE_APPEND);
  // $to = "18061208098@189.cn";
  // $subject = $IPaddress." NOTICE HACK enryALISERVER";
  // $message = $IPaddress."\r\n".serialize($_SERVER)."\r####################################################\n";
  // $from = "ac@enry.cn";
  // $headers = "From: $from";
  // mail($to,$subject,$message,$headers);
  echo json_encode(array('code'=>'403','message'=>'无权访问，联系AC@ENRY.CN'));
  exit;
}
// /**防攻击策略**************Over**/

define('APP_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('ATTMS_PATH', APP_PATH . 'attms' . DIRECTORY_SEPARATOR);
define('PHPFRAME_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
include PHPFRAME_PATH . '/phpframe/base.php';
error_reporting(0);
@ini_set('session.use_cookies',1);
@ini_set('session.cookie_lifetime',9999999999);

@ini_set('session.gc_maxlifetime', 9999999999);

@ini_set('date.timezone','Asia/Shanghai');

//@file_put_contents("../weblogs/info/i_".date("YmdH").".txt",serialize($_REQUEST)."\r\n",FILE_APPEND);//debug
include_once 'aliyun-php-sdk-core/Config.php';//集成阿里云端接口 by A.C. 161111
//*******aliyun sms
use Sms\Request\V20160927 as Sms;
$iClientProfile = DefaultProfile::getProfile("cn-hangzhou", "LTAIJH4D5kXrJPss", "w9PhMu2g4OrcelVS6BSd1iu9Wmg39W");
$alismsClient = new DefaultAcsClient($iClientProfile);
$alismsRequest = new Sms\SingleSendSmsRequest();
//*******aliyun ###


pc_base::creat_app();
class RemoteAddress
{
    /**
     * Whether to use proxy addresses or not.
     *
     * As default this setting is disabled - IP address is mostly needed to increase
     * security. HTTP_* are not reliable since can easily be spoofed. It can be enabled
     * just for more flexibility, but if user uses proxy to connect to trusted services
     * it's his/her own risk, only reliable field for IP address is $_SERVER['REMOTE_ADDR'].
     *
     * @var bool
     */
    protected $useProxy = false;

    /**
     * List of trusted proxy IP addresses
     *
     * @var array
     */
    protected $trustedProxies = array();

    /**
     * HTTP header to introspect for proxies
     *
     * @var string
     */
    protected $proxyHeader = 'HTTP_X_FORWARDED_FOR';

    // [...]

    /**
     * Returns client IP address.
     *
     * @return string IP address.
     */
    public function getIpAddress()
    {
        $ip = $this->getIpAddressFromProxy();
        if ($ip) {
            return $ip;
        }

        // direct IP address
        if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }

        return '';
    }

    /**
     * Attempt to get the IP address for a proxied client
     *
     * @see http://tools.ietf.org/html/draft-ietf-appsawg-http-forwarded-10#section-5.2
     * @return false|string
     */
    protected function getIpAddressFromProxy()
    {
        if (!$this->useProxy
            || (isset($_SERVER['REMOTE_ADDR']) && !in_array($_SERVER['REMOTE_ADDR'], $this->trustedProxies))
        ) {
            return false;
        }

        $header = $this->proxyHeader;
        if (!isset($_SERVER[$header]) || empty($_SERVER[$header])) {
            return false;
        }

        // Extract IPs
        $ips = explode(',', $_SERVER[$header]);
        // trim, so we can compare against trusted proxies properly
        $ips = array_map('trim', $ips);
        // remove trusted proxy IPs
        $ips = array_diff($ips, $this->trustedProxies);

        // Any left?
        if (empty($ips)) {
            return false;
        }

        // Since we've removed any known, trusted proxy servers, the right-most
        // address represents the first IP we do not know about -- i.e., we do
        // not know if it is a proxy server, or a client. As such, we treat it
        // as the originating IP.
        // @see http://en.wikipedia.org/wiki/X-Forwarded-For
        $ip = array_pop($ips);
        return $ip;
    }

    // [...]
}

?>
