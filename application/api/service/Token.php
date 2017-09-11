<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4 0004
 * Time: 下午 17:42
 */

namespace app\api\service;


use think\Cache;
use think\Exception;
use think\Request;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;

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
        write_log('$key:' . print_r($key, true) . "\r\n", 'token');
        //可以使用Request对象的header方法获取当前请求的HTTP 请求头信息
        $token = Request::instance()->header('token');
        write_log('$token:' . print_r($token, true) . "\r\n", 'token');
        $vars = Cache::get('token');
        write_log('$vars:' . print_r($vars, true) . "\r\n", 'token');
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('The param of Token is not exists');
            }
        }
    }

    /*
     *验证token是否合法或者是否过期
     *验证器验证只是token验证的一种方式
     *另外一种方式是使用行为拦截token，根本不让非法token进入控制器
     * 用户和CMS管理员都有的权限
     * */
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        write_log('needPrimaryScope-->scope:' . print_r($scope, true) . "\r\n", 'token');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /*
     * 用户专有权限
     * */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        write_log('checkExclusiveScope-->scope:' . print_r($scope, true) . "\r\n", 'token');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }

    }

    /**
     * 检查操作UID是否合法
     * @param $checkedUID
     * @return bool
     * @throws Exception
     * @throws ParameterException
     */
    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID) {
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID == $checkedUID) {
            return true;
        }
        return false;
    }


}