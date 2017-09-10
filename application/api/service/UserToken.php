<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 下午 16:47
 */

namespace app\api\service;


use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;
use app\lib\enum\ScopeEnum;

use app\lib\exception\TokenException;
use think\Model;

class UserToken extends Token
{

    protected $code;
    protected $wxLoginUrl;
    protected $wxAppID;
    protected $wxAppSecret;

    function __construct($code)
    {
        $this->code        = $code;
        $this->wxAppID     = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl  = sprintf(
            config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    /**
     * 登陆
     * 思路1：每次调用登录接口都去微信刷新一次session_key，生成新的Token，不删除久的Token
     * 思路2：检查Token有没有过期，没有过期则直接返回当前Token
     * 思路3：重新去微信刷新session_key并删除当前Token，返回新的Token
     */
    public function get($code)
    {
        $result = curl_get($this->wxLoginUrl); //发送http请求

        // 注意json_decode的第二个参数true
        // 这将使字符串被转化为数组而非对象

        $wxResult = json_decode($result, true);
        write_log('wxResult:' . print_r($wxResult, true) . "\r\n", 'token');
        if (empty($wxResult)) {
            // 为什么以empty判断是否错误，这是根据微信返回
            // 规则摸索出来的
            // 这种情况通常是由于传入不合法的code
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        } else {
            // 建议用明确的变量来表示是否成功
            // 微信服务器并不会将错误标记为400，无论成功还是失败都标记成200
            // 这样非常不好判断，只能使用errcode是否存在来判断
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult); //返回
            }
        }
    }

    /*
     * 颁发令牌
     * */
    private function grantToken($wxResult)
    {
        //1.拿到openid
        $openid = $wxResult['openid'];
        write_log('openid:' . print_r($openid, true) . "\r\n", 'token');
        //2.查看数据库,openid是否存在
        $user = UserModel::getByOpenID($openid);
        write_log('user:' . print_r($user, true) . "\r\n", 'token');
        //3.如果存在 则不处理, 不存在新增一条user数据
        if ($user) {
            $uid = $user->id;
            write_log('存在的uid:' . print_r($uid, true) . "\r\n", 'token');
        } else {
            $uid = $this->newUser($openid);
            write_log('新的uid:' . print_r($uid, true) . "\r\n", 'token');
        }

        //4.生成令牌,准备缓存数据,写入缓存
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        write_log('cachedValue:' . print_r($cachedValue, true) . "\r\n", 'token');

        //key 令牌--value : wxResult,uid,scope权限--作用域 数字越大,权限越大
        $token = $this->saveToCache($cachedValue);
        write_log('这是返回的token:' . print_r($token, true) . "\r\n", 'token');
        //5.把令牌返回到客户端去
        return $token;
    }

    public function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue          = $wxResult;
        $cachedValue['uid']   = $uid;
        $cachedValue['scope'] = ScopeEnum::User;  //作用域
//        $cachedValue['scope'] = 15;  //作用域 app用户的权限数值  32 CMS(管理员)的权限数值
        return $cachedValue;
    }

    // 写入缓存
    private function saveToCache($wxResult)
    {
        $key = self::generateToken(); //调用基类方法
        write_log('key:' . print_r($key, true) . "\r\n", 'token');
        $value     = json_encode($wxResult);
        write_log('$value:' . print_r($value, true) . "\r\n", 'token');
        $expire_in = config('setting.token_expire_in');  //缓存时间
        write_log('$expire_in:' . print_r($expire_in, true) . "\r\n", 'token');
        $result    = cache('token', $value, $expire_in); //--自带缓存方法
        write_log('$result:' . print_r($result, true) . "\r\n", 'token');

        if (!$result) {
            throw new TokenException([
                'msg'       => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }


    /*
     * 写入记录
     * */
    private function newUser($openid)
    {
        $user = UserModel::create(array('openid' => $openid));
        return $user->id;
    }

    // 处理微信登陆异常
    // 哪些异常应该返回客户端，哪些异常不应该返回客户端
    private function processLoginError($wxResult)
    {
        throw new WeChatException(
            [
                'msg'       => $wxResult['errmsg'],
                'errorCode' => $wxResult['errcode']
            ]);
    }

}