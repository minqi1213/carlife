<?php
/**
 * 
 * 对合作方的订单接口请求封装
 * @author wangguosheng
 * 2015-07-22
 */
class Partner_Api {

    /**
     * 去掉数组中的空字符串
     * @param $params 输入数组
     * @return array 处理过的数组
     */
    public static function trimEmptyParams($params) {
        $result = array();
        foreach ($params as $k => $v) {
            if (is_string($v)) {
                $trimstr = trim($v);
                if (strlen($trimstr) > 0) {
                    $result[$k] = $trimstr;
                }
            } elseif($v !== null && $v !== "") {
                $result[$k] = $v;
            }
        }
        return $result;
    }
    
    /**
     * 签名参数 
     * @param $arr_params array 需要签名的参数
     * @param $key 签名key
     * @return string 签名后的字符串
     */
    public static function signParams($arr_params, $key) {
        $arr_params = self::trimEmptyParams($arr_params);
        ksort($arr_params);
        $str = "";
        foreach ($arr_params as $k => $v) {
            if (!empty($str)) {
                $str .= "&";
            }
            $str .= "$k=$v";
        }
        if ($str != null && $str != '') {
            $str .= $key;
            urlencode($str);
            trim($str);
            $md5sum = md5($str);
            $result = strtoupper($md5sum);
            return $result;
        }
        return null;
    }

    /**
     * 执行curl请求;
     * @param $url -- 请求地址url;
     * @param $method -- 请求方法, post | get
     * @param $params -- 请求参数;
     * @return array | false;
     */
    public static function curl($url, $method, $params) {
        // fetchUrl调通后改用fetchUrl
        if ($method == 'get') {
            $query = http_build_query($params);
            $url = $url."?".$query;
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
        } elseif ($method == 'post') {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
        }
        self::log($url, $params, $result);
        return $result;
    }


    private static $DEBUG = true;
    /**
     * 记录赶集返回的response
     * @param $method 请求方法
     * @param $params 请求参数
     * @param $result 请求结果
     */
    private static function log($url, $params, $result) {
        if (self::$DEBUG) {
            Bd_Log::notice("[PartnerAPI] query url $url with params ".json_encode($params).
            " response : ".$result);
        }
    }
}
?>
