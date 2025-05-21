<?php
/**
 * wx_jssdk_helper.php
 * 微信 JS-SDK 服务器端签名助手
 *
 * 功能:
 * 1. 获取 access_token (带缓存)
 * 2. 获取 jsapi_ticket (带缓存)
 * 3. 生成 JS-SDK 所需的签名配置
 *
 * 使用方法:
 * 在需要JS-SDK配置的页面 (例如 index.php) 中通过 AJAX 请求此文件，
 * 并传递当前页面的完整URL作为 'url' GET参数。
 * 例如: wx_jssdk_helper.php?url=http%3A%2F%2Fexample.com%2Fpage.php
 *
 * 【重要】请务必替换下面的 APP_ID 和 APP_SECRET 为您自己的微信公众号信息。
 * 【重要】确保此文件所在的服务器能够访问外网 (微信服务器)。
 * 【重要】确保服务器上有写入权限，用于缓存 access_token 和 jsapi_ticket (如果使用文件缓存)。
 */

header('Content-Type: application/json; charset=utf-8');

// --- 配置信息 ---
define("APP_ID", "在此处填入您的微信公众号AppID"); // 【重要】替换为您的 AppID
define("APP_SECRET", "在此处填入您的微信公众号AppSecret"); // 【重要】替换为您的 AppSecret

class JSSDK {
    private $appId;
    private $appSecret;
    private $cacheDir; // 缓存文件存放目录

    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        // 设置缓存目录，例如在当前脚本同级目录下创建一个 'cache' 文件夹
        $this->cacheDir = __DIR__ . '/cache/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }

    public function getSignPackage($url) {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        // $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        // $url 参数应由调用方传递过来，是当前页面的完整URL

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string // 调试用，可移除
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $cacheFile = $this->cacheDir . "jsapi_ticket.json";
        $data = null;
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile));
        }

        if (!$data || $data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = "";
            if (isset($res->ticket)) {
                $ticket = $res->ticket;
                if ($ticket) {
                    $newData = new stdClass();
                    $newData->expire_time = time() + 7000; // 提前200秒过期
                    $newData->jsapi_ticket = $ticket;
                    $fp = fopen($cacheFile, "w");
                    fwrite($fp, json_encode($newData));
                    fclose($fp);
                }
            } else {
                // 处理错误，例如记录日志
                // error_log("Failed to get jsapi_ticket: " . json_encode($res));
                // 可以抛出异常或返回错误信息
                if (isset($res->errmsg)) {
                    throw new Exception("获取 jsapi_ticket 失败: " . $res->errmsg . " (错误码: " . (isset($res->errcode) ? $res->errcode : 'N/A') . ")");
                } else {
                    throw new Exception("获取 jsapi_ticket 失败，微信服务器未返回有效 ticket。");
                }
            }
            return $ticket;
        } else {
            return $data->jsapi_ticket;
        }
    }

    private function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $cacheFile = $this->cacheDir . "access_token.json";
        $data = null;
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile));
        }

        if (!$data || $data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = "";
            if (isset($res->access_token)) {
                $access_token = $res->access_token;
                if ($access_token) {
                    $newData = new stdClass();
                    $newData->expire_time = time() + 7000; // 提前200秒过期
                    $newData->access_token = $access_token;
                    $fp = fopen($cacheFile, "w");
                    fwrite($fp, json_encode($newData));
                    fclose($fp);
                }
            } else {
                // 处理错误
                // error_log("Failed to get access_token: " . json_encode($res));
                if (isset($res->errmsg)) {
                    throw new Exception("获取 access_token 失败: " . $res->errmsg . " (错误码: " . (isset($res->errcode) ? $res->errcode : 'N/A') . ")");
                } else {
                    throw new Exception("获取 access_token 失败，微信服务器未返回有效 token。");
                }
            }
            return $access_token;
        } else {
            return $data->access_token;
        }
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); //严格校验
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception("cURL Error: " . $error_msg);
        }
        curl_close($curl);
        return $res;
    }
}

// --- 主逻辑：获取URL参数并返回签名包 ---
if (empty(APP_ID) || APP_ID === "在此处填入您的微信公众号AppID" || empty(APP_SECRET) || APP_SECRET === "在此处填入您的微信公众号AppSecret") {
    echo json_encode([
        "error" => true,
        "message" => "错误：请先在 wx_jssdk_helper.php 文件中配置您的 AppID 和 AppSecret。"
    ]);
    exit;
}

// 从GET请求中获取当前页面的URL，这个URL必须由前端JS动态获取并传递过来
$url = isset($_GET['url']) ? urldecode($_GET['url']) : '';

if (empty($url)) {
    echo json_encode([
        "error" => true,
        "message" => "错误：缺少 'url' 参数。请确保前端正确传递了当前页面的完整URL。"
    ]);
    exit;
}

try {
    $jssdk = new JSSDK(APP_ID, APP_SECRET);
    $signPackage = $jssdk->getSignPackage($url);
    echo json_encode($signPackage);
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "message" => $e->getMessage()
    ]);
}

?>
