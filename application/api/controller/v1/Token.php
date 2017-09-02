<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2 0002
 * Time: 下午 16:28
 */

namespace app\api\controller\v1;


use app\api\validate\TokenGet;

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
        $model = new TokenGet();
        $model->goCheck();
        $wx    = new UserToken($code);
        $token = $wx->get();
        return $token;
//        return [
//            'token' => $token
//        ];
    }

}