<?php

namespace App\Service;

class Tokenhg
{
    /**
     * OPENSSL key
     * @var string
     */
    private static $key = 'WpBiYvT9e4OI8Z0n7848w0bfdr';

    /**
     * OPENSSL iv
     * @var string
     */
    private static $iv = 'EZhWr98dmc83Jnd4';

    /**
     * OPENSSL 加密方法
     * @var string
     */
    private static $method = 'AES-256-CBC';


    /**
     * 生成Token
     * @param array $data 额外数据
     * @param int $gqt 有效期天
     * @return string
     */
    public static function make(array $data, $gqt)
    {
        $time = time();
        $info['data'] = $data;
        $info['qft'] = $time;
        $info['gqt'] = $time + ($gqt * 86400);
        $token = self::encrypt(json_encode($info));
        return $token;
    }


    /**
     * 解析token字符串
     * @param string $token
     * @return array
     */
    public static function read($token)
    {
        $time = time();

        $data = json_decode(self::decrypt($token), true);

        if ($data['gqt'] > $time && $time >= $data['qft']) {
            return $data;
        }
        e('登录时效已过期！', 4003);
    }

    /**
     * OPENSSL 加密
     * @param string $val 需加密字符串
     * @return string
     */
    private static function encrypt($val)
    {
        $encrypt = openssl_encrypt($val, self::$method, self::$key, 0, self::$iv);
        return base64_encode($encrypt);
    }

    /**
     * OPENSSL 解密
     * @param string $val 需解密的字符串
     * @return string
     */
    private static function decrypt($val)
    {
        return openssl_decrypt(
            base64_decode($val),
            self::$method,
            self::$key,
            0,
            self::$iv
        );
    }
    //根据token解析用户的ID
    public static function getID(string $token):string
    {
        $tokenClass=new Tokenhg();
        $userId=$tokenClass->read($token);
        //存储用户ID;
        return $userId["data"][0];
    }
}