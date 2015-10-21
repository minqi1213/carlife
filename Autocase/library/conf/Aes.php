<?php

/**
 * Created by PhpStorm.
 * Date: 15/8/27
 * Time: 上午10:18
 */
class Conf_Aes
{
    const CIPHER = MCRYPT_RIJNDAEL_128;

    const MODE = MCRYPT_MODE_ECB;

    /**
     * 加密
     * @param string $key 密钥
     * @param string $str 需加密的字符串
     * @return type
     */
    static public function encode($key, $str)
    {
        $str = str_pad($str, ceil(strlen($str) / 16.0) * 16, " ");
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER, self::MODE), MCRYPT_RAND);
        $encode =  mcrypt_encrypt(self::CIPHER, $key, $str, self::MODE, $iv);
        $encode = base64_encode($encode);
        return $encode;
    }

    /**
     * 解密
     * @param string $key
     * @param string $str
     * @return string 解密后的字符串
     */
    static public function decode($key, $str)
    {
        $str = base64_decode($str);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER, self::MODE), MCRYPT_RAND);
        $result = mcrypt_decrypt(self::CIPHER, $key, $str, self::MODE, $iv);
        $result = rtrim($result);
        return $result;
    }
}