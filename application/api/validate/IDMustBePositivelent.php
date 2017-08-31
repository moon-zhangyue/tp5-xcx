<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/21 0021
 * Time: 下午 14:03
 */

namespace app\api\validate;


use think\Validate;

class IDMustBePositivelent extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'ids' => 'id必须是正整数'
    ];

}