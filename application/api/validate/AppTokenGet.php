<?php
/**
 * Created by PhpStorm.
 * User: Moon
 * Date: 2017/9/5
 * Time: 22:20
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty'
    ];
}