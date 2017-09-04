<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 下午 17:42
 */

namespace app\api\service;


class Token
{

    // 生成令牌
    public static function generateToken()
    {
        $randChar  = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('secure.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }
}