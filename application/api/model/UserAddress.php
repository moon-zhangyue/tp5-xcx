<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5 0005
 * Time: 下午 17:55
 */

namespace app\api\model;
use think\Model;

class UserAddress extends BaseModel
{
    protected $hidden =['id', 'delete_time', 'user_id'];
}