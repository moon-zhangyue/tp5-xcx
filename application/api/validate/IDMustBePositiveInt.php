<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/22 0022
 * Time: 上午 10:34
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
}