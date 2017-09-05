<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 下午 17:42
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{

    // 生成令牌
    public static function generateToken()
    {
        $randChar  = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT']; //当前时间的时间戳
        //salt 盐 --加密字符串
        $tokenSalt = config('secure.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }


    /*
     * 获取用户的uid
     * */
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /*
     * 获取用户token值
     * */
    public static function getCurrentTokenVar($key)
    {
        //可以使用Request对象的header方法获取当前请求的HTTP 请求头信息
        $token = Request::instance()->header('token');
        $vars  = Cache::get('token');
        if(!$vars){
            throw new TokenException();
        }else{
            if(!is_array($vars)){
                $vars = json_encode($vars,true);
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }else{
                throw new Exception('The param of Token is not exists');
            }
        }
    }

}