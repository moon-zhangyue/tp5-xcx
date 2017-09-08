<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 下午 16:28
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\AppTokenGet;
use app\api\validate\TokenGet;
use think\Log;

class Token
{
    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code = '')
    {
//        write_log('code:'.$code."\r\n",'token');
        $model = new TokenGet();
        $res = $model->goCheck();
//        write_log('res:'.print_r($res,true)."\r\n",'token');
        $wx    = new UserToken($code);
        $token = $wx->get($code);
//        write_log('token:'.print_r($token,true)."\r\n",'token');
        return [
            'token' => $token
        ];
    }

    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac = '', $se = '')
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET');
        write_log('file:测试'."\r\n",'token');
//        writeLog('datalist','add_order_passlog','modelorder_passlog');die;
        $model = new AppTokenGet();
        $model->goCheck();
        $app   = new AppToken();
        $token = $app->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    public function verifyToken($token = '')
    {
        if (!$token) {
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }

}
