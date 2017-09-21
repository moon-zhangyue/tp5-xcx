<?php

namespace app\api\model;

use think\Db;
use think\Model;

class User extends BaseModel
{
    protected $autoWriteTimestamp = true;
//    protected $createTime = ;

    public function orders()
    {
        return $this->hasMany('Order', 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByOpenID($openid)
    {
//        write_log('openid:' . print_r($openid, true) . "\r\n", 'token');
//        $user = Db::query('select * from user where openid=?',[$openid]);
//        write_log('sql:' . (Db::getLastSql()) . "\r\n", 'token');
//        $user = Db::table('user')->where('openid',$openid)->find();
        $user = User::where('openid', '=', $openid)->find();
//        write_log('user:' . print_r($user, true) . "\r\n", 'token');
        return $user;
    }
}
