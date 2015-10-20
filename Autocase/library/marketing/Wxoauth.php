<?php

/**
 * Created by PhpStorm.
 * User: wangguosheng
 * Date: 15/8/7
 * Time: 下午3:56
 */
class Marketing_Wxoauth
{
    private static $host = 'https://api.weixin.qq.com';

    /**
     * 直接通过code来获取用户信息
     * @param $code -- 微信授权后拿到的code
     * @return array | false
     */
    public static function getUserInfoByCode($code) {
        if (isset($code)) {
            // 微信用户, 获取token和头像;
            $result = self::getAccessToken($code);
            if ($result) {
                $openid = $result['openid'];
                $token = $result['access_token'];
                $result = self::getUserInfo($openid, $token);
            }
            return $result;
        }
        return false;
    }

    /**
     * 通过code获取Access Token
     * @param $code --微信客户端返回的code
     * @return array | false
     */
    public static function getAccessToken($code) {
        // ral_set_pathinfo('/sns/oauth2/access_token');
        $url = self::$host.'/sns/oauth2/access_token';
        $appid = Bd_Conf::getAppConf('weixin/appid');
        $secret = Bd_Conf::getAppConf('weixin/secret');
        $params['appid'] = $appid;
        $params['secret'] = $secret;
        $params['code'] = $code;
        $params['grant_type'] = 'authorization_code';
        // $response = ral('weixin', 'get', $params);
        $response = self::curl($url, 'get', $params);
        $result = json_decode($response, true);
        if (is_array($result) && $result['errcode'] != 0) {
            return false;
        }
        return $result;
    }

    /**
     * 获取用户信息
     * @param $openId -- 用户的openId
     * @param $token -- Access Token.
     * @return array | false;
     */
    public static function getUserInfo($openId, $token) {
        $url = self::$host.'/sns/userinfo';
        $params['access_token'] = $token;
        $params['openid'] = $openId;
        $response = self::curl($url, 'get', $params);
        $result = json_decode($response, true);
        if (is_array($result) && $result['errcode'] != 0) {
            return false;
        }
        return $result;
    }

    /**
     * 执行curl请求;
     * @param $url -- 请求地址url;
     * @param $method -- 请求方法, post | get
     * @param $params -- 请求参数;
     * @return array | false;
     */
    public static function curl($url, $method, $params) {
        if ($method == 'get') {
            $query = http_build_query($params);
            $url = $url."?".$query;
            $result = self::fetch($url);
        } elseif ($method == 'post') {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
        }
        return $result;
    }

    /**
     * 通过fetch url访问网络
     * @param $url --请求链接
     * @return string | null -- 请求结果
     */
    public static function fetch($url) {
        $httpproxy = Orp_FetchUrl::getInstance(array('timeout' =>30000,'conn_timeout' =>10000,'max_response_size'=> 1024000));
        $res = $httpproxy->get($url);
        $err = $httpproxy->errmsg();
        $http_code = $httpproxy->http_code();
        if ($http_code != 200) {
            Bd_Log::warning("fetch url failed, $http_code, $err");
            return null;
        }
        Bd_Log::notice("[Wxoauth] url : $url response : $res");
        return $res;
    }
}
